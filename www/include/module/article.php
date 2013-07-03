<?
	include_once $_SERVER['DOCUMENT_ROOT'] . '/include/module/catalogue.php';
	
	class article extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array( 'mode' => 'article', 'items_per_page' => 10,
			'products_count' => 3, 'products_per_page' => 3 );
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			$article_id = init_string( 'article_id' );
			$article_name = init_string( 'article_name' );
			
			if ( $article_id || $article_name )
				$this -> get_item( $article_id, $article_name );
			else
				$this -> get_list();
		}
		
		// Вывод списка статей
		protected function get_list()
		{
			$items_per_page = max( intval( $this -> params['items_per_page'] ), 1 );
			
			$article_query = 'select count(*) as _article_count from article where article_active = 1';
			$article_count = db::select( $article_query );
			
			if ( $article_count = $article_count['_article_count'] )
			{
				$first_page = 0; $last_page = max( floor( ( $article_count - 1 ) / $items_per_page ), 0 );
				$page = min( max( intval( init_string( 'page' ) ), $first_page ), $last_page );
				$limit = $items_per_page; $offset = $items_per_page * $page;
				
				$article_query = 'select * from article where article_active = 1
					order by article_id desc limit ' . $limit . ' offset ' . $offset;
				$article_list = db::select_all( $article_query );
				
				foreach ( $article_list as $article_index => $article_item )
					$article_list[$article_index]['article_url'] =
						get_url( array( 'article_id' => $article_item['article_id'] ), array(), '/article.php' );
//					$article_list[$article_index]['article_url'] = '/article/' . $article_item['article_name'];
				
				$this -> tpl -> assign( 'article_list', $article_list );
				
				if ( $article_count > $items_per_page )
					$this -> tpl -> assign( 'pages', pages( $last_page + 1, $page ) );
			}
			
			$article_path = array();
			$article_path[] = array( 'title' => 'Главная', 'url' => get_url( array(), array(), '/' ) );
			$article_path[] = array( 'title' => 'Статьи' );
			
			$this -> tpl -> assign( 'path', path( $article_path ) );
			
			$this -> content = $this -> tpl -> fetch( 'module/article/article_list.tpl' );
			
			$this -> meta = $this -> read_meta( 'article' );
		}		
		
		// Вывод статьи
		protected function get_item( $article_id, $article_name )
		{
			if ( $article_id )
			{
				$article_query = 'select * from article where article_id = :article_id and article_active = 1';
				$article_item = db::select( $article_query, array( 'article_id' => $article_id ) );
			}
			else if ( $article_name )
			{
				$article_query = 'select * from article where article_name = :article_name and article_active = 1';
				$article_item = db::select( $article_query, array( 'article_name' => $article_name ) );
			}
			else
			{
				return false;
			}
			
			if ( !$article_item ) return false;
			
			$this -> tpl -> assign( $article_item );
			
			$article_path = array();
			$article_path[] = array( 'title' => 'Главная страница', 'url' => get_url( array(), array(), '/index.php' ) );
			$article_path[] = array( 'title' => 'Статьи', 'url' => get_url( array(), array(), '/article.php' ) );
			$article_path[] = array( 'title' => $article_item['article_title'] );
			
			if ( $article_item['article_catalogue'] )
			{
				$products_count = max( intval( $this -> params['products_count'] ), 1 );
				
				$product_ids_query = '
					select product_id from product
					where product_catalogue = :product_catalogue and
						product_active = 1';
				$product_ids_list = db::select_all( $product_ids_query, array( 'product_catalogue' => $article_item['article_catalogue'] ) );
				
				shuffle( $product_ids_list );
				$product_ids_list =
					array_slice( $product_ids_list, 0, $products_count );
				
				$product_ids_array = array();
				foreach ( $product_ids_list as $product_ids_row )
					$product_ids_array[] = $product_ids_row['product_id'];
				$product_ids_in = "'" . join( "', '", $product_ids_array ) . "'";
				
				$product_query = '
					select product.*, catalogue.*
					from product
						inner join catalogue on catalogue.catalogue_id = product.product_catalogue
					where product_id in ( ' . $product_ids_in . ' )';
				$product_list = db::select_all( $product_query );
				
				catalogue::assign_properties( $product_list );
				
				$products_per_page = max( intval( $this -> params['products_per_page'] ), 1 );
				
				$product_table = array();
				for( $i = 0; $i < ceil( count( $product_list ) / $products_per_page ); $i++ )
					for( $j = 0; $j < $products_per_page; $j++ )
						if ( isset( $product_list[$i * $products_per_page + $j] ) )
							$product_table[$i][$j] = $product_list[$i * $products_per_page + $j];
						else 
							$product_table[$i][$j] = array();
				
				$catalogue_query = '
					select catalogue_title from catalogue where catalogue_id = :catalogue_id and catalogue_active = 1';
				$catalogue_item = db::select( $catalogue_query, array( 'catalogue_id' => $article_item['article_catalogue'] ) );
			
				$this -> tpl -> assign( 'catalogue_title', mb_strtolower( $catalogue_item['catalogue_title'], 'UTF-8' ) );
				
				$this -> tpl -> assign( 'product_table', $product_table );
				$this -> tpl -> assign( 'product_cell_width', round( 100 / $products_per_page ) );
			}
			
			$this -> tpl -> assign( 'path', path( $article_path ) );
			
			$this -> content = $this -> tpl -> fetch( 'module/article/article_item.tpl' );
			
			$this -> meta = $this -> read_meta( 'article', $article_id );
		}
	}
?>
