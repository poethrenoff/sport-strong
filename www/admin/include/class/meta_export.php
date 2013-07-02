<?
	class meta_export extends tool
	{
		protected function action_tool()
		{
			$module_list = metadata::$tables['meta']['fields']['meta_module']['values'];
			
			$tpl = new SmartyAdmin();
				
			$tpl -> assign( 'title', $this -> title );
			
			$tpl -> assign( 'module_list', $module_list );
			
			$this -> content = $tpl -> fetch( 'class/meta_export/export.tpl' );
		}
		
		protected function action_export()
		{
			$filter_conds = array(); $filter_binds = array();
			
			$meta_module = init_string( 'meta_module' );
			$meta_title = init_string( 'meta_title' );
			
			if ( $meta_module != '' )
			{
				$filter_conds[] = 'meta_module = :meta_module'; $filter_binds['meta_module'] = $meta_module;
			}
			if ( $meta_title != '' )
			{
				$filter_conds[] = 'meta_title like :meta_title'; $filter_binds['meta_title'] = '%' . $meta_title . '%';
			}
			
			$filter_clause = count( $filter_conds ) ? 'where ' . join( ' and ', $filter_conds ) : '';
			$meta_query = 'select * from meta ' . $filter_clause;
			$meta_list = db::select_all( $meta_query, $filter_binds );
			
			$meta_stream = array();
			foreach ( $meta_list as $meta_item )
			{
				$meta_string = array();
				foreach ( $meta_item as $meta_field )
					$meta_string[] = '"' . str_replace( '"', '""', iconv( 'UTF-8', 'windows-1251', $meta_field ) ) . '"';
				
				$meta_stream[] = join( ';', $meta_string );
			}
			
			if ( !count( $meta_stream ) )
			{
				header( 'Location: ' . get_url( array( 'object' => 'meta_export' ), array(), '', '&' ) ); exit;
			}
			
			header( 'Content-type: application/octed-stream' );
			header( 'Content-Disposition: attachment; filename="meta_export.csv"' );
			
			print join( "\r\n", $meta_stream );
			
			exit;
		}
	}
?>
