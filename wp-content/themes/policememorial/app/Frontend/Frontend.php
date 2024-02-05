<?php

namespace AwesomeCoder\Lumi;

use AwesomeCoder\Lumi\Wp\Asset;

class Frontend
{

	/**
	 * The ID of this template.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $template_name    The ID of this template.
	 */
	private $template_name;

	/**
	 * The version of this template.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this template.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $template_name       The name of the template.
	 * @param      string    $version    The version of this template.
	 */
	public function __construct($template_name, $version)
	{

		$this->template_name = $template_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Asset::style($this->template_name, 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css', $this->version, [],  'all', true);
		// Asset::style($this->template_name, 'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css', $this->version, [], 'all', true);
		Asset::style($this->template_name, 'css/boxicons.min.css', "2.1.4", [], 'all');
		// Asset::style($this->template_name, 'https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css', $this->version, [], 'all', true);
		Asset::style($this->template_name, 'assets/css/jquery.toast.min.css', $this->version, [], 'all', true);
		Asset::style($this->template_name, 'css/styles.css', $this->version, [], 'all');
		Asset::style($this->template_name, 'frontend/css/lumi-public.css', $this->version, [],  'all');
		Asset::style($this->template_name, 'frontend/css/frontend.css', $this->version, [], 'all');
		Asset::style($this->template_name, 'style.css', $this->version, [], 'all', true);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		Asset::script($this->template_name, "assets/frontend/js/init.js", $this->version, ['jquery'], false, true);
		Asset::script($this->template_name, "js/jquery.js", $this->version, ['jquery', 'wp-embed']);
		Asset::script($this->template_name, "js/sweetalert.min.js", $this->version, ['jquery', 'wp-embed']);
		// Asset::script($this->template_name, "https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js", $this->version, ['jquery', 'wp-embed'], true, true);
		Asset::script($this->template_name, "frontend/js/jquery.toast.min.js", $this->version, ['jquery', 'wp-embed'], true);
		Asset::script($this->template_name, "js/jquery.validate.min.js", $this->version, ['jquery', 'wp-embed']);
		Asset::script($this->template_name, "js/scrollreveal.js", $this->version, ['jquery', 'wp-embed']);
		Asset::script($this->template_name, "js/main.js", $this->version, ['jquery', 'wp-embed']);
		Asset::script($this->template_name, "frontend/js/lumi-public.js", $this->version, ['jquery']);


		// Some local vairable to get ajax url
		wp_localize_script($this->template_name, 'lumi', array(
			"author"  	=> [
				"author" 	=>	"Mohammad Ibrahim Kholil",
				"email" 	=>	"awesomecoder.dev@gmail.com",
				"url" 	=>	"https://www.awesomecoder.dev",
			],
			"toast" 	=> [
				"success" => [
					"heading" => __("Success", "lumi"),
					"message" => __("Product successfully added to bag.", "lumi"),
				],
				"error" => [
					"heading" => __("Error", "lumi"),
					"message" => __("Something went wrong. Please contact us.", "lumi"),
				]
			],
			"url" 		=> trailingslashit(get_bloginfo('url')),
			"carturl" 	=> trailingslashit(get_bloginfo('url')) . "?wc-ajax=add_to_cart",
			"ajaxurl"	=> admin_url("admin-ajax.php")
		));
	}


	// handel public ajax requests
	public function handel_lumi_public_ajax_requests()
	{
		$response = $_REQUEST["ac_action"];

		if ($response == "cart_count") {
			global $woocommerce;
			echo $woocommerce->cart->cart_contents_count;
		}
		// print_r($_REQUEST);

		//end ajax
		wp_die();
	}
}
