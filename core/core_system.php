<?php

class CoreSystem {

	private static $_systemClasses = array ('season', 'campaign', 'site', 'plot', 'species', 
	                                        'individual', 'ecofisio', 'struture', 'user');

	public static function retriveClassFrom($address) {

		foreach(self::$_systemClasses as $class) {
			if (strpos($address, $class) !== false) {
				return $class;
			}
		}

		return 'invalid';
	}

	public static function retriveReturnUrl($current_address){

		$class = self::retriveClassFrom($current_address);
		$next_address = '';

		if ($class == 'ecofisio' || $class == 'struture') {
			$next_address = '/lists/individual-list.php';
		} else if ($class !== 'invalid') {
			$next_address = '/lists/' . $class . '-list.php';
		} else {
			$next_address = '/index.php';
		}

		return $next_address;

	}

	public static function getClasses() {
		return self::$_systemClasses;
	}

}