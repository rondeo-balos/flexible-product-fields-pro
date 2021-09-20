<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Class FPF_PRO_Duplicate
 */
class FPF_PRO_Duplicate {

	const PRIORITY_AFTER_DEFAULT = 11;

	const POST_TYPE_FPF_FIELDS = 'fpf_fields';

	const ACTION_DUPLICATE = 'duplicate';

	const ACTION_FPF_DUPLICATE_POST_AS_DRAFT = 'fpf_duplicate_post_as_draft';

	const POST_META_FIELD_FIELDS = '_fields';

	const FIELD_ID_MIN = 1000000;
	const FIELD_ID_MAX = 9999999;

	const KEY_ID = 'id';
	const KEY_FIELD = 'field';
	const KEY_LOGIC_RULES = 'logic_rules';

	/**
	 * Plugin.
	 * @var Flexible_Product_Fields_PRO_Plugin
	 */
	private $plugin = null;

	/**
	 * FPF_PRO_Duplicate constructor.
	 *
	 * @param Flexible_Product_Fields_PRO_Plugin $plugin Plugin.
	 */
	public function __construct( Flexible_Product_Fields_PRO_Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_filter( 'post_row_actions', array( $this, 'post_row_actions' ), self::PRIORITY_AFTER_DEFAULT, 2 );
		add_action( 'admin_action_' . self::ACTION_FPF_DUPLICATE_POST_AS_DRAFT, array(
			$this,
			'admin_action_fpf_duplicate_post_as_draft',
		) );
	}

	/**
	 * Duplicate post as draft.
	 */
	public function admin_action_fpf_duplicate_post_as_draft() {

		if ( ! current_user_can( 'edit_posts' ) ) {
			die( esc_html( __( 'Insufficient privileges!' ), 'flexible-product-fields-pro' ) );
		}

		if ( ! ( isset( $_GET['source_post'] ) || isset( $_POST['source_post'] ) || ( isset( $_REQUEST['action'] ) && self::ACTION_FPF_DUPLICATE_POST_AS_DRAFT === $_REQUEST['action'] ) ) ) {
			wp_die( esc_html( __( 'No fields to duplicate has been supplied!', 'flexible-product-fields-pro' ) ) );
		}

		$source_post = $this->get_source_post();

		/*
		 * if source_post data exists, create the source_post duplicate
		 */
		if ( isset( $source_post ) && null !== $source_post ) {

			$new_post_id = $this->duplicate_post( $source_post );

			$this->set_new_post_taxonomies( $source_post, $new_post_id );

			$this->duplicate_post_meta( $source_post, $new_post_id );

			$this->rebuild_fields_ids( $new_post_id );

			/*
			 * finally, redirect to the edit source_post screen for the new draft
			 */
			wp_safe_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
			exit;
		} else {
			// Translators: post_id.
			wp_die( esc_html( sprintf( __( 'Fields creation failed, could not find original fields: %s.', 'flexible-product-fields-pro' ), $source_post->ID ) ) );
		}
	}

	/**
	 * Get source post.
	 * @return null|WP_Post
	 */
	private function get_source_post() {
		$post_id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		$source_post = get_post( $post_id );

		return $source_post;
	}

	/**
	 * Insert new post from post data.
	 *
	 * @param WP_Post $source_post Source post.
	 *
	 * @return int|WP_Error
	 */
	private function duplicate_post( $source_post ) {

		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;

		$args = array(
			'comment_status' => $source_post->comment_status,
			'ping_status'    => $source_post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $source_post->post_content,
			'post_excerpt'   => $source_post->post_excerpt,
			'post_name'      => $source_post->post_name,
			'post_parent'    => $source_post->post_parent,
			'post_password'  => $source_post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $source_post->post_title . __( ' (copy) ', 'flexible-product-fields-pro' ),
			'post_type'      => $source_post->post_type,
			'to_ping'        => $source_post->to_ping,
			'menu_order'     => $source_post->menu_order,
		);

		$new_post_id = wp_insert_post( $args );

		return $new_post_id;

	}

	/**
	 * Set new post taxonomies.
	 *
	 * @param WP_Post $source_post Source post.
	 * @param int     $new_post_id New post id.
	 */
	private function set_new_post_taxonomies( $source_post, $new_post_id ) {
		$taxonomies = get_object_taxonomies( $source_post->post_type ); // Returns array of taxonomy names for post type, ex array("category", "post_tag").
		foreach ( $taxonomies as $taxonomy ) {
			$post_terms = wp_get_object_terms( $source_post->ID, $taxonomy, array( 'fields' => 'slugs' ) );
			wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
		}
	}

