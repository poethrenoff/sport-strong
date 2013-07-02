<?
	ini_set( 'display_errors', true );
	ini_set( 'error_reporting', E_ALL );
	
	setlocale( LC_ALL, 'ru_RU.UTF8' );
	
	set_include_path( get_include_path() . PATH_SEPARATOR .
		$_SERVER['DOCUMENT_ROOT'] . '/common/PEAR' );
	
	$_CONFIG = array (
		'DB_TYPE'		=> 'mysql',
		'DB_HOST'		=> 'localhost',
		'DB_NAME'		=> 'sport_strong',
		'DB_USER'		=> 'sport_strong',
		'DB_PASS'		=> 'sport_strong',
		
		'SITE_TITLE'	=> 'Sport-Strong.ru',
	);
	
	foreach ( $_CONFIG as $cnf_key => $cnf_value )
		define( $cnf_key, $cnf_value );
?>
