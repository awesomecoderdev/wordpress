<?php

namespace AwesomeCoder\Lumi\Core;

use AwesomeCoder\Lumi\Loader;
use AwesomeCoder\Lumi\Backend;
use AwesomeCoder\Lumi\Wp\Ajax;
use AwesomeCoder\Lumi\Frontend;
use AwesomeCoder\Lumi\Core\Taxonomies;
use AwesomeCoder\Lumi\Hooks\Authorization;
use AwesomeCoder\Lumi\Localization\L18n;

class Lumi
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the template.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the template.
	 */
	protected $loader;

	/**
	 * The unique identifier of this template.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $template_name    The string used to uniquely identify this template.
	 */
	protected $template_name;

	/**
	 * The current version of the template.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the template.
	 */
	protected $version;

	/**
	 * Define the core functionality of the template.
	 *
	 * Set the template name and the template version that can be used throughout the template.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('LUMI_VERSION')) {
			$this->version = LUMI_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->template_name = 'lumi';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_ajax_hooks();
	}

	/**
	 * Load the required dependencies for this template.
	 *
	 * Include the following files that make up the template:
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core template.
		 */
		require_once LUMI_THEME_PATH . 'includes/Loader/Loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the template.
		 */
		require_once LUMI_THEME_PATH . 'includes/Localization/I18n.php';

		/**
		 * The class responsible for defining hooks functionality
		 * of the template.
		 */
		require_once LUMI_THEME_PATH . 'includes/Hooks/Activator.php';

		/**
		 * The class responsible for defining hooks functionality
		 * of the template.
		 */
		require_once LUMI_THEME_PATH . 'includes/Hooks/Deactivator.php';

		/**
		 * The class responsible for defining hooks functionality
		 * of the template.
		 */
		// require_once LUMI_THEME_PATH . 'includes/Hooks/Woocommerce.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once LUMI_THEME_PATH . 'app/Backend/Backend.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once LUMI_THEME_PATH . 'app/Frontend/Frontend.php';

		$this->loader = new Loader();
	}

	/**
	 * Define the locale for this template for internationalization.
	 *
	 * Uses the Ac_Restaurant_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$template_i18n = new L18n();

		$this->loader->add_action('after_setup_theme', $template_i18n, 'load_template_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the template.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{
		$template_admin = new Backend($this->get_template_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $template_admin, 'enqueue_styles', 99999999);
		$this->loader->add_action('admin_enqueue_scripts', $template_admin, 'enqueue_scripts', 99999999);

		/** register dashboard menu */
		$this->loader->add_action('admin_menu', $template_admin, 'lumi_admin_menu');
		/** after setup theme */
		$this->loader->add_action('after_setup_theme', $template_admin, 'lumi_after_setup_theme');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the template.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$template_public = new Frontend($this->get_template_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $template_public, 'enqueue_styles', 99999999);
		$this->loader->add_action('wp_enqueue_scripts', $template_public, 'enqueue_scripts', 99999999);
	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the template.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_ajax_hooks()
	{
		$template_admin = new Backend($this->get_template_name(), $this->get_version());
		$template_public = new Frontend($this->get_template_name(), $this->get_version());
		$template_both = new LumiAjaxController($this->get_template_name(), $this->get_version());

		/** register ajax */
		// $this->loader->add_action("wp_ajax_ac_restaurant_ajax_request", $template_admin, 'handel_ac_restaurant_admin_ajax_requests');
		Ajax::both($this->loader, "wishlist", $template_both, "wishlist");
		Ajax::both($this->loader, "remove_from_cart", $template_both, "removeFromCart");
		Ajax::both($this->loader, "update_cart", $template_both, "updateCart");
		Ajax::both($this->loader, "login", $template_both, "login");

		/** register frontend only ajax */
		// $this->loader->add_action("wp_ajax_nopriv_ac_restaurant_ajax_request", $template_public, 'handel_ac_restaurant_public_ajax_requests');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
		Taxonomies::run();
	}

	/**
	 * The name of the template used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the template.
	 */
	public function get_template_name()
	{
		return $this->template_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the template.
	 *
	 * @since     1.0.0
	 * @return    Loader    Orchestrates the hooks of the template.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the template.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the template.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
