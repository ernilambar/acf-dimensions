<?php
/**
 * Field class
 *
 * @package ACF_Dimensions
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NS_ACF_Field_Dimensions' ) ) :

	/**
	 * Field class.
	 *
	 * @since 1.0.0
	 */
	class NS_ACF_Field_Dimensions extends acf_field {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 *
		 * @param array $settings Settings.
		 */
		public function __construct( $settings ) {

			// Name.
			$this->name = 'dimensions';

			// Label.
			$this->label = esc_html__( 'Dimensions', 'acf-dimensions' );

			// Category.
			$this->category = 'layout';

			// Defaults.
			$this->defaults = array(
				'return_format' => 'string',
			);

			// Internationalization.
			$this->l10n = array();

			// Units.
			$this->units = array(
				'px'  => 'px',
				'%'   => '%',
				'in'  => 'in',
				'cm'  => 'cm',
				'mm'  => 'mm',
				'em'  => 'em',
				'ex'  => 'ex',
				'pt'  => 'pt',
				'pc'  => 'pc',
				'rem' => 'rem',
			);

			// Settings.
			$this->settings = $settings;

			// Call parent constructor.
			parent::__construct();
		}

		/**
		 * Render field settings.
		 *
		 * @since 1.0.0
		 *
		 * @param array $field Field details.
		 */
		public function render_field_settings( $field ) {
			acf_render_field_setting(
				$field,
				array(
					'label'        => esc_html__( 'Return Format', 'acf-dimensions' ),
					'instructions' => '',
					'type'         => 'radio',
					'name'         => 'return_format',
					'layout'       => 'horizontal',
					'choices'      => array(
						'string' => esc_html__( 'String', 'acf-dimensions' ),
						'array'  => esc_html__( 'Array', 'acf-dimensions' ),
					),
				)
			);
		}

		/**
		 * Render field.
		 *
		 * @since 1.0.0
		 *
		 * @param array $field Field details.
		 */
		public function render_field( $field ) {
			$devices = array(
				'desktop',
				'tablet',
				'mobile',
			);
			?>
			<div class="acf-dimensions">
				<div class="acf-dimensions__buttons">
					<ul>
						<?php $cnt = 1; ?>
						<?php foreach ( $devices as $item ) : ?>
							<?php
							$icon    = ( 'mobile' === $item ) ? 'dashicons-smartphone' : 'dashicons-' . $item;
							$classes = ( 1 === $cnt ) ? 'btn--active' : '';
							?>
							<li>
								<a href="#" rel="acf-dimensions__device--<?php echo esc_attr( $item ); ?>" class="btn <?php echo esc_attr( $classes ); ?>" rel="acf-dimensions__device--<?php echo esc_attr( $item ); ?>"><span class="dashicons <?php echo esc_attr( $icon ); ?>"></span></a>
							</li>
							<?php $cnt++; ?>
						<?php endforeach; ?>
					</ul>
				</div><!-- .acf-dimensions__buttons -->

				<div class="acf-dimensions__devices">

					<?php $cnt = 1; ?>
					<?php foreach ( $devices as $item ) : ?>

						<?php
						$device_classes = 'acf-dimensions__device--' . $item;

						if ( 1 === $cnt ) {
							$device_classes .= ' acf-dimensions__device--active';
						}
						?>

						<div class="acf-dimensions__device <?php echo esc_attr( $device_classes ); ?>">
							<?php
							// Values.
							$value_top    = isset( $field['value'][ $item ]['top'] ) ? $field['value'][ $item ]['top'] : '';
							$value_right  = isset( $field['value'][ $item ]['right'] ) ? $field['value'][ $item ]['right'] : '';
							$value_bottom = isset( $field['value'][ $item ]['bottom'] ) ? $field['value'][ $item ]['bottom'] : '';
							$value_left   = isset( $field['value'][ $item ]['left'] ) ? $field['value'][ $item ]['left'] : '';

							// Linked status.
							$is_linked = ( isset( $field['value'][ $item ]['linked'] ) && 1 !== absint( $field['value'][ $item ]['linked'] ) ) ? 0 : 1;

							if ( 1 === $is_linked ) {
								$value_right  = $value_top;
								$value_bottom = $value_top;
								$value_left   = $value_top;
							}
							?>

							<div class="acf-dimensions__inputs">
								<div class="acf-dimensions__texts">
									<div class="acf-dimensions__input">
										<input type="text"
											class="input-top"
											name="<?php echo esc_attr( $field['name'] ); ?>[<?php echo esc_attr( $item ); ?>][top]"
											value="<?php echo esc_attr( $value_top ); ?>"
											/>
										<span class="input-label"><?php esc_html_e( 'Top', 'acf-dimensions' ); ?></span>
									</div><!-- .acf-dimensions__input -->
									<div class="acf-dimensions__input">
										<input type="text"
											class="input-right"
											name="<?php echo esc_attr( $field['name'] ); ?>[<?php echo esc_attr( $item ); ?>][right]"
											value="<?php echo esc_attr( $value_right ); ?>"
											<?php echo $is_linked ? ' readonly ' : ''; ?>
											/>
											<span class="input-label"><?php esc_html_e( 'Right', 'acf-dimensions' ); ?></span>
									</div>
									<div class="acf-dimensions__input">
										<input type="text"
											class="input-bottom"
											name="<?php echo esc_attr( $field['name'] ); ?>[<?php echo esc_attr( $item ); ?>][bottom]"
											value="<?php echo esc_attr( $value_bottom ); ?>"
											<?php echo $is_linked ? ' readonly ' : ''; ?>
											/>
										<span class="input-label"><?php esc_html_e( 'Bottom', 'acf-dimensions' ); ?></span>
									</div>
									<div class="acf-dimensions__input">
										<input type="text"
											class="input-left"
											name="<?php echo esc_attr( $field['name'] ); ?>[<?php echo esc_attr( $item ); ?>][left]"
											value="<?php echo esc_attr( $value_left ); ?>"
											<?php echo $is_linked ? ' readonly ' : ''; ?>
											/>
										<span class="input-label"><?php esc_html_e( 'Left', 'acf-dimensions' ); ?></span>
									</div>
								</div><!-- .acf-dimensions__texts -->
								<div class="acf-dimensions__linker">
									<?php
									$button_classes = '';

									if ( 1 === $is_linked ) {
										$button_classes .= ' btn--active';
									}
									?>
									<button class="btn btn--linker <?php echo esc_attr( $button_classes ); ?>">
										<span class="linked dashicons dashicons-admin-links"></span>
										<span class="unlinked dashicons dashicons-editor-unlink"></span>
									</button>

									<input type="hidden" class="input-linked" name="<?php echo esc_attr( $field['name'] ); ?>[<?php echo esc_attr( $item ); ?>][linked]" value="<?php echo esc_attr( $is_linked ); ?>" />
								</div><!-- .acf-dimensions__linker -->
							</div>
							<div class="acf-dimensions__unit">
								<?php
								$selected_desktop_unit = ( isset( $field['value'][ $item ]['unit'] ) ) ? $field['value'][ $item ]['unit'] : '';
								?>
								<select name="<?php echo esc_attr( $field['name'] ); ?>[<?php echo esc_attr( $item ); ?>][unit]">
									<?php foreach ( $this->units as $item ) : ?>
										<option value="<?php echo esc_attr( $item ); ?>" <?php selected( $item, $selected_desktop_unit ); ?>><?php echo esc_html( $item ); ?></option>
									<?php endforeach; ?>
								</select>
							</div><!-- .acf-dimensions__unit -->
						</div>
						<?php $cnt++; ?>
					<?php endforeach; ?>

				</div><!-- .acf-dimensions__devices -->

			</div><!-- .acf-dimensions -->
			<?php
		}

		/**
		 * Load assets.
		 *
		 * @since 1.0.0
		 */
		public function input_admin_enqueue_scripts() {
			$url = $this->settings['url'];

			$version = $this->settings['version'];

			wp_enqueue_script( 'acf-dimensions', "{$url}assets/input.js", array( 'acf-input' ), $version );
			wp_enqueue_style( 'acf-dimensions', "{$url}assets/input.css", array( 'acf-input' ), $version );
		}

		/**
		 * Get string format value.
		 *
		 * @since 1.0.0
		 *
		 * @param mixed $value The value which was loaded from the database.
		 * @param int   $post_id The $post_id from which the value was loaded.
		 * @param array $field The field array holding all the field options.
		 * @return mixed The modified value.
		 */
		public function format_value( $value, $post_id, $field ) {
			// Bail early if no value.
			if ( empty( $value ) ) {
				return $value;
			}

			if ( 'string' === $field['return_format'] ) {
				return $this->get_string_format_value( $value );
			}

			return $value;
		}

		/**
		 * Get string format value.
		 *
		 * @since 1.0.0
		 *
		 * @param array $value Value.
		 * @return array Array of CSS string based on device.
		 */
		public function get_string_format_value( $value ) {
			$output = array();

			$devices = array(
				'desktop',
				'tablet',
				'mobile',
			);

			foreach ( $devices as $item ) {
				$css = '';

				$top    = isset( $value[ $item ]['top'] ) ? $value[ $item ]['top'] : '';
				$right  = isset( $value[ $item ]['right'] ) ? $value[ $item ]['right'] : '';
				$bottom = isset( $value[ $item ]['bottom'] ) ? $value[ $item ]['bottom'] : '';
				$left   = isset( $value[ $item ]['left'] ) ? $value[ $item ]['left'] : '';
				$unit   = isset( $value[ $item ]['unit'] ) ? $value[ $item ]['unit'] : '';

				if ( '' !== $top || '' !== $right || '' !== $bottom || '' !== $left ) {
					$css .= sprintf( '%2$s%1$s %3$s%1$s %4$s%1$s %5$s%1$s', $unit, (float) $top, (float) $right, (float) $bottom, (float) $left );
				}

				$output[ $item ] = $css;
			}

			return $output;
		}
	}

	new NS_ACF_Field_Dimensions( $this->settings );

endif;
