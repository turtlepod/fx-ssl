<?php
/**
 * Settings
 *
 * @since 0.1.0
**/

if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Create Settings Page
 *
 * @since 0.1.0
 */
class fx_SSL_Settings {

	/**
	 * Settings Slug
	 *
	 * @since 0.1.0
	 */
	public $settings_slug = 'general';

	/**
	 * Options Group
	 *
	 * @since 0.1.0
	 */
	public $options_group = 'general';

	/**
	 * Option Name
	 *
	 * @since 0.1.0
	 */
	public $option_name = 'fx-ssl';

	/**
	 * Construct
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Register Settings
	 *
	 * @since 0.1.0
	 */
	public function register_settings() {

		register_setting(
			$option_group    = $this->options_group,
			$option_name     = $this->option_name,
			$sanitize_cb     = function( $input ) {
				return isset( $input ) ? true : false;
			}
		);

		add_settings_section(
			$section_id      = 'fx_ssl_section',
			$section_title   = esc_html__( 'SSL (HTTPS)', 'fx-ssl' ),
			$callback        =  function() {
				?>
				<?php
			},
			$slug            = $this->settings_slug
		);

		add_settings_field(
			$field_ID        = 'fx_ssl_info',
			$field_title     = esc_html__( 'Requirement', 'fx-ssl' ), 
			$callback        = function() {
				$yes = '<span class="dashicons dashicons-yes" style="color:green;"></span>';
				$no  = '<span class="dashicons dashicons-no" style="color:red;"></span>';
				?>
				<ul>
					<li>
						
						<p><?php echo is_ssl() && force_ssl_admin() ? $yes : $no; ?> <strong><?php esc_html_e( 'Enforce Administration over SSL.', 'fx-ssl' ); ?></strong></p>
						<p><?php esc_html_e( 'Add this code in wp-config.php to enable this:', 'fx-ssl' ); ?> <code>define( 'FORCE_SSL_ADMIN', true );</code></p>
						<p><a target="_blank" href="https://codex.wordpress.org/Administration_Over_SSL"><?php esc_html_e( 'Read more&hellip;', 'fx-ssl' ); ?></a></p>
					</li>
				</ul>
				<?php
			},
			$slug            = $this->settings_slug,
			$section_id      = 'fx_ssl_section'
		);

		add_settings_field(
			$field_ID        = 'fx_ssl',
			$field_title     = esc_html__( 'Force SSL/HTTPS', 'fx-ssl' ), 
			$callback        = function() {
				?>

				<?php if ( is_ssl() && force_ssl_admin() && fx_ssl_is_https( get_option( 'home' ) ) && fx_ssl_is_https( get_option( 'siteurl' ) ) ) : ?>
					<label for="fx_ssl_enable"><input type="checkbox" value="1" id="fx_ssl_enable" name="<?php echo esc_attr( $this->option_name );?>" <?php checked( $option ); ?>> <?php esc_html_e( 'Redirect all pages to HTTPS', 'fx-ssl' ); ?></label>
				<?php else : ?>
					<p><?php esc_html_e( 'You need to enforce WordPress administration over SSL and use HTTPS URL in "WordPress Address (URL)" and "Site Address (URL)" to enable this feature.', 'fx-ssl' ); ?></p>
				<?php endif; ?>

				<?php
			},
			$slug            = $this->settings_slug,
			$section_id      = 'fx_ssl_section'
		);
	}
}
