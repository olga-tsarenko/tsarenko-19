<?php
/**!
 * Plugin Name: 	Social Share Buttons
 * Plugin URI: 		http://wordpress.org/plugins/sis-social-share/
 * Description: 	Add various social share buttons to your website and post.
 * Version: 		1.2.0
 * Author: 			Sayful Islam
 * Author URI: 		http://sayfulit.com
 * License: 		GPLv2 or later
 */
if ( ! class_exists('SIS_Social_Share')):

class SIS_Social_Share {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      string    $plugin_name
	 */
	private $plugin_name = 'sis-social-share';

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      string    $version
	 */
	private $version = '1.2.0';

	/**
	 * The absolute url of current version of the plugin.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      string    $plugin_url
	 */
	private $plugin_url;

	/**
	 * The absolute path of current version of the plugin.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      string    $plugin_path
	 */
	private $plugin_path;

	/**
	 * The options of the plugin.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      array    $options
	 */
	private $options;


	protected static $instance = null;

	/**
	 * Main SIS_Social_Share Instance
	 *
	 * Ensures only one instance of SIS_Social_Share is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @static
	 * @see SIS_Social_Share()
	 * @return SIS_Social_Share - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * SIS_Social_Share Constructor.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Include required files
		$this->includes();

		add_action('wp_head', array( $this, 'inline_style'), 15);
		add_action('wp_footer', array( $this, 'site_social_buttons'), 0);
		add_filter( 'the_content', array( $this, 'the_content' ) );
		// add_action('wp_enqueue_scripts', array( $this, 'wp_scripts'), 15);
	}

	public function includes()
	{
		require_once $this->plugin_path() . '/includes/Shapla_Settings_API.php';
		require_once $this->plugin_path() . '/includes/settings.php';

		$this->options = $sisSocialShare->get_options();
	}

	public function wp_scripts()
	{
		wp_enqueue_style($this->plugin_name,$this->plugin_url().'/assets/css/style.css');
	}

	public function site_social_buttons()
	{
		$options = $this->options;
		$enable = isset($options['enable_for_site']) ? $options['enable_for_site'] : false;
		$buttons = isset($options['site_buttons']) ? $options['site_buttons'] : array();
		if ( ! $enable || count( $buttons ) < 1) return;

		echo $this->post_buttons( $buttons, 'site' );
	}

	public function the_content( $content )
	{
		$options = $this->options;
		$enable = isset($options['enable_for_posts']) ? $options['enable_for_posts'] : false;
		$buttons = isset($options['post_buttons']) ? $options['post_buttons'] : array();

		if ( $enable && count( $buttons ) > 0){
			$buttons_html = $this->post_buttons( $buttons, 'post' );
			$content = sprintf('%2$s%1$s', $buttons_html, $content);
		}

		return $content;
	}

	public function inline_style()
	{
		$o = $this->options;

		$btn_s = isset($o['buttons_size']) ? $o['buttons_size'] : '28';
		$btn_p = isset($o['buttons_padding']) ? $o['buttons_padding'] : '10';
		$btn_c = isset($o['color_icon']) ? $o['color_icon'] :'#ffffff';

		$btn_w 		= intval($btn_s) + (2 * intval($btn_p)) + 2;
		$btn_pos 	= isset($o['site_buttons_from_top']) ? intval($o['site_buttons_from_top']) : 50;

		$d = isset($o['color_digg']) ? $o['color_digg'] : '#005be2';
		$f = isset($o['color_facebook']) ? $o['color_facebook'] : '#3b5998';
		$g = isset($o['color_google_plus']) ? $o['color_google_plus'] : '#dd4b39';
		$l = isset($o['color_linkedin']) ? $o['color_linkedin'] : '#007bb6';
		$p = isset($o['color_pinterest']) ? $o['color_pinterest'] : '#cb2027';
		$r = isset($o['color_reddit']) ? $o['color_reddit'] : '#ff4500';
		$s = isset($o['color_stumble']) ? $o['color_stumble'] : '#EB4823';
		$tu = isset($o['color_tumblr']) ? $o['color_tumblr'] : '#32506d';
		$t = isset($o['color_twitter']) ? $o['color_twitter'] : '#00aced';

		echo sprintf('<style type="text/css">');
		echo sprintf('.sis-social-share [class^="sis-svg-"] { padding: %1$spx; width: %2$spx; height: %2$spx; box-sizing: content-box; }', $btn_p, $btn_s);
		echo sprintf('.sis-social-share [class^="sis-svg-"] path { fill: %s; }', $btn_c);
		echo sprintf('.sis-social-share [class^="sis-svg-"]:hover { background-color: %s; }', $btn_c);
		echo sprintf('.sis-social-share a, .sis-social-share a:hover { box-shadow: none; border: none; }');
		echo sprintf('.sis-site-button { position: fixed; top: %2$spx; width: %1$spx; z-index: 999999; }', $btn_w, $btn_pos);
		echo sprintf('.sis-site-button.sis-left { left: 10px; }.sis-site-button.sis-right { right: 10px; }');
		echo sprintf('.sis-svg-twitter { background-color: %1$s; border: 1px solid %1$s; } .sis-svg-twitter:hover { border: 1px solid %1$s; } .sis-svg-twitter:hover path { fill: %1$s; }', $t);
		echo sprintf('.sis-svg-stumbleupon { background-color: %1$s; border: 1px solid %1$s; } .sis-svg-stumbleupon:hover { border: 1px solid %1$s; } .sis-svg-stumbleupon:hover path { fill: %1$s; }', $s);
		echo sprintf('.sis-svg-reddit { background-color: %1$s; border: 1px solid %1$s; } .sis-svg-reddit:hover { border: 1px solid %1$s; } .sis-svg-reddit:hover path { fill: %1$s; }', $r);
		echo sprintf('.sis-svg-pinterest { background-color: %1$s; border: 1px solid %1$s; } .sis-svg-pinterest:hover { border: 1px solid %1$s; } .sis-svg-pinterest:hover path { fill: %1$s; }', $p);
		echo sprintf('.sis-svg-tumblr { background-color: %1$s; border: 1px solid %1$s; } .sis-svg-tumblr:hover { border: 1px solid %1$s; } .sis-svg-tumblr:hover path { fill: %1$s; }', $tu);
		echo sprintf('.sis-svg-linkedin { background-color: %1$s; border: 1px solid %1$s; } .sis-svg-linkedin:hover { border: 1px solid %1$s; } .sis-svg-linkedin:hover path { fill: %1$s; }', $l);
		echo sprintf('.sis-svg-facebook { background-color: %1$s; border: 1px solid %1$s; } .sis-svg-facebook:hover { border: 1px solid %1$s; } .sis-svg-facebook:hover path { fill: %1$s; }', $f);
		echo sprintf('.sis-svg-digg { background-color: %1$s; border: 1px solid %1$s; } .sis-svg-digg:hover { border: 1px solid %1$s; } .sis-svg-digg:hover path { fill: %1$s; }', $d);
		echo sprintf('.sis-svg-google-plus { background-color: %1$s; border: 1px solid %1$s; } .sis-svg-google-plus:hover { border: 1px solid %1$s; } .sis-svg-google-plus:hover path { fill: %1$s; }', $g);
		echo sprintf('</style>'). "\n";
	}

	public function post_buttons( array $buttons, $type = 'site' )
	{
		$options = $this->options;

		if ( $type == 'site' ) {
			$title 			= rawurlencode(get_bloginfo('name'));
			$permalink 		= site_url();

			$pinterest 		= add_query_arg( array( 'url' => $permalink ), 'http://pinterest.com/pin/create/button/' );

			$btn_position = isset($options['site_buttons_position']) ? $options['site_buttons_position'] : 'left';

			$css_class = 'sis-site-button';

			if ($btn_position == 'left') {
				$css_class .= ' sis-left';
			} else {
				$css_class .= ' sis-right';
			}

		} else {

			$title 			= rawurlencode(get_the_title());
			$permalink 		= get_permalink();
			$thumb_id 		= get_post_thumbnail_id( get_the_ID() );
			$thumbnail 		= wp_get_attachment_image_src( $thumb_id , 'large' );
			$pinterest 	= add_query_arg( array( 'url' => $permalink, 'media' => $thumbnail[0] ), 'http://pinterest.com/pin/create/button/' );
			$css_class = 'sis-post-button';
		}

		$digg 		= add_query_arg( array( 'url' => $permalink, 'title' => $title ), 'http://digg.com/submit' );
		$facebook 	= add_query_arg( array( 'u' => $permalink ), 'http://www.facebook.com/share.php' );
		$google 	= add_query_arg( array( 'url' => $permalink ), 'https://plus.google.com/share' );
		$linkedin 	= add_query_arg( array( 'mini' => 'true', 'url' => $permalink, 'title' => $title ), 'http://www.linkedin.com/shareArticle' );
		$tumblr 	= add_query_arg( array( 'url' => $permalink, 'name' => $title ), 'http://www.tumblr.com/share/link' );
		$reddit 	= add_query_arg( array( 'url' => $permalink, 'title' => $title ), 'http://reddit.com/submit' );
		$stumble 	= add_query_arg( array( 'url' => $permalink, 'title' => $title ), 'http://www.stumbleupon.com/submit' );
		$twitter 	= add_query_arg( array( 'status' => str_replace('%26%23038%3B', '%26', $title) . '-' . $permalink ), 'http://twitter.com/home' );

		ob_start();
		?>
		<div class="sis-social-share <?php echo $css_class; ?>">
			<?php if ( in_array('digg', $buttons) ): ?>
				<a href="<?php echo $digg; ?>" target="_blank">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="sis-svg-digg" width="28" height="28" viewBox="0 0 32 28"><path d="M5.125 4.406h3.187v15.359h-8.313v-10.891h5.125v-4.469zM5.125 17.203v-5.766h-1.922v5.766h1.922zM9.594 8.875v10.891h3.203v-10.891h-3.203zM9.594 4.406v3.187h3.203v-3.187h-3.203zM14.078 8.875h8.328v14.719h-8.328v-2.547h5.125v-1.281h-5.125v-10.891zM19.203 17.203v-5.766h-1.922v5.766h1.922zM23.688 8.875h8.313v14.719h-8.313v-2.547h5.109v-1.281h-5.109v-10.891zM28.797 17.203v-5.766h-1.922v5.766h1.922z"></path></svg>
				</a>
			<?php endif; ?>
			<?php if ( in_array('facebook', $buttons) ): ?>
				<a href="<?php echo $facebook; ?>" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" class="sis-svg-facebook" width="28" height="28" viewBox="0 0 16 28"><path d="M15 0.2v4.1h-2.5c-1.9 0-2.3 0.9-2.3 2.3v3h4.6l-0.6 4.6h-4v11.9h-4.8v-11.9h-4v-4.6h4v-3.4c0-4 2.4-6.1 6-6.1 1.7 0 3.1 0.1 3.6 0.2z"/></svg>
				</a>
			<?php endif; ?>
			<?php if ( in_array('google_plus', $buttons) ): ?>
				<a href="<?php echo $google; ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=500');return false;">
					<svg xmlns="http://www.w3.org/2000/svg" class="sis-svg-google-plus" width="28" height="28" viewBox="0 0 36 28"><path d="M22.5 14.3c0 6.5-4.4 11.2-11 11.2-6.3 0-11.5-5.1-11.5-11.5s5.1-11.5 11.5-11.5c3.1 0 5.7 1.1 7.7 3l-3.1 3c-0.8-0.8-2.3-1.8-4.6-1.8-3.9 0-7.1 3.2-7.1 7.2s3.2 7.2 7.1 7.2c4.5 0 6.2-3.3 6.5-4.9h-6.5v-3.9h10.8c0.1 0.6 0.2 1.2 0.2 1.9zM36 12.4v3.3h-3.3v3.3h-3.3v-3.3h-3.3v-3.3h3.3v-3.3h3.3v3.3h3.3z"/></svg>
				</a>
			<?php endif; ?>
			<?php if( in_array('linkedin', $buttons) ): ?>
				<a href="<?php echo $linkedin; ?>" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" class="sis-svg-linkedin" width="28" height="28" viewBox="0 0 24 28"><path d="M5.5 9.8v15.5h-5.2v-15.5h5.2zM5.8 5c0 1.5-1.1 2.7-2.9 2.7v0h0c-1.7 0-2.8-1.2-2.8-2.7 0-1.5 1.2-2.7 2.9-2.7 1.8 0 2.9 1.2 2.9 2.7zM24 16.4v8.9h-5.1v-8.3c0-2.1-0.7-3.5-2.6-3.5-1.4 0-2.3 1-2.6 1.9-0.1 0.3-0.2 0.8-0.2 1.3v8.6h-5.1c0.1-14 0-15.5 0-15.5h5.1v2.3h0c0.7-1.1 1.9-2.6 4.7-2.6 3.4 0 5.9 2.2 5.9 7z"/></svg>
				</a>
			<?php endif; ?>

			<?php if( in_array('tumblr', $buttons) ): ?>
				<a href="<?php echo $tumblr; ?>" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" class="sis-svg-tumblr" width="28" height="28" viewBox="0 0 17 28"><path d="M14.8 20.8l1.3 3.7c-0.5 0.7-2.6 1.5-4.5 1.5-5.7 0.1-7.8-4-7.8-6.9v-8.5h-2.6v-3.4c3.9-1.4 4.9-5 5.1-7 0-0.1 0.1-0.2 0.2-0.2h3.8v6.6h5.2v3.9h-5.2v8.1c0 1.1 0.4 2.6 2.5 2.6 0.7 0 1.6-0.2 2.1-0.5z"/></svg>
				</a>
			<?php endif; ?>

			<?php if( in_array('pinterest', $buttons) ): ?>
				<a href="<?php echo $pinterest; ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
					<svg xmlns="http://www.w3.org/2000/svg" class="sis-svg-pinterest" width="28" height="28" viewBox="0 0 20 28"><path d="M0 9.3c0-5.8 5.3-9.3 10.6-9.3 4.9 0 9.4 3.4 9.4 8.5 0 4.9-2.5 10.3-8 10.3-1.3 0-3-0.7-3.6-1.9-1.2 4.7-1.1 5.4-3.7 9l-0.2 0.1-0.1-0.2c-0.1-1-0.2-2-0.2-2.9 0-3.2 1.5-7.8 2.2-10.9-0.4-0.8-0.5-1.8-0.5-2.6 0-1.6 1.1-3.6 2.9-3.6 1.3 0 2 1 2 2.2 0 2-1.4 3.9-1.4 5.9 0 1.3 1.1 2.3 2.4 2.3 3.6 0 4.7-5.2 4.7-8 0-3.7-2.6-5.7-6.2-5.7-4.1 0-7.3 3-7.3 7.2 0 2 1.2 3 1.2 3.5 0 0.4-0.3 1.8-0.8 1.8-0.1 0-0.2 0-0.3 0-2.2-0.7-3-3.7-3-5.7z"/></svg>
				</a>
			<?php endif; ?>

			<?php if( in_array('reddit', $buttons) ): ?>
				<a href="<?php echo $reddit; ?>" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" class="sis-svg-reddit" width="28" height="28" viewBox="0 0 28 28"><path d="M28 13.2c0 1.2-0.7 2.3-1.7 2.8 0.1 0.5 0.2 1 0.2 1.5 0 4.9-5.6 8.9-12.5 8.9-6.9 0-12.4-4-12.4-8.9 0-0.5 0.1-1 0.2-1.5-1-0.5-1.8-1.6-1.8-2.8 0-1.7 1.4-3.1 3.1-3.1 0.9 0 1.7 0.4 2.3 1 2.1-1.5 4.9-2.4 8-2.5l1.8-8.1c0.1-0.3 0.4-0.5 0.6-0.4l5.8 1.3c0.4-0.7 1.2-1.3 2.1-1.3 1.3 0 2.3 1 2.3 2.3 0 1.3-1 2.3-2.3 2.3-1.3 0-2.3-1-2.3-2.3l-5.2-1.2-1.6 7.4c3.1 0.1 6 1 8.1 2.5 0.6-0.6 1.4-1 2.2-1 1.7 0 3.1 1.4 3.1 3.1zM6.5 16.3c0 1.3 1 2.3 2.3 2.3 1.3 0 2.3-1 2.3-2.3 0-1.3-1-2.3-2.3-2.3-1.3 0-2.3 1-2.3 2.3zM19.2 21.9c0.2-0.2 0.2-0.6 0-0.8-0.2-0.2-0.6-0.2-0.8 0-0.9 1-3 1.3-4.4 1.3s-3.5-0.3-4.4-1.3c-0.2-0.2-0.6-0.2-0.8 0-0.2 0.2-0.2 0.6 0 0.8 1.5 1.5 4.3 1.6 5.2 1.6s3.7-0.1 5.2-1.6zM19.1 18.7c1.3 0 2.3-1 2.3-2.3 0-1.3-1-2.3-2.3-2.3-1.3 0-2.3 1-2.3 2.3 0 1.3 1 2.3 2.3 2.3z"/></svg>
				</a>
			<?php endif; ?>

			<?php if( in_array('stumble', $buttons) ): ?>
				<a href="<?php echo $stumble; ?>" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" class="sis-svg-stumbleupon" width="28" height="28" viewBox="0 0 30 28"><path d="M16.6 11.1v-1.8c0-0.9-0.7-1.6-1.6-1.6s-1.6 0.7-1.6 1.6v9.6c0 3.7-3 6.6-6.7 6.6-3.7 0-6.7-3-6.7-6.7v-4.2h5.1v4.1c0 0.9 0.7 1.6 1.6 1.6s1.6-0.7 1.6-1.6v-9.7c0-3.6 3.1-6.5 6.7-6.5 3.6 0 6.7 2.9 6.7 6.5v2.1l-3 0.9zM24.9 14.6h5.1v4.2c0 3.7-3 6.7-6.7 6.7-3.7 0-6.7-3-6.7-6.6v-4.2l2 1 3-0.9v4.2c0 0.9 0.7 1.6 1.6 1.6s1.6-0.7 1.6-1.6v-4.3z"/></svg>
				</a>
			<?php endif; ?>

			<?php if( in_array('twitter', $buttons) ): ?>
				<a href="<?php echo $twitter; ?>" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.0" class="sis-svg-twitter" width="28" height="28" viewBox="0 0 26 28"><path d="M25.3 6.4c-0.7 1-1.5 1.9-2.5 2.6 0 0.2 0 0.4 0 0.7 0 6.7-5.1 14.4-14.4 14.4-2.9 0-5.5-0.8-7.7-2.3 0.4 0 0.8 0.1 1.2 0.1 2.4 0 4.5-0.8 6.3-2.2-2.2 0-4.1-1.5-4.7-3.5 0.3 0 0.6 0.1 1 0.1 0.5 0 0.9-0.1 1.3-0.2-2.3-0.5-4-2.5-4-5v-0.1c0.7 0.4 1.5 0.6 2.3 0.6-1.4-0.9-2.2-2.5-2.2-4.2 0-0.9 0.3-1.8 0.7-2.5 2.5 3.1 6.2 5.1 10.4 5.3-0.1-0.4-0.1-0.8-0.1-1.2 0-2.8 2.3-5 5-5 1.5 0 2.8 0.6 3.7 1.6 1.1-0.2 2.2-0.6 3.2-1.2-0.4 1.2-1.2 2.2-2.2 2.8 1-0.1 2-0.4 2.9-0.8z"/></svg>
				</a>
			<?php endif; ?>
		</div>
		<?php
		$html = ob_get_contents();
	    ob_end_clean();
	 
	    return $html;
	}

	/**
	 * Plugin path.
	 *
	 * @return string Plugin path
	 */
	private function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Plugin url.
	 *
	 * @return string Plugin url
	 */
	private function plugin_url() {
		if ( $this->plugin_url ) return $this->plugin_url;
		return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}
}

endif;

SIS_Social_Share::instance();