<?
	include_once $_SERVER['DOCUMENT_ROOT'] . '/include/module/catalogue.php';
	
	class product extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array(
			'cols_per_page_picture' => 3 );
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			if ($product_url = init_string('product_url')) {
				if ($product_item = db::select('
					select product_id from product where product_url = :product_url',
						array('product_url' => $product_url))) {
					$_REQUEST['product_id'] = $product_item['product_id'];
				}
			}
			
			$product_id = $this -> get_param( 'product_id' );
			
			$product_query = '
				select product.*, brand.*, catalogue.*
				from product
					inner join brand on brand.brand_id = product.product_brand
					inner join catalogue on catalogue.catalogue_id = product.product_catalogue
				where product_id = :product_id and product_active = 1';
			$product_list = db::select_all( $product_query, array( 'product_id' => $product_id ) );
			
			if ( count( $product_list ) == 0 )
			{
				$this -> tpl -> assign( 'manager_email', get_preference( 'manager_email' ) );
				$this -> tpl -> assign( 'manager_phone', get_preference( 'manager_phone' ) );
				
				$this -> content = $this -> tpl -> fetch( 'module/product/product_item.tpl' );
				
				$this -> meta = $this -> read_meta( 'product' );
				
				return false;
			}
			
			catalogue::assign_properties( $product_list );
			
			$product_item = $product_list[0];
			
			$product_path = array();
			$product_path[] = array( 'title' => $product_item['product_title'] );
			
			$catalogue_item['catalogue_parent'] = $product_item['product_catalogue'];
			while ( $catalogue_item = db::select( 'select * from catalogue where catalogue_id = :catalogue_id',
					array( 'catalogue_id' => $catalogue_item['catalogue_parent'] ) ) )
				$product_path[] = array( 'title' => $catalogue_item['catalogue_short_title'],
					'url' => '/' . $catalogue_item['catalogue_url'] . '/' );
 			
			$picture_query = 'select * from picture where picture_product = :product_id and picture_active = 1';
			$picture_list = db::select_all( $picture_query, array( 'product_id' => $product_id ) );
			
			$cols_per_page_picture = max( intval( $this -> params['cols_per_page_picture'] ), 1 );
			
			$picture_table = array();
			for( $i = 0; $i < ceil( count( $picture_list ) / $cols_per_page_picture ); $i++ )
				for( $j = 0; $j < $cols_per_page_picture; $j++ )
					if ( isset( $picture_list[$i * $cols_per_page_picture + $j] ) )
						$picture_table[$i][$j] = $picture_list[$i * $cols_per_page_picture + $j];
					else 
						$picture_table[$i][$j] = array();
			
			$file_query = 'select * from file where file_product = :product_id and file_active = 1';
			$file_list = db::select_all( $file_query, array( 'product_id' => $product_id ) );
			
			$article_query = '
				select article.* from article, product_article
				where product_article.article_id = article.article_id and
					product_article.product_id = :product_id';
			$article_list = db::select_all( $article_query, array( 'product_id' => $product_id ) );
			
			foreach ( $article_list as $article_index => $article_item )
				$article_list[$article_index]['article_url'] =
					get_url( array( 'article_id' => $article_item['article_id'] ), array(), '/article.php' );
			
			// Похожие товары
			$like_query = '
				select product.*, catalogue.*
				from product, product_like, catalogue
				where product_like.like_product_id = product.product_id and
					product_like.product_id = :product_id and
					catalogue.catalogue_id = product.product_catalogue and
					product.product_active = 1
				order by product_order';
			$like_list = db::select_all( $like_query, array( 'product_id' => $product_id ) );
			
			catalogue::assign_properties( $like_list );
			
			$this -> tpl -> assign( $product_item );
			
			$this -> tpl -> assign( 'file_list', $file_list );
			$this -> tpl -> assign( 'article_list', $article_list );
			
			$this -> tpl -> assign( 'picture_table', $picture_table );
			$this -> tpl -> assign( 'picture_cell_width', round( 100 / $cols_per_page_picture ) );
			
			$this -> tpl -> assign( 'like_list', $like_list );
			
			$this -> path = array_merge( $this -> path, array_reverse( $product_path ) );
			
			$this -> content = $this -> tpl -> fetch( 'module/product/product_item.tpl' );
			
			$this -> meta = $this -> read_meta( 'product', $product_id );
		}
	}
?>
