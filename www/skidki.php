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
		
		$text_content = module::factory( 'text' );
		$text_content -> init( array( 'tag' => 'skidki' ), true );
		
		$tpl -> assign( 'content', $text_content -> get_content() );
		$tpl -> assign( 'meta', $text_content -> get_meta() );
		$tpl -> assign( 'path', $text_content -> get_path() );
		
		$tpl -> assign( 'menu', $catalogue_menu -> get_content() );
		$tpl -> assign( 'news', $news_short -> get_content() );
		
		$tpl -> display( 'index.tpl' );
	}
	catch ( Exception $e )
	{
		require_once('error404.php');
	}
?>
