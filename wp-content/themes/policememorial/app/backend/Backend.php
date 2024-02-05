<?php

namespace AwesomeCoder\Lumi;

use AwesomeCoder\Lumi\Wp\AdminPage;
use AwesomeCoder\Lumi\Wp\Asset;
use AwesomeCoder\Lumi\Wp\Menu;
use AwesomeCoder\Lumi\Wp\SubMenu;

class Backend
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
	 * @param      string    $template_name       The name of this template.
	 * @param      string    $version    The version of this template.
	 */
	public function __construct($template_name, $version)
	{

		$this->template_name = $template_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook)
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


		Asset::style($this->template_name, "backend/css/lumi-admin.css", $this->version, [], 'all');

		// color picker
		wp_enqueue_style('wp-color-picker');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		// wp enqueue media
		wp_enqueue_media();

		// enqueue colo-picker
		wp_enqueue_script('wp-color-picker');


		Asset::script($this->template_name, "assets/backend/js/lumi-admin.js", $this->version, ['jquery'], false, true);

		// Some local vairable to get ajax url
		wp_localize_script($this->template_name, 'lumi', array(
			"author"  	=> [
				"author" 	=>	"Mohammad Ibrahim Kholil",
				"email" 	=>	"awesomecoder.dev@gmail.com",
				"url" 	=>	"https://www.awesomecoder.dev",
			],
			"url" 		=> trailingslashit(get_bloginfo('url')),
			"carturl" 	=> trailingslashit(get_bloginfo('url')) . "?wc-ajax=add_to_cart",
			"ajaxurl"	=> admin_url("admin-ajax.php")
		));
	}

	/**
	 * After setup theme Function
	 *
	 * @since    1.0.0
	 */
	public function lumi_after_setup_theme()
	{
		/**
		 * This function is provided Dashboard Menu for the admin area.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ac_product_compare_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ac_product_compare_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		require_once LUMI_THEME_PATH . "includes/Hooks/Theme.php";
	}


	/**
	 * Register the Dashboard Menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function lumi_admin_menu()
	{

		/**
		 * This function is provided Dashboard Menu for the admin area.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ac_product_compare_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ac_product_compare_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$icon = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBzdHlsZT0iZmlsbDojYTdhYWFkIj48cGF0aCBkPSJNOSA5aDZ2Nkg5eiI+PC9wYXRoPjxwYXRoIGQ9Ik0yMCA2YzAtMS4xMDMtLjg5Ny0yLTItMmgtMlYyaC0ydjJoLTRWMkg4djJINmMtMS4xMDMgMC0yIC44OTctMiAydjJIMnYyaDJ2NEgydjJoMnYyYzAgMS4xMDMuODk3IDIgMiAyaDJ2Mmgydi0yaDR2Mmgydi0yaDJjMS4xMDMgMCAyLS44OTcgMi0ydi0yaDJ2LTJoLTJ2LTRoMlY4aC0yVjZ6TTYgMThWNmgxMmwuMDAyIDEySDZ6Ij48L3BhdGg+PC9zdmc+";
		$menu = new AdminPage(__("Lumi", 'lumi'), fn () => lumi_resource());
		// Menu::register(new Menu($menu, 'lumi', __("Lumi", 'lumi'), "manage_options", $icon, 50));
		// SubMenu::registerFor("lumi", SubMenu::page($menu, "hello", __("Lumi", 'lumi'), "manage_options",));


		// // add menu on adminbar
		// add_menu_page('Restaurant', 'Restaurant', 'manage_options', 'ac_restaurant',  array($this, 'ac_restaurant_activator_callback'), 'dashicons-podio', 50); //dashicons-share-alt

		// // add submenu on adminbar
		// add_submenu_page('ac_restaurant', 'Dashboard', 'Dashboard', 'manage_options', 'ac_restaurant',   array($this, 'ac_restaurant_dashboard_callback'));
		// add_submenu_page('ac_restaurant', 'User Inbox', 'User Inbox', 'manage_options', 'ac_restaurant_inbox_user',   array($this, 'ac_restaurant_inbox_user_callback'));
	}

	/**
	 * Register Admin Menu Activator CallBack Function
	 *
	 * @since    1.0.0
	 */
	public function ac_restaurant_activator_callback()
	{
		// Default function for activate admin menu
	}

	/**
	 * Register Dashboard menu callback function
	 *
	 * @since    1.0.0
	 */
	public function ac_restaurant_dashboard_callback()
	{
		ob_start();
		// include_once AC_RESTAURANT_THEME_PATH . 'admin/partials/ac-restaurant-admin-dashboard.php';
		$dashboard = ob_get_contents();
		ob_end_clean();
		echo $dashboard;
	}

	/**
	 * handel admin ajax requests
	 *
	 * @since    1.0.0
	 */
	public function handel_ac_restaurant_admin_ajax_requests()
	{
		$response = $_REQUEST["ac_action"];

		if ($response == "cart_count") {
			global $woocommerce;
			echo $woocommerce->cart->cart_contents_count;
		}
		//end ajax
		wp_die();
	}
}
