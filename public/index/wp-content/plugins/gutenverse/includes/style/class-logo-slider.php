<?php
/**
 * Gutenverse Logo Slider
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package gutenverse\style
 */

namespace Gutenverse\Style;

/**
 * Class Logo Slider
 *
 * @package gutenverse\style
 */
class Logo_Slider extends Style_Abstract {
	/**
	 * Block Name
	 *
	 * @var array
	 */
	protected $name = 'logo-slider';

	/**
	 * Constructor
	 *
	 * @param array $attrs Attribute.
	 */
	public function __construct( $attrs ) {
		parent::__construct( $attrs );

		$this->set_feature(
			array(
				'background'  => null,
				'border'      => null,
				'positioning' => null,
				'animation'   => null,
				'advance'     => null,
			)
		);
	}

	/**
	 * Generate style base on attribute.
	 */
	public function generate() {
		$this->arrow_style();
		$this->dot_style();
		$this->logo_style();
	}

	/**
	 * Logo style.
	 */
	public function logo_style() {
		if ( isset( $this->attrs['imageFixHeight'] ) && $this->attrs['imageFixHeight'] ) {
			if ( isset( $this->attrs['imageHeight'] ) ) {
				$this->inject_style(
					array(
						'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image img",
						'property'       => function ( $value ) {
							return "height: {$value}px;";
						},
						'value'          => $this->attrs['imageHeight'],
						'device_control' => true,
					)
				);
			}

			if ( isset( $this->attrs['imageFit'] ) ) {
				$this->inject_style(
					array(
						'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image img",
						'property'       => function ( $value ) {
							return "object-fit: {$value};";
						},
						'value'          => $this->attrs['imageFit'],
						'device_control' => true,
					)
				);
			}
		}

		if ( isset( $this->attrs['imagePadding'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image .main-image",
					'property'       => function ( $value ) {
						return $this->handle_dimension( $value, 'padding' );
					},
					'value'          => $this->attrs['imagePadding'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['imageMargin'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image .main-image",
					'property'       => function ( $value ) {
						return $this->handle_dimension( $value, 'margin' );
					},
					'value'          => $this->attrs['imageMargin'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['imageHoverPadding'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image:hover .hover-image",
					'property'       => function ( $value ) {
						return $this->handle_dimension( $value, 'padding' );
					},
					'value'          => $this->attrs['imageHoverPadding'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['imageHoverMargin'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image:hover .hover-image",
					'property'       => function ( $value ) {
						return $this->handle_dimension( $value, 'margin' );
					},
					'value'          => $this->attrs['imageHoverMargin'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['imageBorder'] ) ) {
			$this->handle_border( 'imageBorder', ".{$this->element_id}.guten-client-logo .swiper-container .content-image .main-image" );
		}

		if ( isset( $this->attrs['imageBorderHover'] ) ) {
			$this->handle_border( 'imageBorderHover', ".{$this->element_id}.guten-client-logo .swiper-container .content-image:hover .hover-image" );
		}

		if ( isset( $this->attrs['imageBoxShadow'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image .main-image",
					'property'       => function ( $value ) {
						return $this->handle_box_shadow( $value );
					},
					'value'          => $this->attrs['imageBoxShadow'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['imageBoxShadowHover'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image:hover .hover-image",
					'property'       => function ( $value ) {
						return $this->handle_box_shadow( $value );
					},
					'value'          => $this->attrs['imageBoxShadowHover'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['opacity'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image .main-image",
					'property'       => function ( $value ) {
						return "opacity: {$value};";
					},
					'value'          => $this->attrs['opacity'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['hoverOpacity'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-client-logo .swiper-container .content-image:hover .hover-image",
					'property'       => function ( $value ) {
						return "opacity: {$value};";
					},
					'value'          => $this->attrs['hoverOpacity'],
					'device_control' => false,
				)
			);
		}
	}

	/**
	 * Dot Style.
	 */
	public function dot_style() {
		if ( isset( $this->attrs['dotsSpacingHorizontal'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} .swiper-pagination-bullets .swiper-pagination-bullet",
					'property'       => function ( $value ) {
						return "margin: 0 calc({$value}px / 2);";
					},
					'value'          => $this->attrs['dotsSpacingHorizontal'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['dotsSpacingVertical'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} .swiper-pagination-bullets",
					'property'       => function ( $value ) {
						return "margin-top: {$value}px;";
					},
					'value'          => $this->attrs['dotsSpacingVertical'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['dotsWidth'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} .swiper-pagination-bullet",
					'property'       => function ( $value ) {
						return "width: {$value}px;";
					},
					'value'          => $this->attrs['dotsWidth'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['dotsHeight'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} .swiper-pagination-bullet",
					'property'       => function ( $value ) {
						return "height: {$value}px;";
					},
					'value'          => $this->attrs['dotsHeight'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['dotsRadius'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} .swiper-pagination-bullet",
					'property'       => function ( $value ) {
						return $this->handle_border_radius( $value );
					},
					'value'          => $this->attrs['dotsRadius'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['dotsColor'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} .swiper-pagination-bullet",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'background-color' );
					},
					'value'          => $this->attrs['dotsColor'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['dotsActiveWidth'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} .swiper-pagination-bullet.swiper-pagination-bullet-active",
					'property'       => function ( $value ) {
						return "width: {$value}px;";
					},
					'value'          => $this->attrs['dotsActiveWidth'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['dotsActiveHeight'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} .swiper-pagination-bullet.swiper-pagination-bullet-active",
					'property'       => function ( $value ) {
						return "height: {$value}px;";
					},
					'value'          => $this->attrs['dotsActiveHeight'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['dotsActiveColor'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} .swiper-pagination-bullet.swiper-pagination-bullet-active",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'background-color' );
					},
					'value'          => $this->attrs['dotsActiveColor'],
					'device_control' => true,
				)
			);
		}
	}

	/**
	 * Arrow Style.
	 */
	public function arrow_style() {
		if ( isset( $this->attrs['arrowFontSize'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return "font-size: {$value}px;";
					},
					'value'          => $this->attrs['arrowFontSize'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowColor'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'color' );
					},
					'value'          => $this->attrs['arrowColor'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowBgColor'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'background-color' );
					},
					'value'          => $this->attrs['arrowBgColor'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowPadding'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_dimension( $value, 'padding' );
					},
					'value'          => $this->attrs['arrowPadding'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowMargin'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_dimension( $value, 'margin' );
					},
					'value'          => $this->attrs['arrowMargin'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowOpacity'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return "opacity: calc({$value}/100);";
					},
					'value'          => $this->attrs['arrowOpacity'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowHoverColor'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}:hover div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'color' );
					},
					'value'          => $this->attrs['arrowHoverColor'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowHoverBgColor'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}:hover div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'background-color' );
					},
					'value'          => $this->attrs['arrowHoverBgColor'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowHoverPadding'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}:hover div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_dimension( $value, 'padding' );
					},
					'value'          => $this->attrs['arrowHoverPadding'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowHoverMargin'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}:hover div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_dimension( $value, 'margin' );
					},
					'value'          => $this->attrs['arrowHoverMargin'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowHoverOpacity'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}:hover div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return "opacity: calc({$value}/100);";
					},
					'value'          => $this->attrs['arrowHoverOpacity'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['arrowBorder'] ) ) {
			$this->handle_border( 'arrowBorder', ".{$this->element_id} div[class*='swiper-button-']" );
		}

		if ( isset( $this->attrs['arrowBoxShadow'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id} div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_box_shadow( $value );
					},
					'value'          => $this->attrs['arrowBoxShadow'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['arrowBorderHover'] ) ) {
			$this->handle_border( 'arrowBorderHover', ".{$this->element_id}:hover div[class*='swiper-button-']" );
		}

		if ( isset( $this->attrs['arrowBoxShadowHover'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}:hover div[class*='swiper-button-']",
					'property'       => function ( $value ) {
						return $this->handle_box_shadow( $value );
					},
					'value'          => $this->attrs['arrowBoxShadowHover'],
					'device_control' => false,
				)
			);
		}
	}
}
