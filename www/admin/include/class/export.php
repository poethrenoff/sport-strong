<?
	class export extends tool
	{
		protected function action_tool()
		{
			$catalogue_query = '
				select catalogue_id as value, catalogue_parent as parent, catalogue_title as title
				from catalogue order by catalogue_title asc';
			$catalogue_list = tree::get_tree( db::select_all( $catalogue_query ), 'value', 'parent' );
			
			$brand_query = '
				select brand_id as value, brand_title as title
				from brand order by brand_title asc';
			$brand_list = db::select_all( $brand_query );
			
			$tpl = new SmartyAdmin();
				
			$tpl -> assign( 'title', $this -> title );
			
			$tpl -> assign( 'catalogue_list', $catalogue_list );
			$tpl -> assign( 'brand_list', $brand_list );
			
			$this -> content = $tpl -> fetch( 'class/export/export.tpl' );
		}
		
		protected function action_export()
		{
			$product_table = table::factory( 'product' );
			
			$filter_conds = array(); $filter_binds = array();
			
			$product_catalogue = init_string( 'product_catalogue' );
			$product_brand = init_string( 'product_brand' );
			$product_title = init_string( 'product_title' );
			$product_active = init_string( 'product_active' );
			
			if ( $product_catalogue != '' )
			{
				$filter_conds[] = 'product.product_catalogue = :product_catalogue'; $filter_binds['product_catalogue'] = $product_catalogue;
			}
			if ( $product_brand != '' )
			{
				$filter_conds[] = 'product.product_brand = :product_brand'; $filter_binds['product_brand'] = $product_brand;
			}
			if ( $product_title != '' )
			{
				$filter_conds[] = 'product.product_title like :product_title'; $filter_binds['product_title'] = '%' . $product_title . '%';
			}
			if ( $product_active != '' )
			{
				$filter_conds[] = 'product.product_active = :product_active'; $filter_binds['product_active'] = $product_active;
			}
			
			$filter_clause = count( $filter_conds ) ? 'where ' . join( ' and ', $filter_conds ) : '';
			$product_query = 'select product_id, product_title, product_price, product_price_old, product_available
				from product ' . $filter_clause . ' order by product_title asc';
			$product_list = db::select_all( $product_query, $filter_binds );
			
			$product_stream = array();
			foreach ( $product_list as $product_item )
			{
				$product_item['product_price'] = floatval( $product_item['product_price'] );
				$product_item['product_price_old'] = floatval( $product_item['product_price_old'] );
				
				$product_string = array();
				foreach ( $product_item as $product_field )
					$product_string[] = '"' . str_replace( '"', '""', iconv( 'UTF-8', 'windows-1251', $product_field ) ) . '"';
				
				$product_stream[] = join( ';', $product_string );
			}
			
			if ( !count( $product_stream ) )
			{
				header( 'Location: ' . get_url( array( 'object' => 'export' ), array(), '', '&' ) ); exit;
			}
			
			header( 'Content-type: application/octed-stream' );
			header( 'Content-Disposition: attachment; filename="export.csv"' );
			
			print join( "\r\n", $product_stream );
			
			exit;
		}
	}
?>
