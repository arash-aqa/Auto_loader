<?php

namespace src;

class Autoloader {

	/**
	 * Autoloader constructor.
	 * This constructor calls spl_autoload_register method with autoload method
	 * inside Autoloader class.
	 *
	 * @access public
	 */
	public function __construct() {
		spl_autoload_register( array( $this, 'autoload' ) );
		echo " auto loader start";
	}

	public function autoload( $class_name ) {

		$file_parts = explode ( '\\', $class_name);
//		 Do a reverse loop through $file_parts to build a path to the file.
//		mapping through the namespace and change it to folder name.
		$namespace = '';
		$file_name = '';
		$count = count( $file_parts ) - 1 ;
		for ( $i = $count ;$i > (-1); $i -- ) {

			$current = strtolower ( $file_parts[$i] );
			$current = str_ireplace ( '_', '-', $current);

			if ( $count === $i ){
				$file_name = "{$current}.php";
			}
			else{
				$namespace = '/' . $current . $namespace;
			}
		}
//		Build a path to the file using mapping to the file location.
		$file_path = dirname ( dirname ( __FILE__)) . $namespace;
//		file name MUST be same as class name. YOU CAN CHANGE THE RULE FROM HERE.
		$file_path = $file_path . '/' . $file_name;

//		If the file exists in the specified path, then include it.
		if ( file_exists ( $file_path)){
			include_once $file_path;
		} else{
			echo ( "The file attempting to be loaded at $file_path does not exist." ) ;
			return;
		}

	}
}
new Autoloader();