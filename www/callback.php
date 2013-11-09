<?
	include $_SERVER['DOCUMENT_ROOT'] . '/include/include.php';
	
	try
	{
		$callback_content = module::factory( 'callback' );
		$callback_content -> init( array(), true );
		
		print $callback_content -> get_content();
	}
	catch ( Exception $e )
	{
		//
	}
?>
