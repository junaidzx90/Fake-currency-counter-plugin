<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    NUMCounter
 * @subpackage NUMCounter/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    NUMCounter
 * @subpackage NUMCounter/public
 * @author     Md Junayed <admin@easeare.com>
 */
class NUMCounter_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'numcounter', [$this,'numcounter_counting_html'] );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/numcounter-public.css', array(), $this->version, 'all' );

	}
	
	function numcounter_init() { 
		$loadUrl = plugin_dir_url( __FILE__ ).'partials/counts.php';
		?>
		<script>
			jQuery(document).ready(function ($) {
				setInterval(function(){
					$('.cnumcounter span').load("<?php echo $loadUrl ?>", function(){
						$('.counterLoading').hide()
						$('.ccbox').fadeIn()
					})
				}, 1000);
			});
		</script>
		<?php
	}

	function numcounter_counting_html(){
		ob_start();
		$leftcolor = get_option('counter_color_left','#673ab7');
		$rightcolor = get_option('counter_color_right','#f44336');
		?>
		<div class="cnumcounter_box">
			<div class="counterLoading">
				<div class="dots dot7">
					<div style="background-color: <?php echo $leftcolor ?>;" class="dot"></div>
					<div style="background-color: <?php echo $leftcolor ?>;" class="dot"></div>
					<div style="background-color: <?php echo $leftcolor ?>;" class="dot"></div>
					<div style="background-color: <?php echo $leftcolor ?>;" class="dot"></div>
				</div>
			</div>
			<div class="ccbox">
				<span style="background-image: linear-gradient(45deg, <?php echo $leftcolor ?>, <?php echo $rightcolor ?>);" class="cnumcounter"> $ <span>00000000</span></span>
			</div>
		</div>
		<?php
		$output = ob_get_contents();
		ob_get_clean();
		return $output;
	}
}
