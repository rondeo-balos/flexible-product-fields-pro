<?php

namespace WPDesk\FPF\Pro\Field\File;

use WPDesk\FPF\Pro\Exception\FailedFilenameGenerationException;
use WPDesk\FPF\Pro\Exception\FailedFileUploadException;
use WPDesk\FPF\Pro\Exception\InvalidRequestParamException;
use WPDesk\FPF\Pro\Exception\InvalidUploadedFileException;
use WPDesk\FPF\Pro\Settings\Option\AllowedExtensionsOption;
use WPDesk\FPF\Pro\Settings\Option\FileSizeOption;

/**
 * .
 */
class FileUploader {

	const DIRECTORY_FILES_PATH = '/woocommerce_uploads/flexible-product-fields/files';
	const DIRECTORY_TEMP_PATH  = '/woocommerce_uploads/flexible-product-fields/tmp';

	/**
	 * @var string|null
	 */
	private $request_id = null;

	/**
	 * @throws InvalidRequestParamException
	 * @throws InvalidUploadedFileException
	 * @throws FailedFileUploadException
	 * @throws FailedFilenameGenerationException
	 */
	public function upload_file( array $file_data = null, int $field_group_id = null, string $field_id = null ): string {
		if ( ( $file_data === null ) || $file_data['error'] ) {
			throw new InvalidRequestParamException(
				__( 'An error occurred while uploading the file.', 'flexible-product-fields-pro' )
			);
		}

		$field_settings = $this->get_field_settings( $field_group_id, $field_id );
		if ( $field_settings === null ) {
			throw new InvalidRequestParamException(
				__( 'An error occurred while uploading the file.', 'flexible-product-fields-pro' )
			);
		}

		if ( ! in_array( $file_data['type'], $field_settings[ AllowedExtensionsOption::FIELD_NAME ] ) ) {
			throw new InvalidUploadedFileException(
				__( 'Invalid type of the uploaded file.', 'flexible-product-fields-pro' )
			);
		}

		$extension          = strtolower( pathinfo( $file_data['name'], PATHINFO_EXTENSION ) );
		$mime_types         = array_flip( wp_get_mime_types() );
		$allowed_extensions = explode( '|', $mime_types[ $file_data['type'] ] ?? '' );
		if ( ! in_array( $extension, $allowed_extensions ) ) {
			throw new InvalidUploadedFileException(
				__( 'Invalid extension of the uploaded file.', 'flexible-product-fields-pro' )
			);
		}

		$filesize = $field_settings[ FileSizeOption::FIELD_NAME ] ?? 0;
		if ( ( $filesize > 0 ) && ( ( $filesize * 1024 * 1024 ) < $file_data['size'] ) ) {
			throw new InvalidUploadedFileException(
				sprintf(
				/* translators: %s: file size */
					__( 'The maximum allowed file weight is %sMB.', 'flexible-product-fields-pro' ),
					$filesize
				)
			);
		}

		try {
			$unique_id         = $this->generate_unique_id();
			$file_data['name'] = $this->generate_filename( $file_data );

			$this->save_file_to_uploads( $file_data, $unique_id );
			return $unique_id;
		} catch ( FailedFileUploadException $e ) {
			throw $e;
		} catch ( FailedFilenameGenerationException $e ) {
			throw $e;
		}
	}

	public function get_tmp_directory_path(): string {
		add_filter( 'upload_dir', [ $this, 'update_temp_directory_path' ] );
		$directory_data = wp_upload_dir();
		remove_filter( 'upload_dir', [ $this, 'update_temp_directory_path' ] );

		return $directory_data['path'];
	}

	public function get_saved_directory_path(): string {
		add_filter( 'upload_dir', [ $this, 'update_files_directory_path' ] );
		$directory_data = wp_upload_dir();
		remove_filter( 'upload_dir', [ $this, 'update_files_directory_path' ] );

		return $directory_data['path'];
	}

	public function move_tmp_file_to_target( string $request_id ): bool {
		$source_path = $this->get_tmp_file_path( $request_id );
		if ( ! $source_path ) {
			return ( $this->get_saved_file_path( $request_id ) !== null );
		}

		$this->request_id = $request_id;
		$output_path = sprintf( '%1$s/%2$s', $this->get_saved_directory_path(), basename( $source_path ) );
		$this->request_id = null;

		$this->create_index_file( dirname( dirname( $output_path ) ) );

		$status = copy( $source_path, $output_path );
		unlink( $source_path ) && rmdir( dirname( $source_path ) );

		return $status;
	}

