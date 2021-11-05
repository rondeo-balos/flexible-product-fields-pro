<?php

namespace WPDesk\FPF\Pro\Field;

use WPDesk\FPF\Free\Field\Type\TypeIntegration;
use WPDesk\FPF\Pro\Field\Type\CheckboxType;
use WPDesk\FPF\Pro\Field\Type\DateType;
use WPDesk\FPF\Pro\Field\Type\HeadingType;
use WPDesk\FPF\Pro\Field\Type\MultiselectType;
use WPDesk\FPF\Pro\Field\Type\NumberType;
use WPDesk\FPF\Pro\Field\Type\RadioImagesType;
use WPDesk\FPF\Pro\Field\Type\RadioType;
use WPDesk\FPF\Pro\Field\Type\SelectType;
use WPDesk\FPF\Pro\Field\Type\TextareaType;
use WPDesk\FPF\Pro\Field\Type\TextType;

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
		( new TypeIntegration( new SelectType() ) )->hooks();
		( new TypeIntegration( new MultiselectType() ) )->hooks();
		( new TypeIntegration( new RadioType() ) )->hooks();
		( new TypeIntegration( new RadioImagesType() ) )->hooks();
		( new TypeIntegration( new CheckboxType() ) )->hooks();
		( new TypeIntegration( new HeadingType() ) )->hooks();
		( new TypeIntegration( new DateType() ) )->hooks();
	}
}
