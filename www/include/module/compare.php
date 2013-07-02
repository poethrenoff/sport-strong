<?
	class compare extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array( 'mode' => 'status' );
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			if ( !isset( $_SESSION['compare'] ) || !is_array( $_SESSION['compare'] ) )
				$_SESSION['compare'] = array();
			
			if ( $this -> params['mode'] == 'result' )
				$this -> get_result();
			else if ( $this -> params['mode'] == 'info' )
				$this -> get_info();
			else
				$this -> get_status();
		}
		
		// Операции со сравнением
		protected function get_status()
		{
			if ( $in_compare = init_string( 'in_compare' ) )
			{
				$product_query = '
					select count(*) as _product_count from product
					where product_id = :product_id and product_active = 1';
				$product_count = db::select( $product_query, array( 'product_id' => $in_compare ) );
				
				if ( !$product_count['_product_count'] ) return false;
				
				$_SESSION['compare'][$in_compare] = 1;
				
				header( 'Location: ' . get_request_url( array(), array( 'in_compare' ), '', '&' ) );
				
				exit;
			}
			
			// Удаление товара из сравнения
			if ( $out_compare = init_string( 'out_compare' ) )
			{
				unset( $_SESSION['compare'][$out_compare] );
				
				$this -> redirect();
			}
			
			// Очистка результатов сравнения
			if ( init_string( 'action' ) == 'compare_clear' )
			{
				unset( $_SESSION['compare'] );
				
				$this -> redirect();
			}
		}
		
		// Просмотр результатов сравнения
		protected function get_result()
		{
			$products = array();
			
			foreach ( $_SESSION['compare'] as $product_id => $product_count )
			{
				$product_query = '
					select product.product_id, product.product_type,
						product.product_title, product.product_price, brand.brand_title
					from product
						inner join brand on brand.brand_id = product.product_brand
					where product_id = :product_id and product_active = 1';
				$product_item = db::select( $product_query, array( 'product_id' => $product_id ) );
				
				if ( !$product_item ) continue;
				
				$property_query = 'select property, value from product_property where product = :product_id';
				$properties = db::select_all( $property_query, array( 'product_id' => $product_id ) );
				
				if ( !count( $properties ) ) continue;
				
				foreach ( $properties as $property_index => $property_item )
					$product_item['properties'][$property_item['property']] = $property_item['value'];
				$product_item['properties']['brand'] = $product_item['brand_title'];
				$product_item['properties']['price'] = $product_item['product_price'];
				
				$product_item['product_url'] =
					get_url( array( 'product_id' => $product_item['product_id'] ), array(), '/product.php' );
				$product_item['delete_url'] =
					get_url( array( 'out_compare' => $product_id ) );
				
	 			if ( !isset( $_SESSION['cart'][$product_item['product_id']] ) )
	 				$product_item['cart_url'] =
	 					get_request_url( array( 'in_cart' => $product_item['product_id'] ), array( 'in_compare' ) );
				
				if ( !isset( $products[$product_item['product_type']] ) ||
						count( $products[$product_item['product_type']] ) < 4 )
					$products[$product_item['product_type']][$product_item['product_id']] = $product_item;
			}
			
			$properties = array();
			
			foreach ( $products as $product_type_id => $product_list )
			{
				$product_type_query = 'select * from product_type where product_type_id = :product_type_id';
				$product_type_item = db::select( $product_type_query, array( 'product_type_id' => $product_type_id ) );
				
				if ( !$product_type_item ) continue;
				
				$property_list = db::select_all( '
						select * from property
						where property_type = :property_type
						order by property_order',
					array( 'property_type' => $product_type_id ) );
					
				if ( !count( $property_list ) ) continue;
				
				array_unshift( $property_list,
					array( 'property_id' => 'price', 'property_title' => 'Цена', 'property_kind' => 'number', 'property_unit' => 'р.' ),
					array( 'property_id' => 'brand', 'property_title' => 'Производитель', 'property_kind' => 'string' ) );
				
				$properties[$product_type_id]['title'] = $product_type_item['product_type_title'];
				
				foreach( $property_list as $property_index => $property_item )
				{
					if ( $property_item['property_kind'] == 'select' )
					{
						$values = db::select_all( 'select * from value	where value_property = :value_property',
							array( 'value_property' => $property_item['property_id'] ) );
						
						foreach ( $values as $value_index => $value_item )
							$property_item['values'][$value_item['value_id']] = $value_item['value_title'];
					}
					
					$properties[$product_type_id]['properties'][$property_item['property_id']] = $property_item;
				}
			}
			
			// Помечаем свойства, одинаковые для всех товаров в группе
			foreach ( $properties as $product_type_id => $property_row )
			{
				foreach ( $property_row['properties'] as $property_id => $property_item )
				{
					$property_equal = array();
					
					if ( count( $products[$product_type_id] ) > 1 )
						foreach ( $products[$product_type_id] as $product_id => $product_item )
							$property_equal[] =	isset( $product_item['properties'][$property_id] ) ?
								$product_item['properties'][$property_id] : '';
					
					$properties[$product_type_id]['properties'][$property_item['property_id']]['property_equal'] =
						count( array_unique( $property_equal ) ) == 1;
				}
			}
			
			$this -> tpl -> assign( 'products', $products );
			$this -> tpl -> assign( 'properties', $properties );
			
			$this -> tpl -> assign( 'clear_url', get_url( array( 'action' => 'compare_clear' ) ) );
			
			$this -> content = $this -> tpl -> fetch( 'module/compare/compare_result.tpl' );
			$this -> path = array_merge( $this -> path, array( array( 'title' => 'Сравнение' ) ) );
			
			$this -> meta = $this -> read_meta( 'compare' );
		}
		
		// Информация о количестве товаров в сравнении
		protected function get_info()
		{
			$total_product_count = 0;
			foreach ( $_SESSION['compare'] as $product_id => $product_count )
				$total_product_count++;
			
			$this -> tpl -> assign( 'compare_count', $total_product_count );
			
			$this -> content = $this -> tpl -> fetch( 'module/compare/compare_info.tpl' );
		}
		
		// Перенаправление на результаты сравнения
		protected function redirect()
		{
			header( 'Location: /compare.php' ); exit;
		}
	}
?>
