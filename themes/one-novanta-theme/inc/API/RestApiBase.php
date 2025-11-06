<?php
/**
 * Custom REST API base file.
 * This file includes base and abstract functions that will be used when a class extends this abstract class.
 *
 * @package OneNovanta
 */

namespace OneNovanta\Theme\API;

use OneNovanta\Traits\Singleton;

/**
 * This class registers custom REST API routes.
 */
abstract class RestApiBase {
	use Singleton;

	/**
	 * The first URL segment after the core prefix. Should be unique to your package/plugin.
	 *
	 * @var string
	 */
	protected static $route_namespace = 'one-novanta/v1';

	/**
	 * Constructor: Initializes the setup function.
	 */
	final protected function __construct() {
		$this->setup_function();
	}

	/**
	 * Adds the rest_action_callback_function to the rest_api_init hook.
	 *
	 * @return void
	 */
	final protected function setup_function() {
		add_action( 'rest_api_init', [ $this, 'rest_action_callback_function' ] );
	}

	/**
	 * Registers a custom REST route.
	 *
	 * @param string               $route_namespace           The namespace for the REST route.
	 * @param string               $route                     The REST route endpoint.
	 * @param string               $method                    HTTP method (GET, POST, etc.).
	 * @param string               $callback_func_name        Callback function name for handling the request.
	 * @param string               $permission_callback_name  Callback function name for permissions check.
	 * @param array<string, mixed> $args                      Optional. Additional arguments for the route (e.g., validation).
	 *
	 * @return void
	 */
	final public function register_custom_route( $route_namespace, $route, $method, $callback_func_name, $permission_callback_name, $args = [] ) {
		$rest_args = [
			'methods'             => $method,
			'callback'            => [ $this, $callback_func_name ],
			'permission_callback' => [ $this, $permission_callback_name ],
		];

		if ( ! empty( $args ) ) {
			$rest_args['args'] = $args;
		}

		register_rest_route(
			$route_namespace,
			$route,
			$rest_args
		);
	}

	/**
	 * Registers custom endpoints.
	 *
	 * @return void
	 */
	abstract public function rest_action_callback_function();
}
