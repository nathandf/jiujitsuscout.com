<?php

namespace Model;

use Contracts\EntityInterface;

class LandingPageElementCss implements EntityInterface
{
	public $id;
	public $margin_top;
	public $margin_bottom;
	public $margin_left;
	public $margin_right;
	public $padding;
	public $border_width;
	public $border_color;
	public $border_radius;
	public $background;
	public $color;
	public $font;
	public $font_size;
	public $font_weight;
	public $height;
	public $width;
	public $text_alignment;
	public $element_alignment;
	public $image_src;
}