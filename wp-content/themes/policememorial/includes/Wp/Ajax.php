<?php

namespace AwesomeCoder\Lumi\Wp;

use AwesomeCoder\Lumi\Loader;

/**
 * Handel ajax that is shown in the WordPress Admin.
 *
 * @since 0.1
 */
class Ajax
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
     * Constructor.
     *
     * @since 0.1
     *
     * @param int         $type Either {@link Asset::SCRIPT} or {@link Asset::style}.
     * @param string      $url  The URL of the asset.
     * @param string|null $ver  The version of the asset, used for caching.
     * @param string[]    $deps Keys of dependency assets of the same type.
     */
    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Creates a frontend ajax handler.
     *
     * @since 0.1
     *
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     *
     */
    public static function frontend(Loader $loader, string $action = "awesomecoder", $component, $callback, ...$args)
    {
        $loader->add_action("wp_ajax_nopriv_lumi_{$action}", $component, $callback, ...$args);
    }

    /**
     * Creates a backend ajax handler.
     *
     * @since 0.1
     *
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     *
     */
    public static function backend(Loader $loader, string $action = "awesomecoder", $component, $callback, ...$args)
    {
        $loader->add_action("wp_ajax_lumi_{$action}", $component, $callback, ...$args);
    }


    /**
     * Creates a backend ajax handler.
     *
     * @since 0.1
     *
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     *
     */
    public static function both(Loader $loader, string $action = "awesomecoder", $component, $callback, ...$args)
    {
        $loader->add_action("wp_ajax_lumi_$action", $component, $callback, ...$args);
        $loader->add_action("wp_ajax_nopriv_lumi_$action", $component, $callback, ...$args);
    }

    /**
     * @since    1.0.0
     * @param mixed $name   The method name which have to call.
     * @var   array $arguments    Maintains and registers all hooks for the template.
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        } else {
            throw new \BadMethodCallException("Call to undefined method '$name'");
        }
    }

    /**
     * @since    1.0.0
     * @param mixed $name   The method name which have to call.
     * @var   array $arguments    Maintains and registers all hooks for the template.
     */
    public static function __callStatic($name, $arguments)
    {
        if (method_exists(static::class, $name)) {
            return forward_static_call_array([static::class, $name], $arguments);
        } else {
            throw new \BadMethodCallException("Call to undefined static method '$name'");
        }
    }
}
