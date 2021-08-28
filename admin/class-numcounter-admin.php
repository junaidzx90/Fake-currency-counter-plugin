<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    NUMCounter
 * @subpackage NUMCounter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    NUMCounter
 * @subpackage NUMCounter/admin
 * @author     Md Junayed <admin@easeare.com>
 */
class NUMCounter_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/numcounter-admin.css', array(), $this->version, 'all' );

	}

	function option_page_register(){
		add_options_page( 'Counter Option', 'Counter Option', 'manage_options', 'numcounter', [$this,'numcounter_option_page'], null );

		// options
		add_settings_section( 'counter_settings_section', '', '', 'counter_settings_page' );

		// Starting Value
		add_settings_field( 'counter_default_value', 'Starting Value', [$this,'counter_default_value_cb'], 'counter_settings_page', 'counter_settings_section');
		register_setting( 'counter_settings_section', 'counter_default_value');
		// Increment Value
		add_settings_field( 'counter_increment_value', 'Increment by (Max)', [$this,'counter_increment_value_cb'], 'counter_settings_page', 'counter_settings_section');
		register_setting( 'counter_settings_section', 'counter_increment_value');
		// Currency
		add_settings_field( 'counter_currency', 'Currency', [$this,'counter_currency_cb'], 'counter_settings_page', 'counter_settings_section');
		register_setting( 'counter_settings_section', 'counter_currency');
		// Font size
		add_settings_field( 'counter_fontsize', 'Font size', [$this,'counter_fontsize_cb'], 'counter_settings_page', 'counter_settings_section');
		register_setting( 'counter_settings_section', 'counter_fontsize');

		// Color Left
		add_settings_field( 'counter_color_left', 'Color Left', [$this,'counter_color_left_cb'], 'counter_settings_page', 'counter_settings_section');
		register_setting( 'counter_settings_section', 'counter_color_left');
		// Color Right
		add_settings_field( 'counter_color_right', 'Color Right', [$this,'counter_color_right_cb'], 'counter_settings_page', 'counter_settings_section');
		register_setting( 'counter_settings_section', 'counter_color_right');
		
	}

	function numcounter_option_page(){
		?>
		<div id="counter">
			<h3 class="counter-title">Counter Option</h3>
			<hr>
			<div class="counter-content">
				<form style="width: 30%" method="post" action="options.php">
					
					<table class="widefat">
					<?php
					settings_fields( 'counter_settings_section' );
					do_settings_fields( 'counter_settings_page', 'counter_settings_section' );
					?>
					</table>
					<div class="ccbuttons">
					<?php submit_button('Save'); ?>
					<?php submit_button('Reset', 'button', 'resetsettings'); ?>
					</div>
				</form>
			</div>
		</div>
		<?php
	}

	function counter_reset_settings(){
		delete_option('counter_default_value');
		delete_option('counter_increment_value');
		delete_option('counter_color_left');
		delete_option('counter_color_right');
		delete_option('numcounter_count');
	
		echo 'Success';
		die;
	}

	function counter_admin_scripts(){
		?>
		<script>
			jQuery(function ($) {
				$('#resetsettings').on('click', function(e){
					e.preventDefault();
					$.ajax({
						type: "post",
						url: '<?php echo admin_url('admin-ajax.php') ?>',
						beforeSend: ()=>{
						$('button').prop('disabled', true)},
						data: {action:'counter_reset_settings'},
						success: function (response) {
							location.reload();
						}
					});
				})
			});
		</script>
		<?php
	}

	function counter_default_value_cb(){
		echo '<input class="widefat" type="number" placeholder="1,000,000" name="counter_default_value" value="'.get_option('counter_default_value').'">';
	}

	function counter_increment_value_cb(){
		echo '<input class="widefat" type="number" placeholder="100" name="counter_increment_value" value="'.get_option('counter_increment_value').'">';
		echo '<p>Note: Default incrementing in <b>(1-100)</b> randomly.</p>';
	}

	function counter_currency_cb(){
		echo '<input type="text" placeholder="$" name="counter_currency" value="'.get_option('counter_currency').'">';
	}

	function counter_fontsize_cb(){
		echo '<input type="number" placeholder="75px" name="counter_fontsize" value="'.get_option('counter_fontsize').'">';
	}

	function counter_color_left_cb(){
		echo '<input type="color" name="counter_color_left" value="'.get_option('counter_color_left','#673ab7').'">';
	}
	
	function counter_color_right_cb(){
		echo '<input type="color" name="counter_color_right" value="'.get_option('counter_color_right','#f44336').'"> <strong style="user-select: none">Shortcode: </strong>[numcounter]';
	}
}