	/**
	 * Duplicate post meta.
	 *
	 * @param WP_Post $source_post Source post.
	 * @param int     $new_post_id New post ID.
	 */
	private function duplicate_post_meta( $source_post, $new_post_id ) {
		$source_post_meta = get_post_meta( $source_post->ID );
		foreach ( $source_post_meta as $meta_key => $meta_values ) {
			foreach ( $meta_values as $meta_value ) {
				add_post_meta( $new_post_id, $meta_key, maybe_unserialize( $meta_value ) );
			}
		}
	}

	/**
	 * Rebuild fields ids.
	 *
	 * @param int $new_post_id New post id.
	 */
	private function rebuild_fields_ids( $new_post_id ) {
		$fields = get_post_meta( $new_post_id, self::POST_META_FIELD_FIELDS, true );
		if ( ! is_array( $fields ) ) {
			$fields = array();
		}
		$fields = $this->change_fields_ids( $fields );
		update_post_meta( $new_post_id, self::POST_META_FIELD_FIELDS, $fields );
	}

	/**
	 * Change fields id.
	 *
	 * @param array $fields Fields.
	 *
	 * @return array
	 */
	private function change_fields_ids( array $fields ) {
		$fields_ids_translate = array();
		foreach ( $fields as $field ) {
			$fields_ids_translate[ $field[ self::KEY_ID ] ] = $this->generate_new_field_id();
		}
		foreach ( $fields as $field_key => $field ) {
			$fields[ $field_key ][ self::KEY_ID ] = $this->get_new_id_for_given_id( $field[ self::KEY_ID ], $fields_ids_translate );
			if ( ! empty( $field[ self::KEY_LOGIC_RULES ] ) && is_array( $field[ self::KEY_LOGIC_RULES ] ) ) {
				$fields[ $field_key ][ self::KEY_LOGIC_RULES ] = $this->replace_fields_ids_for_logic_rules( $field[ self::KEY_LOGIC_RULES ], $fields_ids_translate );
			}
		}

		return $fields;
	}

	/**
	 * Generate new field id.
	 * @return string
	 */
	private function generate_new_field_id() {
		return 'fpf_' . rand( self::FIELD_ID_MIN, self::FIELD_ID_MAX );
	}

	/**
	 * Get new id for given id.
	 *
	 * @param string $id                   Id.
	 * @param array  $fields_ids_translate Fileds ids translations.
	 *
	 * @return mixed
	 */
	private function get_new_id_for_given_id( $id, array $fields_ids_translate ) {
		return $fields_ids_translate[ $id ];
	}

	/**
	 * Replace fields ids for logic rules.
	 * Replaces ids in conditional rules to new field ids. New fields ids are prepared in $fields_ids_translate array.
	 *
	 * @param array $logic_rules          Logic rules.
	 * @param array $fields_ids_translate Fields ids and translations.
	 *
	 * @return array
	 */
	private function replace_fields_ids_for_logic_rules( array $logic_rules, array $fields_ids_translate ) {
		foreach ( $logic_rules as $rule_key => $rule ) {
			if ( ! empty( $rule[ self::KEY_FIELD ] ) ) {
				$logic_rules[ $rule_key ][ self::KEY_FIELD ] = $this->get_new_id_for_given_id( $rule[ self::KEY_FIELD ], $fields_ids_translate );
			}
		}

		return $logic_rules;
	}

	/**
	 * Post row actions.
	 *
	 * @param array   $actions Actions.
	 * @param WP_Post $post    Post.
	 *
	 * @return mixed
	 */
	public function post_row_actions( $actions, $post ) {
		if ( self::POST_TYPE_FPF_FIELDS !== $post->post_type ) {
			return $actions;
		}
		if ( current_user_can( 'edit_posts' ) ) {
			$actions[ self::ACTION_DUPLICATE ] = '<a href="' . admin_url( 'admin.php?action=' . self::ACTION_FPF_DUPLICATE_POST_AS_DRAFT . '&amp;post=' . $post->ID ) . '" rel="permalink">' . __( 'Duplicate', 'flexible-product-fields-pro' ) . '</a>';
		}

		return $actions;
	}

}
