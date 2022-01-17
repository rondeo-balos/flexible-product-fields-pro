<?php

namespace WPDesk\FPF\Pro\Field\Type;

use WPDesk\FPF\Free\Field\Type\FileType as DefaultFileType;
use WPDesk\FPF\Free\Settings\Option\CssOption;
use WPDesk\FPF\Free\Settings\Option\FieldLabelOption;
use WPDesk\FPF\Free\Settings\Option\FieldNameOption;
use WPDesk\FPF\Free\Settings\Option\FieldPriorityOption;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Option\RequiredOption;
use WPDesk\FPF\Free\Settings\Option\TooltipOption;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FPF\Free\Settings\Tab\GeneralTab;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Free\Settings\Tab\PricingTab;
use WPDesk\FPF\Pro\Field\File\FileUploader;
use WPDesk\FPF\Pro\Field\File\PreviewGenerator;
use WPDesk\FPF\Pro\Settings\Option\AllowedExtensionsOption;
use WPDesk\FPF\Pro\Settings\Option\FileSizeOption;
use WPDesk\FPF\Pro\Settings\Option\FilesLimitOption;
use WPDesk\FPF\Pro\Settings\Option\LogicEnabledOption;
use WPDesk\FPF\Pro\Settings\Option\LogicOperatorOption;
use WPDesk\FPF\Pro\Settings\Option\LogicRulesOption;
use WPDesk\FPF\Pro\Settings\Option\PriceTypeOption;
use WPDesk\FPF\Pro\Settings\Option\PriceValueOption;

/**
 * .
 */
class FileType extends DefaultFileType {

	/**
	 * @var FileUploader
	 */
	private $file_uploader;

	/**
	 * @var PreviewGenerator
	 */
	private $preview_generator;

	public function __construct( FileUploader $file_uploader = null, PreviewGenerator $preview_generator = null ) {
		$this->file_uploader     = $file_uploader ?: new FileUploader();
		$this->preview_generator = $preview_generator ?: new PreviewGenerator();
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_template_vars( array $field_data ): array {
		$template_vars = parent::get_field_template_vars( $field_data );
		$field_name    = $field_data[ FieldNameOption::FIELD_NAME ];

		$template_vars['files_limit']       = $field_data[ FilesLimitOption::FIELD_NAME ];
		$template_vars['allowed_mimes']     = $field_data[ AllowedExtensionsOption::FIELD_NAME ];
		$template_vars['value_filenames']   = ( isset( $_POST[ $field_name . '_file' ] ) ) // phpcs:ignore WordPress.Security
			? array_filter( $_POST[ $field_name . '_file' ] ?: [] ) // phpcs:ignore WordPress.Security
			: [];
		$template_vars['value_request_ids'] = ( isset( $_POST[ $field_name ] ) ) // phpcs:ignore WordPress.Security
			? array_filter( $_POST[ $field_name ] ?: [] ) // phpcs:ignore WordPress.Security
			: [];

		return $template_vars;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_value( string $field_id, bool $is_request = false ) {
		$form_data = ( $is_request ) ? $_REQUEST : $_POST; // phpcs:ignore
		if ( ! isset( $form_data[ $field_id ] ) || ! is_array( $form_data[ $field_id ] ) ) {
			return null;
		}

		$file_ids = [];
		foreach ( $form_data[ $field_id ] as $file_id ) {
			$request_id = sanitize_text_field( $file_id );
			if ( ! $request_id || ! $this->file_uploader->move_tmp_file_to_target( $request_id ) ) {
				continue;
			}

			$file_ids[] = sprintf(
				'<a href="%1$s" target="_blank">%2$s</a>',
				$this->preview_generator->get_file_url( $request_id ),
				str_replace(
					$request_id . '-',
					'',
					basename( $this->file_uploader->get_saved_file_path( $request_id ) )
				)
			);
		}

		return ( $file_ids ) ?: [ '' ];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return [
			GeneralTab::TAB_NAME  => [
				FieldPriorityOption::FIELD_NAME => new FieldPriorityOption(),
				FieldTypeOption::FIELD_NAME     => new FieldTypeOption(),
				FieldLabelOption::FIELD_NAME    => new FieldLabelOption(),
				RequiredOption::FIELD_NAME      => new RequiredOption(),
				CssOption::FIELD_NAME           => new CssOption(),
				TooltipOption::FIELD_NAME       => new TooltipOption(),
				FieldNameOption::FIELD_NAME     => new FieldNameOption(),
			],
			AdvancedTab::TAB_NAME => [
				FilesLimitOption::FIELD_NAME        => new FilesLimitOption(),
				AllowedExtensionsOption::FIELD_NAME => new AllowedExtensionsOption(),
				FileSizeOption::FIELD_NAME          => new FileSizeOption(),
			],
			PricingTab::TAB_NAME  => [
				PriceTypeOption::FIELD_NAME  => new PriceTypeOption(),
				PriceValueOption::FIELD_NAME => new PriceValueOption(),
			],
			LogicTab::TAB_NAME    => [
				LogicEnabledOption::FIELD_NAME  => new LogicEnabledOption(),
				LogicOperatorOption::FIELD_NAME => new LogicOperatorOption(),
				LogicRulesOption::FIELD_NAME    => new LogicRulesOption(),
			],
		];
	}
}