	/**
	 * @return string|null
	 */
	public function get_tmp_file_path( string $request_id = null ) {
		return $this->get_file_path( $this->get_tmp_directory_path(), $request_id );
	}

	/**
	 * @return string|null
	 */
	public function get_saved_file_path( string $request_id = null ) {
		return $this->get_file_path( $this->get_saved_directory_path(), $request_id );
	}

	/**
	 * @return string|null
	 */
	private function get_file_path( string $directory_path, string $request_id = null ) {
		if ( ! $request_id ) {
			return null;
		}

		$path_pattern = sprintf( '%1$s/%2$s/*', $directory_path, $request_id );
		$files        = glob( $path_pattern );
		if ( ! $files ) {
			return null;
		}

		return $files[0];
	}

	/**
	 * @param int    $field_group_id .
	 * @param string $field_id       .
	 *
	 * @return array|null
	 */
	private function get_field_settings( int $field_group_id = null, string $field_id = null ) {
		$group_fields = get_post_meta( $field_group_id, '_fields', true );
		if ( ! $group_fields || ! is_array( $group_fields ) ) {
			return null;
		}

		foreach ( $group_fields as $field_data ) {
			if ( $field_data['id'] === $field_id ) {
				return $field_data;
			}
		}

		return null;
	}

	/**
	 * @throws FailedFilenameGenerationException
	 */
	private function generate_unique_id(): string {
		try {
			return bin2hex( random_bytes( 16 ) );
		} catch ( \Exception $e ) {
			throw new FailedFilenameGenerationException();
		}
	}

	private function generate_filename( array $file_data ): string {
		$extension = pathinfo( $file_data['name'], PATHINFO_EXTENSION );

		return sprintf(
			'%1$s.%2$s',
			mb_substr( basename( $file_data['name'], '.' . $extension ), 0, 128 ),
			$extension
		);
	}

	/**
	 * @return void
	 *
	 * @throws FailedFileUploadException
	 */
	private function save_file_to_uploads( array $file, string $request_id ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$this->request_id = $request_id;
		add_filter( 'upload_dir', [ $this, 'update_temp_directory_path' ] );

		$uploaded_file = wp_handle_upload(
			$file,
			[
				'test_form' => false,
			]
		);

		$this->request_id = null;
		remove_filter( 'upload_dir', [ $this, 'update_temp_directory_path' ] );

		if ( isset( $uploaded_file['error'] ) ) {
			throw new FailedFileUploadException(
				__( 'An error occurred while uploading the file.', 'flexible-product-fields-pro' )
			);
		}

		$this->create_index_file( dirname( dirname( $uploaded_file['file'] ) ), 2 );
	}

	/**
	 * @internal
	 */
	public function update_temp_directory_path( array $path_data ): array {
		return $this->update_directory_path( $path_data, self::DIRECTORY_TEMP_PATH );
	}

	/**
	 * @internal
	 */
	public function update_files_directory_path( array $path_data ): array {
		return $this->update_directory_path( $path_data, self::DIRECTORY_FILES_PATH );
	}

	private function update_directory_path( array $path_data, string $directory_path ): array {
		if ( $this->request_id !== null ) {
			$directory_path .= '/' . $this->request_id;
		}

		$path_data['path']   = str_replace( $path_data['subdir'], $directory_path, $path_data['path'] );
		$path_data['url']    = str_replace( $path_data['subdir'], $directory_path, $path_data['url'] );
		$path_data['subdir'] = str_replace( $path_data['subdir'], $directory_path, $path_data['subdir'] );

		return $path_data;
	}

	private function create_index_file( string $directory_path, int $nested_directories = 1 ) {
		if ( $nested_directories < 1 ) {
			return;
		}

		$file_path = $directory_path . '/index.html';
		if ( ! file_exists( $file_path ) ) {
			$file = fopen( $file_path, 'w' );
			fwrite( $file, '' );
			fclose( $file );
		}

		$this->create_index_file( dirname( $directory_path ), ( $nested_directories - 1 ) );
	}
}
