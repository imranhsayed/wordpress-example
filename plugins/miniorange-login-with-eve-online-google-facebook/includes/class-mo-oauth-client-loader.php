<?php
/**
 * Plugin Loader
 *
 * @package    plugin-loader
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Load OAuth Client plugin
 */
class MO_OAuth_Client_Loader {

	/**
	 * Actions to load inside plugin
	 *
	 * @var actions actions to load inside plugin.
	 */
	protected $actions;

	/**
	 * Filters to load inside plugin
	 *
	 * @var filters filters to load inside plugin.
	 */
	protected $filters;

	/**
	 * Initialize actions and filters.
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Action
	 *
	 * @param mixed $hook WordPress hook.
	 * @param mixed $component WordPress component.
	 * @param mixed $callback function to be called.
	 * @param int   $priority priority of the function to be called.
	 * @param int   $accepted_args arguments to be passed to the callback function.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}


	/**
	 * Fitler
	 *
	 * @param mixed $hook WordPress hook.
	 * @param mixed $component WordPress component.
	 * @param mixed $callback function to be called.
	 * @param int   $priority priority of the function to be called.
	 * @param int   $accepted_args arguments to be passed to the callback function.
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a hook.
	 *
	 * @param mixed $hooks WordPress hook.
	 * @param mixed $hook WordPress hook.
	 * @param mixed $component WordPress component.
	 * @param mixed $callback function to be called.
	 * @param int   $priority priority of the function to be called.
	 * @param int   $accepted_args arguments to be passed to the callback function.
	 * @return [hook]
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		return $hooks;

	}

	/**
	 * Add actions and filters
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], isset( $hook['component'] ) && ! empty( $hook['component'] ) ? array( $hook['component'], $hook['callback'] ) : $hook['callback'], $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], isset( $hook['component'] ) && ! empty( $hook['component'] ) ? array( $hook['component'], $hook['callback'] ) : $hook['callback'], $hook['priority'], $hook['accepted_args'] );
		}

	}

}
