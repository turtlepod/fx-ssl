<?php
/**
 * Settings
 * @since 0.1.0
**/
/* Do not access this file directly */
if ( ! defined( 'WPINC' ) ) { die; }


/**
 * Create Settings Page
 * @since 0.1.0
 */
class fx_SSL_Settings{

	/**
	 * Settings Slug
	 * @since 0.1.0
	 */
	public $settings_slug = 'general';

	/**
	 * Options Group
	 * @since 0.1.0
	 */
	public $options_group = 'general';

	/**
	 * Option Name
	 * @since 0.1.0
	 */
	public $option_name = 'fx-ssl';

	/**
	 * Construct
	 * @since 0.1.0
	 */
	public function __construct(){

		/* Register Settings and Fields */
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Register Settings
	 * @since 0.1.0
	 */
	public function register_settings(){

		/* Register settings */
		register_setting(
			$this->options_group, // options group
			$this->option_name, // option name/database
			array( $this, 'sanitize' ) // sanitize callback function
		);

		/* Create settings section */
		add_settings_section(
			'fx_ssl_section', // section ID
			_x( 'SSL (HTTPS)', 'settings page', 'fx-ssl' ), // section title
			array( $this, 'settings_section' ), // section callback function
			$this->settings_slug // settings page slug
		);

		/* Field: Front Page Title */
		add_settings_field(
			'fx_ssl', // field ID
			_x( 'Force SSL', 'settings page', 'fx-ssl' ), // field title 
			array( $this, 'settings_field_ssl' ), // field callback function
			$this->settings_slug, // settings page slug
			'fx_ssl_section' // section ID
		);

	}

	/**
	 * Sanitize Options
	 * @since 0.1.0
	 */
	public function sanitize( $input ){
		return isset( $input ) ? true : false;
	}

	/**
	 * Settings Section
	 * @since 0.1.0
	 */
	public function settings_section(){
		?>
		<p style="font-size:14px;"><?php echo apply_filters( 'fx_ssl_settings_section_description', sprintf( _x( 'You need to enable (and enforce) <a href="%s" target="_blank">WordPress administration over SSL</a> and use HTTPS URL in "WordPress Address (URL)" and "Site Address (URL)" settings above to activate this feature.', 'settings page', 'fx-ssl' ), 'https://codex.wordpress.org/Administration_Over_SSL' ) );?></p>
		<?php
	}

	/**
	 * Enable Private Site
	 * @since 0.1.0
	 */
	public function settings_field_ssl(){

		/* Check if feature is supported. */
		if( is_ssl() && force_ssl_admin() && fx_ssl_is_https( get_bloginfo( 'url' ) ) && fx_ssl_is_https( get_bloginfo( 'wpurl' ) ) ){
			$disabled = '';
			$option = get_option( $this->option_name, false );
		}
		/* Feature is not supported. */
		else{
			$disabled = ' disabled=disabled';
			$option = false;
		}
	?>
		<label for="fx_ssl_enable">
			<input type="checkbox" value="1" id="fx_ssl_enable" name="<?php echo esc_attr( $this->option_name );?>" <?php checked( $option ); ?><?php echo $disabled; ?>> <?php _ex( 'Redirect all pages to HTTPS', 'settings page', 'fx-ssl' );?></label>
	<?php
	}

}
