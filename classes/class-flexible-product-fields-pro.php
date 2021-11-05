<?php

/**
 * Class FPF_PRO
 */
class FPF_PRO {

	/**
	 * Flexible_Product_Fields_PRO_Plugin $plugin Plugin instance
	 *
	 * @var Flexible_Product_Fields_PRO_Plugin
	 */
	private $plugin = null;

	/**
	 * FPF_PRO constructor.
	 *
	 * @param Flexible_Product_Fields_PRO_Plugin $plugin Plugin instance.
	 */
	public function __construct( Flexible_Product_Fields_PRO_Plugin $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Fires hooks
	 */
	public function hooks() {
		add_filter( 'flexible_product_fields_sort_groups_posts', array( $this, 'flexible_product_fields_sort_groups_posts' ) );
		add_filter( 'flexible_product_fields_field_types', array( $this, 'flexible_product_fields_field_types' ) );
		add_filter( 'flexible_product_fields_assign_to_options', array( $this, 'flexible_product_fields_assign_to_options' ), 11 );
		add_filter( 'woocommerce_form_field_fpfdate', array( $this, 'woocommerce_form_field_fpfdate' ), 999, 4 );
		add_filter( 'flexible_product_fields_apply_logic_rules', array( $this, 'flexible_product_fields_apply_logic_rules' ), 10, 2 );
	}

	/**
	 * Apply logic rules
	 *
	 * @param array $fields    List of fields.
	 * @param array $post_data Post data.
	 *
	 * @return mixed
	 */
	public function flexible_product_fields_apply_logic_rules( $fields, $post_data ) {
		$unset_field = true;
		while ( $unset_field ) {
			$unset_field = false;
			foreach ( $fields['fields'] as $field_key => $field ) {
				$value = null;
				if ( isset( $field['logic'] ) && 1 === intval( $field['logic'] ) ) {
					$show_field = true;
					$logic_operator = $field['logic_operator'];
					if ( $logic_operator == 'or' ) {
						$show_field = false;
					}
					foreach ( $field['logic_rules'] as $field_rule ) {
						$compare = $field_rule['compare'];
						$value = '';
						if ( isset( $post_data[ $field_rule['field'] ] ) ) {
							$value = $post_data[ $field_rule['field'] ];
						}
						if ( $field_rule['field_value'] == 'checked' && $value != '' ) {
							$value = 'checked';
						}
						if ( $field_rule['field_value'] == 'unchecked' && $value == '' ) {
							$value = 'unchecked';
						}
						$field_is_visible = false;
						foreach ( $fields['fields'] as $visible_field ) {
							if ( $visible_field['id'] == $field_rule['field'] ) {
								$field_is_visible = true;
							}
						}
						if ( ! $field_is_visible ) {
							$value = $field_rule['field_value'] . '1';
						}
						$compare_result = $field_rule['field_value'] == $value;
						if ( $compare == 'is_not' ) {
							$compare_result = ! $compare_result;
						}
						if ( $logic_operator == 'or' ) {
							$show_field = $show_field || $compare_result;
						}
						if ( $logic_operator == 'and' ) {
							$show_field = $show_field && $compare_result;
						}
					}
					if ( ! $show_field ) {
						$unset_field = true;
						unset( $fields['fields'][ $field_key ] );
					}
				}
			}
		}

		return $fields;
	}

	public function woocommerce_form_field_fpfdate( $no_parameter, $key, $args, $value ) {
		$args['type']    = 'text';
		$args['class'][] = 'load-datepicker';
		$args['return']  = true;
		return woocommerce_form_field( $key, $args, $value );
	}

	/**
	 * @param $a WP_Post
	 * @param $b WP_Post
	 */
	public function sort_groups_posts_cmp( $a, $b ) {
		return $a->menu_order > $b->menu_order;
	}

	public function flexible_product_fields_sort_groups_posts( $posts ) {
		if ( ! is_array( $posts ) ) {
			return $posts;
		}
		usort( $posts, array( $this, 'sort_groups_posts_cmp' ) );

		return $posts;
	}

	public function flexible_product_fields_field_types( array $field_types ) {
		foreach ( $field_types as $key => $field_type ) {
			if ( $field_type['value'] == 'text'
			     || $field_type['value'] == 'textarea'
			     || $field_type['value'] == 'number'
			     || $field_type['value'] == 'checkbox'
			     || $field_type['value'] == 'fpfdate'
			) {
				$field_types[ $key ]['has_price'] = true;
				$field_types[ $key ]['price_not_available'] = false;
			}
			if ( $field_type['value'] == 'select'
			     || $field_type['value'] == 'multiselect'
			     || $field_type['value'] == 'radio'
			     || $field_type['value'] == 'radio-images'
			) {
				$field_types[ $key ]['has_price_in_options'] = true;
				$field_types[ $key ]['price_not_available_in_options'] = false;
			}
			$field_types[ $key ]['is_available'] = true;
			$field_types[ $key ]['has_logic'] = true;
			$field_types[ $key ]['logic_not_available'] = false;
		}

		return $field_types;
	}

	public function flexible_product_fields_assign_to_options( $fpf_assign_to_options ) {
		$fpf_assign_to_options = array(
			array( 'value' => 'product', 'label' => __( 'Product', 'flexible-product-fields' ), 'is_available' => true ),
			array( 'value' => 'category', 'label' => __( 'Category', 'flexible-product-fields-pro' ), 'is_available' => true ),
			array( 'value' => 'tag', 'label' => __( 'Tag', 'flexible-product-fields-pro' ), 'is_available' => true ),
			array( 'value' => 'all', 'label' => __( 'All products', 'flexible-product-fields' ), 'is_available' => true ),
		);

		return $fpf_assign_to_options;
	}

}
