<?php
Class Ajax {
	protected static $instance = null;
	public $activeUser = null;
	public function __construct() {
		if (isset($_SESSION['JWT']) && !empty($_SESSION['JWT'])) {
			$this->activeUser = auth();
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
		global $_AJAX;
		$data     = array(
			'status' => 401
		);
		$class    = route(2);
		$function = route(3);
		if ($class == NULL) {
			$data['message'] = self::getInstance()->get_http_response_text($data['status']);
		} else {
			if (is_callable(array(
				self::getInstance(),
				$class
			))) {
				$data = call_user_func(array(
					self::getInstance(),
					$class
				));
			} else {
				$ajax_class_file = realpath($_AJAX . strtolower( $class ) . '.php');
				if (file_exists($ajax_class_file)) {
					require_once $ajax_class_file;
					if (is_callable(array(
						ucfirst($class),
						$function
					))) {

                        $data =  (new $class)->$function();

					} else {
						$data['status']  = 405;
						$data['message'] = __('Method Not Allowed');
					}
				} else {
					$data['status']  = 405;
					$data['message'] = __('Method Not Allowed');
				}
			}
		}
		$status_message = self::getInstance()->get_http_response_text($data['status']);
		if (!isset($data['message'])) {
			$data['message'] = $status_message;
		}
		if( !isset($data['status']) ){
            $data['status'] = 200;
        }
        if (CanSendEmails()) {
            $data['can_send'] = 1;
        }else{
            $data['can_send'] = 0;
        }
		http_response_code($data['status']);
		header('HTTP/1.1 ' . $data['status'] . '  ' . $status_message);
		header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($data);
		exit();
	}
	public static function get_http_response_text($code = NULL) {
		$text = '';
		if ($code !== NULL) {
			switch ($code) {
				case 100:
					$text = 'Continue';
					break;
				case 101:
					$text = 'Switching Protocols';
					break;
				case 200:
					$text = 'OK';
					break;
				case 201:
					$text = 'Created';
					break;
				case 202:
					$text = 'Accepted';
					break;
				case 203:
					$text = 'Non-Authoritative Information';
					break;
				case 204:
					$text = 'No Content';
					break;
				case 205:
					$text = 'Reset Content';
					break;
				case 206:
					$text = 'Partial Content';
					break;
				case 300:
					$text = 'Multiple Choices';
					break;
				case 301:
					$text = 'Moved Permanently';
					break;
				case 302:
					$text = 'Moved Temporarily';
					break;
				case 303:
					$text = 'See Other';
					break;
				case 304:
					$text = 'Not Modified';
					break;
				case 305:
					$text = 'Use Proxy';
					break;
				case 400:
					$text = 'Bad Request';
					break;
				case 401:
					$text = 'Unauthorized';
					break;
				case 402:
					$text = 'Payment Required';
					break;
				case 403:
					$text = 'Forbidden';
					break;
				case 404:
					$text = 'Not Found';
					break;
				case 405:
					$text = 'Method Not Allowed';
					break;
				case 406:
					$text = 'Not Acceptable';
					break;
				case 407:
					$text = 'Proxy Authentication Required';
					break;
				case 408:
					$text = 'Request Time-out';
					break;
				case 409:
					$text = 'Conflict';
					break;
				case 410:
					$text = 'Gone';
					break;
				case 411:
					$text = 'Length Required';
					break;
				case 412:
					$text = 'Precondition Failed';
					break;
				case 413:
					$text = 'Request Entity Too Large';
					break;
				case 414:
					$text = 'Request-URI Too Large';
					break;
				case 415:
					$text = 'Unsupported Media Type';
					break;
				case 500:
					$text = 'Internal Server Error';
					break;
				case 501:
					$text = 'Not Implemented';
					break;
				case 502:
					$text = 'Bad Gateway';
					break;
				case 503:
					$text = 'Service Unavailable';
					break;
				case 504:
					$text = 'Gateway Time-out';
					break;
				case 505:
					$text = 'HTTP Version not supported';
					break;
				default:
					$text = 'Unknown http status code "' . htmlentities($code) . '"';
					break;
			}
		} else {
			$text = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
		}
		return $text;
	}
}
