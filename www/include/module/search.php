<?
	class search extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array( 'records_per_page' => 20 );
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			
			$records_per_page = max( intval( $this -> params['records_per_page'] ), 1 );
			
			$search_value = init_string( 'search_value' );
			
			if ( $search_value )
			{
				$search_words = preg_split( '/\s+/', $search_value );
				
				$filter_fields = $filter_binds = array();
				foreach( $search_words as $word_index => $word_value )
				{
					$word_fields = array();
					foreach( array( 'product_title', 'product_description' ) as $filter_field )
					{
						$word_fields[] = '' . $filter_field . ' like :' . $filter_field . '_' . $word_index;
						$filter_binds[$filter_field . '_' . $word_index] = '%' . $word_value . '%';
					}
					$filter_fields[] = '( ' . join( ' or ', $word_fields ) . ' )';
				}
				$filter_fields[] = 'product_active = 1';
				
				$search_query = 'select count(*) as _search_count from product where ' . join( ' and ', $filter_fields );
				$search_count = db::select( $search_query, $filter_binds ); $search_count = $search_count['_search_count'];
				
				$first_page = 0; $last_page = max( floor( ( $search_count - 1 ) / $records_per_page ), 0 );
				$page = min( max( intval( init_string( 'page' ) ), $first_page ), $last_page );
				$limit = $records_per_page; $offset = $records_per_page * $page;
				
				$search_query = 'select product_id, product_title
					from product where ' . join( ' and ', $filter_fields ) . '
					order by product_title limit ' . $limit . ' offset ' . $offset;
			
				$search_list = db::select_all( $search_query, $filter_binds );
				
				$search_index = 0;
				foreach( $search_list as $result_index => $result_item )
				{
					$search_list[$result_index]['search_index'] = ++$search_index + $offset;
					$search_list[$result_index]['product_url'] =
						get_url( array( 'product_id' => $result_item['product_id'] ), array(), '/product.php' );
				}
				
				$this -> tpl -> assign( 'search_list', $search_list );
				$this -> tpl -> assign( 'search_value', $search_value );
				$this -> tpl -> assign( 'search_count', $search_count );
				
				if ( count( $search_list ) == 0 )
				{
					$this -> tpl -> assign( 'manager_email', get_preference( 'manager_email' ) );
					$this -> tpl -> assign( 'manager_phone', get_preference( 'manager_phone' ) );
					$this -> tpl -> assign( 'admin_email', get_preference( 'admin_email' ) );
					
				}
				
				if ( $search_count > $records_per_page )
					$this -> tpl -> assign( 'pages', pages( $last_page + 1, $page ) );
			}
			
			$this -> content = $this -> tpl -> fetch( 'module/search/search.tpl' );
			$this -> path = array_merge( $this -> path, array( array( 'title' => 'Результаты поиска' ) ) );
			
			$this -> meta = $this -> read_meta( 'search' );
		}
	}
?>
