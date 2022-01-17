<?php

namespace WPDesk\FPF\Pro\Settings\Form;

use WPDesk\FPF\Free\Settings\Form\GroupSettingsForm as GroupSettingsFormDefault;
use WPDesk\FPF\Free\Settings\Option\GroupAdvOption;
use WPDesk\FPF\Pro\Settings\Option\GroupAssignOption;
use WPDesk\FPF\Pro\Settings\Option\GroupCategoriesOption;
use WPDesk\FPF\Pro\Settings\Option\GroupOrderOption;
use WPDesk\FPF\Pro\Settings\Option\GroupTagsOption;

/**
 * {@inheritdoc}
 */
class GroupSettingsForm extends GroupSettingsFormDefault {

	/**
	 * {@inheritdoc}
	 */
	public function get_form_data( array $form_data, \WP_Post $post ): array {
		$section_fields = [
			GroupCategoriesOption::FIELD_NAME => get_post_meta( $post->ID, '_' . GroupCategoriesOption::FIELD_NAME, false ) ?: [],
			GroupTagsOption::FIELD_NAME       => get_post_meta( $post->ID, '_' . GroupTagsOption::FIELD_NAME, false ) ?: [],
			GroupOrderOption::FIELD_NAME      => $post->menu_order,
		];

		$option_objects = $this->get_options_list();
		foreach ( $option_objects as $field_option ) {
			if ( ! isset( $section_fields[ $field_option->get_option_name() ] ) ) {
				continue;
			}

			$form_data = $field_option->update_field_data( $form_data, $section_fields );
		}

		return $form_data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_form_data( \WP_Post $post ) {
		$values           = $this->get_posted_data();
		$settings_options = $this->parse_posted_values( $values );

		delete_post_meta( $post->ID, '_' . GroupCategoriesOption::FIELD_NAME );
		foreach ( $settings_options[ GroupCategoriesOption::FIELD_NAME ] as $category_id ) {
			add_post_meta( $post->ID, '_' . GroupCategoriesOption::FIELD_NAME, $category_id );
		}

		delete_post_meta( $post->ID, '_' . GroupTagsOption::FIELD_NAME );
		foreach ( $settings_options[ GroupTagsOption::FIELD_NAME ] as $tag_id ) {
			add_post_meta( $post->ID, '_' . GroupTagsOption::FIELD_NAME, $tag_id );
		}

		wp_update_post(
			[
				'ID'         => $post->ID,
				'menu_order' => $settings_options[ GroupOrderOption::FIELD_NAME ],
			]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_list(): array {
		$options = parent::get_options_list();

		if ( class_exists( 'WPDesk\FPF\Free\Settings\Option\GroupAdvOption' ) ) {
			$options = array_filter(
				$options,
				function ( $option ) {
					return ( $option->get_option_name() !== GroupAdvOption::FIELD_NAME );
				}
			);
		}

		$options[] = new GroupAssignOption();
		$options[] = new GroupCategoriesOption();
		$options[] = new GroupTagsOption();
		$options[] = new GroupOrderOption();

		return $options;
	}
}
