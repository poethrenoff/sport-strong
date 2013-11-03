<?
	include $_SERVER['DOCUMENT_ROOT'] . '/include/include.php';
	
	$tpl = new SmartyClient();
	
	try
	{
		$cart_status = module::factory( 'cart' );
		$cart_status -> init();

		$cart_info = module::factory( 'cart' );
		$cart_info -> init( array( 'mode' => 'info' ) );
		
		$tpl -> assign( 'cart', $cart_info -> get_content() );

		$compare_status = module::factory( 'compare' );
		$compare_status -> init();

		$catalogue_menu = module::factory( 'catalogue' );
		$catalogue_menu -> init( array( 'mode' => 'menu' ) );
		
		$catalogue_brand = module::factory( 'catalogue' );
		$catalogue_brand -> init( array( 'mode' => 'brand' ) );
		
		$news_short = module::factory( 'news' );
		$news_short -> init( array( 'mode' => 'main', 'items_per_page' => 3 ) );
		
		$catalogue_content = module::factory( 'catalogue' );
		$catalogue_content -> init(
			array( 'cols_per_page_catalogue' => 3, 'cols_per_page_product' => 3 ), true );
		
		$tpl -> assign( 'content', $catalogue_content -> get_content() );
		$tpl -> assign( 'meta', $catalogue_content -> get_meta() );
		$tpl -> assign( 'path', $catalogue_content -> get_path() );

		$tpl -> assign( 'menu', $catalogue_menu -> get_content() );
		$tpl -> assign( 'brand', $catalogue_brand -> get_content() );
		$tpl -> assign( 'news', $news_short -> get_content() );

		$tpl -> display( 'index.tpl' );
	}
	catch ( Exception $e )
	{
		require_once('error404.php');
	}
