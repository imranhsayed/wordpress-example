<?php
namespace Aquila\Traits;

trait Singleton {
	protected static $instance;

	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	protected function __construct() {
		// Prevent direct instantiation
	}

	final protected function __clone() {}

	final public function __wakeup() {}
}
