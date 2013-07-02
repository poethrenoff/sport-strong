<?
	include $_SERVER['DOCUMENT_ROOT'] . '/common/common.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/smarty.php';
	
	include $_SERVER['DOCUMENT_ROOT'] . '/include/captcha.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/module.php';
	
	session_start();
	
	function pages( $page_cnt, $page_cur, $tpl_path = 'pages.tpl' )
	{
		$pages = array(); $link_cnt = 6;
		$first_page = max( 0, min( $page_cnt - $link_cnt , $page_cur - $link_cnt / 2 ) );
		$last_page = min( max( $link_cnt, $page_cur + $link_cnt / 2 ), $page_cnt );
		
		if ( $first_page > 0 )
			$pages[] = array( 'num' => '1', 'url' => get_request_url( array( 'page' => '' ) ) );
		if ( $first_page > 1 )
			$pages[] = array( 'num' => '...', 'url' => get_request_url( array( 'page' => $first_page - 1 ) ) );
		
		for ( $p = $first_page; $p < $last_page; $p++ )
			$pages[] = array( 'num' => $p + 1, 'url' => $p != $page_cur ? get_request_url( array( 'page' => $p ? $p : '' ) ) : '' );
		
		if ( $last_page < $page_cnt - 1 )
			$pages[] = array( 'num' => '...', 'url' => get_request_url( array( 'page' => $last_page ) ) );
		if ( $last_page < $page_cnt )
			$pages[] = array( 'num' => $page_cnt, 'url' => get_request_url( array( 'page' => $page_cnt - 1 ) ) );
		
		$page_tpl = new SmartyClient();
		$page_tpl -> assign( 'page_first',(($page_cur==$first_page)?1:0) );
		$page_tpl -> assign( 'page_last',(($page_cur==$last_page-1)?1:0) );		
		$page_tpl -> assign( 'page',$page_cur);		
		
		$page_tpl -> assign( 'pages', $pages );
		
		return $page_tpl -> fetch( $tpl_path );
	}
	
	function path( $path, $tpl_path = 'path.tpl' )
	{
		$path_tpl = new SmartyClient();
		$path_tpl -> assign( 'path', $path );
		
		return $path_tpl -> fetch( $tpl_path );
	}
	
	// Извлекает настройки из базы
	function get_preference( $preference_name, $default_value = '' )
	{
		$preference_item = db::select( '
                select preference.* from preference where preference.preference_name = :preference_name',
			array( 'preference_name' => $preference_name ) );
		
		if ( $preference_item )
			return $preference_item['preference_value'];
		else
			return $default_value;
	}
	
	// Шифрует текст перед отправкой по email
	function email_encode( $text )
	{
		return '=?UTF-8?B?' . base64_encode( $text ) . '?=';
	}
	
	function send_mail( $to, $from, $subject, $message, $files = array() )
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/common/PEAR/Mail.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/common/PEAR/Mail/mime.php';
		
		$mail_mime = new Mail_Mime();
		
		$mail_mime -> setFrom( $from );
		$mail_mime -> setSubject( $subject );
		
		$mail_mime -> setHTMLBody( $message );
		$mail_mime -> setTXTBody( strip_tags( $message ) );
		
		foreach ( $files as $file_name => $file_path )
			$mail_mime -> addAttachment( $file_path, 'application/octet-stream',
				$file_name, true, 'base64', 'attachment', 'UTF-8' );
		
		$build_params = array(
			'head_encoding' => 'base64', 'text_encoding' => 'base64', 'html_encoding' => 'base64',
			'html_charset'  => 'UTF-8', 'text_charset'  => 'UTF-8', 'head_charset'  => 'UTF-8' );
		
		$body = $mail_mime -> get( $build_params );
		$headers = $mail_mime -> headers();
		
		$mail = Mail::factory( 'mail' );
		$result = $mail -> send( $to, $headers, $body );
		
		return !is_a( $result, 'PEAR_Error' );
	}
	
	// Посылает заголовки, запрещающие кэширование
	function headers_no_cache()
	{
		header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
		header( 'Cache-Control: no-cache, must-revalidate' );
		header( 'Pragma: no-cache' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
	}
	
	// Преобразует разметку текста из BBCode в HTML
	function format_text( $text )
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/common/PEAR/HTML/BBCodeParser.php';
		
		return preg_replace( '/(\r?\n)/', '<br/>',
			HTML_BBCodeParser::staticQparse( htmlspecialchars( trim( $text ) ) ) );
	}
	
	// Пересчет цены с учетом скидки
	function recount_price( $price )
	{
		static $discount_limit = null;
		static $discount_rate = null;
		
		if ( is_null( $discount_limit ) )
			$discount_limit = intval( get_preference( 'discount_limit' ) );
		if ( is_null( $discount_rate ) )
			$discount_rate = intval( get_preference( 'discount_rate' ) );
		
		if ( $price >= $discount_limit )
			$price = $price * ( 1 - $discount_rate / 100 );
		
		return round( $price );
	}
?>
