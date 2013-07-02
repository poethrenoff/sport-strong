<?
	include $_SERVER['DOCUMENT_ROOT'] . '/include/include.php';
	
	$tpl = new SmartyClient();
	
	try
	{
		$cart_info = module::factory( 'cart' );
		$cart_info -> init( array( 'mode' => 'info' ) );
		$tpl -> assign( 'cart', $cart_info -> get_content() );
		
		$catalogue_menu = module::factory( 'catalogue' );
		$catalogue_menu -> init( array( 'mode' => 'menu' ) );
		
		$news_short = module::factory( 'news' );
		$news_short -> init( array( 'mode' => 'main', 'items_per_page' => 3 ) );
		
		$order_content = module::factory( 'order' );
		$order_content -> init( array(), true );
		
		$tpl -> assign( 'content', $order_content -> get_content() );
		$tpl -> assign( 'meta', $order_content -> get_meta() );
		$tpl -> assign( 'path', $order_content -> get_path() );
		
		$tpl -> assign( 'menu', $catalogue_menu -> get_content() );
		$tpl -> assign( 'news', $news_short -> get_content() );
		
		$tpl -> display( 'index.tpl' );
	}
	catch ( Exception $e )
	{
		$tpl -> assign( 'error', nl2br( htmlspecialchars( $e ) ) );
		
		$tpl -> display( 'error.tpl' );
	}
?>
