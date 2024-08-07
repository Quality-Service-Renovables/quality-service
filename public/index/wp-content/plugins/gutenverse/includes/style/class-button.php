<?php
/**
 * Gutenverse Button
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package gutenverse\style
 */

namespace Gutenverse\Style;

/**
 * Class Button
 *
 * @package gutenverse\style
 */
class Button extends Style_Abstract {
	/**
	 * Block Name
	 *
	 * @var array
	 */
	protected $name = 'button';

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
				'animation'   => ".{$this->element_id} .guten-button",
				'advance'     => null,
			)
		);
	}

	/**
	 * Generate style base on attribute.
	 */
	public function generate() {
		if ( isset( $this->attrs['alignButton'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper",
					'property'       => function ( $value ) {
						return "justify-content: {$value};";
					},
					'value'          => $this->attrs['alignButton'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['buttonWidth'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button",
					'property'       => function ( $value ) {
						return "width: {$value}%;";
					},
					'value'          => $this->attrs['buttonWidth'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['iconPosition'] ) && isset( $this->attrs['iconSpacing'] ) ) {
			if ( 'before' === $this->attrs['iconPosition'] ) {
				$this->inject_style(
					array(
						'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button i",
						'property'       => function ( $value ) {
							return "margin-right: {$value}px;";
						},
						'value'          => $this->attrs['iconSpacing'],
						'device_control' => true,
					)
				);
			}

			if ( 'after' === $this->attrs['iconPosition'] ) {
				$this->inject_style(
					array(
						'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button i",
						'property'       => function ( $value ) {
							return "margin-left: {$value}px;";
						},
						'value'          => $this->attrs['iconSpacing'],
						'device_control' => true,
					)
				);
			}
		}

		if ( isset( $this->attrs['iconSize'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button i",
					'property'       => function ( $value ) {
						return $this->handle_unit_point( $value, 'font-size' );
					},
					'value'          => $this->attrs['iconSize'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['paddingButton'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button",
					'property'       => function ( $value ) {
						return $this->handle_dimension( $value, 'padding' );
					},
					'value'          => $this->attrs['paddingButton'],
					'device_control' => true,
				)
			);
		}

		if ( isset( $this->attrs['color'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button span",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'color' );
					},
					'value'          => $this->attrs['color'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['iconColor'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button i",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'color' );
					},
					'value'          => $this->attrs['iconColor'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['hoverTextColor'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button:hover span",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'color' );
					},
					'value'          => $this->attrs['hoverTextColor'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['hoverIconColor'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button:hover i",
					'property'       => function ( $value ) {
						return $this->handle_color( $value, 'color' );
					},
					'value'          => $this->attrs['hoverIconColor'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['typography'] ) ) {
			$this->inject_typography(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button span",
					'property'       => function ( $value ) {},
					'value'          => $this->attrs['typography'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['buttonBackground'] ) ) {
			$this->handle_background( ".{$this->element_id}.guten-button-wrapper .guten-button", $this->attrs['buttonBackground'] );
		}

		if ( isset( $this->attrs['buttonBackgroundHover'] ) ) {
			$this->handle_background( ".{$this->element_id}.guten-button-wrapper .guten-button:hover", $this->attrs['buttonBackgroundHover'] );
		}

		if ( isset( $this->attrs['buttonBorder'] ) ) {
			$this->handle_border( 'buttonBorder', ".{$this->element_id}.guten-button-wrapper .guten-button" );
		}

		if ( isset( $this->attrs['buttonBoxShadow'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button",
					'property'       => function ( $value ) {
						return $this->handle_box_shadow( $value );
					},
					'value'          => $this->attrs['buttonBoxShadow'],
					'device_control' => false,
				)
			);
		}

		if ( isset( $this->attrs['buttonBorderHover'] ) ) {
			$this->handle_border( 'buttonBorderHover', ".{$this->element_id}.guten-button-wrapper .guten-button:hover" );
		}

		if ( isset( $this->attrs['buttonBoxShadowHover'] ) ) {
			$this->inject_style(
				array(
					'selector'       => ".{$this->element_id}.guten-button-wrapper .guten-button:hover",
					'property'       => function ( $value ) {
						return $this->handle_box_shadow( $value );
					},
					'value'          => $this->attrs['buttonBoxShadowHover'],
					'device_control' => false,
				)
			);
		}
	}
}
