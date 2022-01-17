<?php

namespace WPDesk\FPF\Pro\Field;

use WPDesk\FPF\Free\Field\Type\TypeIntegration;
use WPDesk\FPF\Pro\Field\Type\CheckboxType;
use WPDesk\FPF\Pro\Field\Type\ColorType;
use WPDesk\FPF\Pro\Field\Type\DateType;
use WPDesk\FPF\Pro\Field\Type\EmailType;
use WPDesk\FPF\Pro\Field\Type\FileType;
use WPDesk\FPF\Pro\Field\Type\HeadingType;
use WPDesk\FPF\Pro\Field\Type\HtmlType;
use WPDesk\FPF\Pro\Field\Type\ImageType;
use WPDesk\FPF\Pro\Field\Type\MultiCheckboxType;
use WPDesk\FPF\Pro\Field\Type\MultiselectType;
use WPDesk\FPF\Pro\Field\Type\NumberType;
use WPDesk\FPF\Pro\Field\Type\ParagraphType;
use WPDesk\FPF\Pro\Field\Type\RadioColorsType;
use WPDesk\FPF\Pro\Field\Type\RadioImagesType;
use WPDesk\FPF\Pro\Field\Type\RadioType;
use WPDesk\FPF\Pro\Field\Type\SelectType;
use WPDesk\FPF\Pro\Field\Type\TextareaType;
use WPDesk\FPF\Pro\Field\Type\TextType;
use WPDesk\FPF\Pro\Field\Type\TimeType;
use WPDesk\FPF\Pro\Field\Type\UrlType;

/**
 * Supports management of field types.
 */
class Types {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new TypeIntegration( new TextType() ) )->hooks();
		( new TypeIntegration( new TextareaType() ) )->hooks();
		( new TypeIntegration( new NumberType() ) )->hooks();
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\EmailType' ) ) {
			( new TypeIntegration( new EmailType() ) )->hooks();
		}
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\UrlType' ) ) {
			( new TypeIntegration( new UrlType() ) )->hooks();
		}
		( new TypeIntegration( new SelectType() ) )->hooks();
		( new TypeIntegration( new MultiselectType() ) )->hooks();
		( new TypeIntegration( new RadioType() ) )->hooks();
		( new TypeIntegration( new RadioImagesType() ) )->hooks();
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\RadioColorsType' ) ) {
			( new TypeIntegration( new RadioColorsType() ) )->hooks();
		}
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\ColorType' ) ) {
			( new TypeIntegration( new ColorType() ) )->hooks();
		}
		( new TypeIntegration( new CheckboxType() ) )->hooks();
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\MultiCheckboxType' ) ) {
			( new TypeIntegration( new MultiCheckboxType() ) )->hooks();
		}
		( new TypeIntegration( new HeadingType() ) )->hooks();
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\ParagraphType' ) ) {
			( new TypeIntegration( new ParagraphType() ) )->hooks();
		}
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\ImageType' ) ) {
			( new TypeIntegration( new ImageType() ) )->hooks();
		}
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\HtmlType' ) ) {
			( new TypeIntegration( new HtmlType() ) )->hooks();
		}
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\TimeType' ) ) {
			( new TypeIntegration( new TimeType() ) )->hooks();
		}
		( new TypeIntegration( new DateType() ) )->hooks();
		if ( class_exists( 'WPDesk\FPF\Free\Field\Type\FileType' ) ) {
			( new TypeIntegration( new FileType() ) )->hooks();
		}
	}
}
