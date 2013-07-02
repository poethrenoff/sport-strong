<?
	include $_SERVER['DOCUMENT_ROOT'] . '/include/include.php';
	
	try
	{
		$export_content = module::factory( 'export' );
		$export_content -> init( array(), true );
		
		header( 'Content-Type: text/xml; charset=utf8' );
		
		print $export_content -> get_content();
	}
	catch ( Exception $e )
	{
		$tpl = new SmartyClient();
		
		$tpl -> assign( 'error', nl2br( htmlspecialchars( $e ) ) );
		
		$tpl -> display( 'error.tpl' );
	}
?>
