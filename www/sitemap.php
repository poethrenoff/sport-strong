<?
	$_SERVER['DOCUMENT_ROOT'] = dirname( __FILE__ );
	
    include_once $_SERVER['DOCUMENT_ROOT'] . '/include/include.php';
    
    $file_name = $_SERVER['DOCUMENT_ROOT'] . '/../tmp/sitemap.xml';
    
	header( 'Content-type: text/xml; charset: UTF-8' );
    
    if ( file_exists($file_name) && (filemtime($file_name) > time() - 60 * 60 * 24) ) {
        readfile($file_name); exit;
    }
	
	$site_url = 'http://sport-strong.ru/';
	
	$sitemap = array();
	
	// Главная
	$sitemap[] = array(
		'loc' => $site_url,
		'lastmod' => date( 'Y-m-d', time() - 60 * 60 * 24 * mt_rand( 0, 6 ) ),
		'changefreq' => 'weekly',
		'priority' => 1 );
	
	// Текстовые страницы
	foreach ( array( 'about.php', 'delivery.php' ) as $page )
		$sitemap[] = array(
			'loc' => $site_url . $page,
			'lastmod' => date( 'Y-m-d', time() - 60 * 60 * 24 * mt_rand( 0, 6 ) ),
			'changefreq' => 'weekly',
			'priority' => 0.5 );
	
	// Каталог
	$catalogue_list = db::select_all( 'select catalogue_url from catalogue where catalogue_active = 1 order by catalogue_id' );
	
	foreach ( $catalogue_list as $catalogue_item )
	{
		$sitemap[] = array(
			'loc' => $site_url . $catalogue_item['catalogue_url'] . '/',
			'lastmod' => date( 'Y-m-d', time() - 60 * 60 * 24 * mt_rand( 0, 6 ) ),
			'changefreq' => 'weekly',
			'priority' => 0.5 );
	}
	
	// Товары
	$product_list = db::select_all( 'select catalogue_url, product_url from product inner join catalogue on catalogue_id = product_catalogue where product_active = 1 and catalogue_active = 1 order by product_id' );
	
	foreach ( $product_list as $product_item )
		$sitemap[] = array(
			'loc' => $site_url . $catalogue_item['catalogue_url'] . '/' . $product_item['product_url'] . '/',
			'lastmod' => date( 'Y-m-d', time() - 60 * 60 * 24 * mt_rand( 0, 6 ) ),
			'changefreq' => 'weekly',
			'priority' => 0.3 );
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	$sitemap_xml = <<<HEADER
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

HEADER;
	
	foreach ( $sitemap as $url )
		$sitemap_xml .= <<<URL
	<url>
		<loc>{$url['loc']}</loc>
		<lastmod>{$url['lastmod']}</lastmod>
		<changefreq>{$url['changefreq']}</changefreq>
		<priority>{$url['priority']}</priority>
	</url>

URL;
	
	$sitemap_xml .= <<<FOOTER
</urlset>

FOOTER;
	
	file_put_contents( $file_name, $sitemap_xml );
    
    print $sitemap_xml;
