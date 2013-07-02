<?
	include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/include.php';
	
	$system_map_list = db::select_all( 'select * from system_map where system_map_active = 1 order by system_map_order' );
	$system_map_tree = tree::get_tree( $system_map_list, 'system_map_id', 'system_map_parent' );
	
	$object_name = init_string( 'object', 'text' );
	
	foreach ( $system_map_tree as $system_map_id => $system_map_item )
		if ( $system_map_item['system_map_object'] == $object_name )
			$system_map_tree[$system_map_id]['_selected'] = true;
	
	$tpl = new SmartyAdmin();
	$tpl -> assign( 'system_map', $system_map_tree );
	
	try
	{
        if ( isset( metadata::$tables[$object_name] ) )
			$object = table::factory( $object_name );
		else
			$object = tool::factory( $object_name );
		
		$object -> init();
		
		$tpl -> assign( 'title', 'Admin&amp;K&deg; :: ' . SITE_TITLE . ' :: ' . $object -> get_title() );
		$tpl -> assign( 'content', $object -> get_content() );
	}
	catch ( Exception $e )
	{
		$tpl -> assign( 'error', nl2br( htmlspecialchars( $e ) ) );
	}
	
	$tpl -> display( 'index.tpl' );
?>
