<?

if (preg_match (('#/{2,}#'), $_SERVER['REQUEST_URI'])):
   require_once('error404.php');
endif;


if($_SERVER['REQUEST_URI']=='/index.php')
{
     header("HTTP/1.1 301 Moved Permanently");
     header("Location: /");
     exit();
}
ob_start();

	include $_SERVER['DOCUMENT_ROOT'] . '/include/include.php';
	
	$tpl = new SmartyClient();
	
	try
	{
		$cart_status = module::factory( 'cart' );
		$cart_status -> init();
		
		$cart_info = module::factory( 'cart' );
		$cart_info -> init( array( 'mode' => 'info' ) );
		$tpl -> assign( 'cart', $cart_info -> get_content() );
		
		$catalogue_menu = module::factory( 'catalogue' );
		$catalogue_menu -> init( array( 'mode' => 'menu' ) );
		
		$catalogue_brand = module::factory( 'catalogue' );
		$catalogue_brand -> init( array( 'mode' => 'brand' ) );
		
		$news_short = module::factory( 'news' );
		$news_short -> init( array( 'mode' => 'main', 'items_per_page' => 3 ) );
		
		$text_content_top = module::factory( 'text' );
		$text_content_top -> init( array( 'tag' => 'top' ), true );
		
		$catalogue_marker_list = module::factory( 'catalogue' );
		$catalogue_marker_list -> init( array( 'mode' => 'marker_list',
			'marker_list' => array( 'offer', 'novelty', 'special' ), 'marker_count' => 4 ) );
		$tpl -> assign( 'output_marker_list', $catalogue_marker_list->get_marker_list());
		
		$text_content_bottom = module::factory( 'text' );
		$text_content_bottom -> init( array( 'tag' => 'bottom' ) );
		
		$content = 
			$text_content_top -> get_content().
			$text_content_bottom -> get_content();
        
		$tpl -> assign( 'content', $content );
		if ($_SERVER['REQUEST_URI']='/')
		{
			$tpl -> assign( 'main_page_flag', 1);
		}
		else
		{
			$tpl -> assign( 'main_page_flag', 0);
		}
		
		$tpl -> assign( 'menu', $catalogue_menu -> get_content() );
		$tpl -> assign( 'brand', $catalogue_brand -> get_content() );
		$tpl -> assign( 'meta', $text_content_top -> get_meta() );
		$tpl -> assign( 'news', $news_short -> get_content() );
		
		$tpl -> display( 'index.tpl' );
	}
	catch ( Exception $e )
	{
		$tpl -> assign( 'error', nl2br( htmlspecialchars( $e ) ) );
		
		$tpl -> display( 'error.tpl' );
	}

$content = ob_get_clean();

$content = preg_replace('#/catalogue.php\?catalogue_id=19">#','/begovye_dorozhki_dlya_doma/">',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=20#','/velotrenazhery_dlya_doma/',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=21#','/ellipticheskie_trenazhery_dlya_doma/',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=22#','/steppery_dlya_doma/',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=24#','/grebnye_trenazhery_dlya_doma/',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=26#','/silovye_trenazhery_dlya_doma/',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=32#','/bokserskij_vodonalivnoj_meshok/',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=52#','/detskiy_batut_dlya_dachi/?',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=54#','/basseyny_dlya_dachi/',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=55#','/basseyny_dlya_dachi/sbornye_karkasnye/',$content);
$content = preg_replace('#/catalogue.php\?catalogue_id=56#','/basseyny_dlya_dachi/naduvnye/',$content);
$content = preg_replace('#/product.php\?product_id=1581#','/bokserskij_vodonalivnoj_meshok/century bob/',$content);



echo $content;