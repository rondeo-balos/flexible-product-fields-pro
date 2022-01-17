<?php

namespace WPDesk\FPF\Pro\Field\File;

use FPFProVendor\WPDesk\PluginBuilder\Plugin\Hookable;

/**
 * .
 */
class PreviewGenerator implements Hookable {

	const REWRITE_ENDPOINT_PREFIX = 'flexible-product-fields';

	/**
	 * @var FileUploader
	 */
	private $file_uploader;

	public function __construct( FileUploader $file_uploader = null ) {
		$this->file_uploader = $file_uploader ?: new FileUploader();
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'query_vars', [ $this, 'set_rewrite_query_var' ] );
		add_action( 'init', [ $this, 'register_rewrite_endpoint' ] );
		add_action( 'template_redirect', [ $this, 'load_file_preview' ] );
	}

	public function get_file_url( string $request_id ): string {
		return sprintf(
			'%1$s/%2$s/%3$s',
			get_home_url(),
			self::REWRITE_ENDPOINT_PREFIX,
			$request_id
		);
	}

	/**
	 * @internal
	 */
	public function set_rewrite_query_var( array $vars ): array {
		$vars[] = self::REWRITE_ENDPOINT_PREFIX;
		return $vars;
	}

	/**
	 * @return void
	 *
	 * @internal
	 */
	public function register_rewrite_endpoint() {
		global $wp_rewrite;

		add_rewrite_endpoint( self::REWRITE_ENDPOINT_PREFIX, EP_ALL );
		$wp_rewrite->flush_rules();
	}

	/**
	 * @return void
	 */
	public function load_file_preview() {
		$request_id = get_query_var( self::REWRITE_ENDPOINT_PREFIX );
		if ( ! $request_id ) {
			return;
		}

		$file_path = $this->file_uploader->get_saved_file_path( $request_id );
		if ( $file_path === null ) {
			wp_die(
				wp_kses_post(
					__( 'Sorry, you are not allowed to access this page.', 'flexible-product-fields-pro' )
				),
				404
			);
		}

		header( 'Content-type: ' . mime_content_type( $file_path ), true, 200 );
		header( 'Content-Disposition: filename=' . basename( $file_path ) );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
		readfile( $file_path );

		die();
	}
}
