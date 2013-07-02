<?
	class price extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array();
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			$catalogue_id = intval( init_string( 'catalogue_id' ) );
		
			$catalogue_query = '
				select catalogue_id, catalogue_parent, catalogue_title
				from catalogue where catalogue_active = 1 order by catalogue_order';
			$catalogue_list = db::select_all( $catalogue_query );
			
			// Строим дерево каталогов
			$price_list = tree::get_tree( $catalogue_list, 'catalogue_id', 'catalogue_parent' );
			
			foreach( $price_list as $price_index => $price_item )
				if ( $price_item['catalogue_id'] == $catalogue_id )
					$price_list[$price_index]['_selected'] = true;
			
			// Выводим его в шаблон, конкретно в форму фильтрацмм
			$this -> tpl -> assign( 'catalogue_list', $price_list );
			
			// Выбираем каталоги, ниже выбранного в фильтре
			$select_catalogue_list = tree::get_tree( $catalogue_list, 'catalogue_id', 'catalogue_parent', $catalogue_id );
			
			foreach ( $select_catalogue_list as $select_catalogue_index => $select_catalogue_item )
				$select_catalogue_list[$select_catalogue_index] = $select_catalogue_item['catalogue_id'];
			
			// Добавляем в список выбранных каталогов родительских каталог
			$select_catalogue_list[] = $catalogue_id;
			
			// Выкидываем из дерева каталогов узлы, не удовлетворяющие условию фильтрации
			foreach( $price_list as $price_index => $price_item )
				if ( !in_array( $price_item['catalogue_id'], $select_catalogue_list ) )
					unset( $price_list[$price_index] );
			
			// Определяем параметры сортировки
			$sort_field = init_string( 'sort_field' ); $sort_order = init_string( 'sort_order' );
			if ( !in_array( $sort_field = init_string( 'sort_field' ), array( 'product_title', 'product_price', 'brand_title' ) ) )
				$sort_field = 'product_order';
			if ( !in_array( $sort_order = init_string( 'sort_order' ), array( 'asc', 'desc' ) ) )
				$sort_order = 'asc';
				
			// Дополнянем каждый из выбранных каталог списком его товаров
			foreach( $price_list as $price_index => $price_item )
			{
				$product_query = '
					select product.product_id, product.product_title, product.product_price, brand.brand_title
                    from product inner join brand on brand.brand_id = product.product_brand
					where product_catalogue = :product_catalogue and product_active = 1
					order by ' . $sort_field . ' ' . $sort_order;
				
				$product_list = db::select_all( $product_query, array( 'product_catalogue' => $price_item['catalogue_id'] ) );
				
				foreach( $product_list as $product_index => $product_item )
					$product_list[$product_index]['product_url'] =
						get_url( array( 'product_id' => $product_item['product_id'] ), array(), '/product.php' );
				
				$price_list[$price_index]['products'] = $product_list;
				
				$price_list[$price_index]['catalogue_url'] =
					get_url( array( 'catalogue_id' => $price_item['catalogue_id'] ), array(), '/catalogue.php' );
			}
			
			$hidden_fields = prepare_query( $_GET, array( 'catalogue_id' ) );
			
			// Собираем данные для сортировки
			$sort_list = array();
            $field_list = array( 'product_title' => 'по названию', 'product_price' => 'по цене', 'brand_title' => 'по производителю' );
			foreach( $field_list as $field_name => $field_title )
			{
				$field_sort_order = $field_name == $sort_field && $sort_order == 'asc' ? 'desc' : 'asc';
				$field_sort_url = get_request_url( array( 'sort_field' => $field_name, 'sort_order' => $field_sort_order ) );
				$sort_list[$field_name] = array( 'sort_title' => $field_title, 'sort_url' => $field_sort_url );
				if ( $field_name == $sort_field )
					$sort_list[$field_name]['sort_sign'] = $field_sort_order == 'asc' ? 'desc' : 'asc';
			}
			
			$this -> tpl -> assign( 'hidden', $hidden_fields );
			$this -> tpl -> assign( 'sort_list', $sort_list );
			
			$this -> tpl -> assign( 'price_list', $price_list );
			
			$this -> tpl -> assign( 'print_url', get_request_url( array( 'print_version' => 1 ) ) );
			
			if ( init_string( 'print_version' ) )
				$this -> content = $this -> tpl -> fetch( 'module/price/print_version.tpl' );
			else
				$this -> content = $this -> tpl -> fetch( 'module/price/price_list.tpl' );
			$this -> path = array_merge( $this -> path, array( array( 'title' => 'Прайс-лист' ) ) );
			
			$this -> meta = $this -> read_meta( 'price' );
		}
	}
?>
