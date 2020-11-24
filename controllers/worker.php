<?php
Class Worker {
	protected static $instance = null;
	public $activeUser = null;
	public function __construct() {
		if (isset($_SESSION['userProfile']) && !empty($_SESSION['userProfile'])) {
			$this->activeUser = $_SESSION['userProfile'];
		}
	}
	public static function ActiveUser() {
		return self::getInstance()->activeUser;
	}
	public static function Config() {
		global $config;
		return $config;
	}
	public static function Mail() {
		global $mail;
		return $mail;
	}
	public static function getInstance() {
		if (!isset(static::$instance)) {
			static::$instance = new static;
		}
		return static::$instance;
	}
	public static function show() {
		global $_WORKER;
		$class    = route(2);
		$function = route(3);
		$response = '';
		if ($class == NULL) {

		} else {
			if (is_callable(array(
				self::getInstance(),
				$class
			))) {
				$response = call_user_func(array(
					self::getInstance(),
					$class
				));
			} else {
				$worker_class_file = realpath($_WORKER . $class . '.php');
				if (file_exists($worker_class_file)) {
					require_once $worker_class_file;
					if (is_callable(array(
						ucfirst($class),
						$function
					))) {
						$response = call_user_func(array(
							ucfirst($class),
							$function
						));
					}
				}
			}
		}
		$data = json_encode(array(
			$response
		));
		session_write_close();
		ignore_user_abort(false);
		set_time_limit(0);
		clearstatcache();
		header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header('Content-Type: application/javascript; charset=UTF-8');
		echo 'processData(' . json_encode($data) . ');';
		exit();
	}
}
