<?
	include $_SERVER['DOCUMENT_ROOT'] . '/include/include.php';
	
	$captcha_id = init_string( 'captcha_id' );
	
	if ( isset( $_SESSION['CAPTCHA'][$captcha_id] ) )
		$captcha_value = $_SESSION['CAPTCHA'][$captcha_id];
	else
		$captcha_value = 'ERROR!';
	
	captcha::display( $captcha_value );
?>
