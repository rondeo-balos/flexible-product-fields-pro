<?php
/**
 * .
 *
 * @var string $notice_title Title of notice.
 * @var string $notice_content Content of notice.
 *
 * @package Flexible Product Fields PRO
 */

?>
<div class="notice notice-error" data-notice="fpf-pro-admin-notice">
	<h2><?php echo esc_attr( $notice_title ); ?></h2>
	<p><?php echo wp_kses_post( $notice_content ); ?></p>
	<div>
		<a href="<?php echo esc_url( apply_filters( 'flexible_product_fields/short_url', 'https://wpde.sk/fpf-settings-notice-compatibility-button', 'fpf-settings-notice-compatibility-button' ) ); ?>"
		   target="_blank"
		   class="button button-hero">
			<?php echo esc_html( __( 'Learn more', 'flexible-product-fields-pro' ) ); ?>
		</a>
	</div>
</div>
