<?
	class catalogue extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array(
			'mode' => 'catalogue',
				'rows_per_page_product' => 10, 'rows_per_page_catalogue' => 10,
				'cols_per_page_product' => 3, 'cols_per_page_catalogue' => 3  );
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			if ( $this -> params['mode'] == 'menu' )
				$this -> get_menu();
			else if ( $this -> params['mode'] == 'brand' )
				$this -> get_brand();
			else if ( $this -> params['mode'] == 'marker_list' )
			{
				$this -> get_marker_list();
				
			}
			else
				$this -> get_catalogue();
		}
		
		// Вывод списка подкаталогов или товаров
		protected function get_catalogue()
		{
            if ($catalogue_id = init_string('catalogue_id')) {
                if ($catalogue_item = db::select('
                    select catalogue_url from catalogue where catalogue_id = :catalogue_id',
                        array('catalogue_id' => $catalogue_id))) {
                        header('HTTP/1.1 301 Moved Permanently');
                        header('Location: ' . '/' . $catalogue_item['catalogue_url'] . '/');
                        exit;
                }
            }
            
			if ($catalogue_url = init_string('catalogue_url')) {
				if ($catalogue_item = db::select('
					select catalogue_id from catalogue where catalogue_url = :catalogue_url',
						array('catalogue_url' => $catalogue_url))) {
					$_REQUEST['catalogue_id'] = $catalogue_item['catalogue_id'];
				} else {
					require_once('error404.php');
				}
			}
			
			$catalogue_id = intval( $this -> get_param( 'catalogue_id' ) );
			
			if ($catalogue_id)
			{
				$catalogue_query = 'select count(*) as _catalogue_count from catalogue
					where catalogue_parent = :catalogue_id and catalogue_active = 1';
				$catalogue_count = db::select( $catalogue_query, array( 'catalogue_id' => $catalogue_id ) );
			}
			else
			{
				$catalogue_query = 'select count(*) as _catalogue_count from catalogue
				where catalogue_active = 1';
				$catalogue_count = db::select( $catalogue_query, array( 'catalogue_id' => $catalogue_id ) );
			}
			$product_brand=0;
			if (( $catalogue_count['_catalogue_count'] )&&($catalogue_id!=0)) // Список подкаталогов
			{
				$rows_per_page = max( intval( $this -> params['rows_per_page_catalogue'] ), 1 );
				$cols_per_page = max( intval( $this -> params['cols_per_page_catalogue'] ), 1 );
				$records_per_page = $rows_per_page * $cols_per_page;
				
				$catalogue_query = '
					select * from catalogue where catalogue_id = :catalogue_id and catalogue_active = 1';
				$catalogue_item = db::select( $catalogue_query, array( 'catalogue_id' => $catalogue_id ) );
				
				if ( init_string( 'page' ) )
					$catalogue_item['catalogue_description'] = '';
				
				$this -> tpl -> assign( $catalogue_item );
				
				$catalogue_path = array();
				$catalogue_path[] = array( 'title' => $catalogue_item['catalogue_short_title'] );
				
				while ( $catalogue_item = db::select( 'select * from catalogue where catalogue_id = :catalogue_id',
						array( 'catalogue_id' => $catalogue_item['catalogue_parent'] ) ) )
					$catalogue_path[] = array( 'title' => $catalogue_item['catalogue_short_title'],
						'url' => '/' . $catalogue_item['catalogue_url'] . '/' );
				
				$first_page = 0; $last_page = max( floor( ( $catalogue_count['_catalogue_count'] - 1 ) / $records_per_page ), 0 );
				$page = min( max( intval( init_string( 'page' ) ), $first_page ), $last_page );
				$limit = $records_per_page; $offset = $records_per_page * $page;
				
				$catalogue_query = '
					select * from catalogue
					where catalogue_parent = :catalogue_id and catalogue_active = 1
					order by catalogue_order
					limit ' . $limit . ' offset ' . $offset;
				$catalogue_list = db::select_all( $catalogue_query, array( 'catalogue_id' => $catalogue_id ) );
				
				foreach( $catalogue_list as $catalogue_index => $catalogue_item )
				{
					$catalogue_list[$catalogue_index]['catalogue_url'] =
						'/' . $catalogue_item['catalogue_url'] . '/';
					if ( !$catalogue_item['catalogue_picture'] )
		 				$catalogue_list[$catalogue_index]['catalogue_picture'] = '/image/catalogue/default';
				}
				
				$catalog_table = array();
				for( $i = 0; $i < ceil( count( $catalogue_list ) / $cols_per_page ); $i++ )
					for( $j = 0; $j < $cols_per_page; $j++ )
						if ( isset( $catalogue_list[$i * $cols_per_page + $j] ) )
							$catalogue_table[$i][$j] = $catalogue_list[$i * $cols_per_page + $j];
						else 
							$catalogue_table[$i][$j] = array();
									
				$this -> tpl -> assign( 'catalogue_table', $catalogue_table );
				$this -> tpl -> assign( 'table_cell_width', round( 100 / $cols_per_page ) );

				if ( $catalogue_count['_catalogue_count'] > $records_per_page )
					$this -> tpl -> assign( 'pages', pages( $last_page + 1, $page ) );
				
				$this -> path = array_merge( $this -> path, array_reverse( $catalogue_path ) );
				
				$this -> content = $this -> tpl -> fetch( 'module/catalogue/catalogue_list.tpl' );
			}
			else // Список товаров
			{
				
				if ($catalogue_id!=0)
				{
					$catalogue_query = '
						select * from catalogue where catalogue_id = :catalogue_id and catalogue_active = 1';
					
					$catalogue_item = db::select( $catalogue_query, array( 'catalogue_id' => $catalogue_id ) );
                    
                    $catalogue_query = '
						select * from catalogue where catalogue_id = :catalogue_id and catalogue_active = 1';
					
					$catalogue_parent = db::select( $catalogue_query, array( 'catalogue_id' => $catalogue_item['catalogue_parent'] ) );
					//print_r($catalogue_parent);
				}
				else
				{
					$catalogue_item['catalogue_id']=0;
					//$catalogue_item['catalogue_description']='test';
					$catalogue_item['catalogue_short_title']='Бренды';
					$catalogue_item['catalogue_parent']='0';
                    $catalogue_item['catalogue_url']='';
				}
				if ( init_string( 'page' ) )
					$catalogue_item['catalogue_description'] = '';
				
				// Сортировка по названию и по цене
				if ( !in_array( $sort_field = init_string( 'sort_field' ), array( 'product_title', 'product_price' ) ) )
					$sort_field = 'product_price';
				if ( !in_array( $sort_order = init_string( 'sort_order' ), array( 'asc', 'desc' ) ) )
					$sort_order = 'asc';
				
				// Фильтр по производителю и цене
				$filter_conds = array(); $filter_binds = array();
				//print_r($_GET);
                if ($brand_url = init_string('brand_url')) {
                    if ($brand_item = db::select('
                        select brand_id from brand where brand_url = :brand_url',
                            array('brand_url' => $brand_url))) {
                        $_REQUEST['product_brand'] = $brand_item['brand_id'];
                    } else {
                        require_once('error404.php');
                    }
                }
				
				if ( $product_brand = init_string( 'product_brand' ) )
				{
					$filter_conds[] = 'product.product_brand = :product_brand'; $filter_binds['product_brand'] = $product_brand;
				}
				
				
				$brand_query = '
					select distinct brand.brand_id, brand.brand_url, brand.brand_title, brand.brand_country, brand.brand_description, brand.brand_picture, brand.brand_translit
					from product
						left join brand on brand.brand_id = product.product_brand
					where product.product_active = 1 and '.(($catalogue_id>0)?'product.product_catalogue = :catalogue_id':' product.product_brand='.(int)$product_brand).' 
					order by brand.brand_title';
				$brand_list = db::select_all( $brand_query, array( 'catalogue_id' => $catalogue_id ) );				
				$catalogue_item['catalogue_short_title_breadcrumb']=$catalogue_item['catalogue_short_title'];
                $catalogue_item['catalogue_short_title']=(isset($brand_list[0]['brand_title']))?$brand_list[0]['brand_title']:'';

				$catalogue_path = array();
				$catalogue_path[] = array( 'title' => $catalogue_item['catalogue_short_title'] );				
				$catalogue_item_temp1=$catalogue_item;
				//file_put_contents("1.txt",print_r($catalogue_item_temp1,true));
                /*while ( $catalogue_item_temp = db::select( 'select * from catalogue where catalogue_id = :catalogue_id',
						array( 'catalogue_id' => $catalogue_item_temp1['catalogue_parent'] ) ) )
				{
					$catalogue_path[] = array( 'title' => $catalogue_item_temp['catalogue_short_title'],
						'url' => '/' . $catalogue_item_temp['catalogue_url'] . '/' );
				}*/
				$catalogue_path[] = array('title'=>$catalogue_item['catalogue_short_title_breadcrumb'],'url' => '/' . $catalogue_item['catalogue_url'] . '/');

				if ( $product_price_from = init_string( 'product_price_from' ) )
				{
					$filter_conds[] = 'product.product_price >= :product_price_from'; $filter_binds['product_price_from'] = $product_price_from;
				}
				if ( $product_price_to = init_string( 'product_price_to' ) )
				{
					$filter_conds[] = 'product.product_price <= :product_price_to'; $filter_binds['product_price_to'] = $product_price_to;
				}
				//Если не запрос бренда, условие выборки по определенному каталогу
				if ($catalogue_id!=0)
				{
					$filter_conds[] = 'product.product_catalogue = :product_catalogue'; $filter_binds['product_catalogue'] = $catalogue_id;
				}
				$filter_conds[] = 'product.product_active = :product_active'; $filter_binds['product_active'] = 1;
				
				$product_query = 'select count(*) as _product_count from product where ' . join( ' and ', $filter_conds );
				$product_count = db::select( $product_query, $filter_binds );
				
				$cols_per_page = max( intval( $this -> params['cols_per_page_product'] ), 1 );
				$rows_per_page = max( intval( $this -> params['rows_per_page_product'] ), 1 );
				$records_per_page = $rows_per_page * $cols_per_page;
				
				if ( in_array( $count = init_string( 'count' ), array( 15, 30, 'all' ) ) )
				{
					if ( $count == 'all' )
						$records_per_page = $product_count['_product_count'];
					else
						$records_per_page = $count;
				}
				
				$first_page = 0; $last_page = max( floor( ( $product_count['_product_count'] - 1 ) / $records_per_page ), 0 );
				$page = min( max( intval( init_string( 'page' ) ), $first_page ), $last_page );
				$limit = $records_per_page; $offset = $records_per_page * $page;
				
				$product_query = '
					select product.*, catalogue.*, brand.brand_id, brand.brand_title, brand.brand_country
					from product
						left join brand on brand.brand_id = product.product_brand
						left join catalogue on catalogue.catalogue_id = product.product_catalogue
					where ' . join( ' and ', $filter_conds ) . '
					order by ' . $sort_field . ' ' . $sort_order . '
					limit ' . $limit . ' offset ' . $offset;
				$product_list = db::select_all( $product_query, $filter_binds );
				
				self::assign_properties( $product_list, true );
				
				$product_table = array();
				for( $i = 0; $i < ceil( count( $product_list ) / $cols_per_page ); $i++ )
					for( $j = 0; $j < $cols_per_page; $j++ )
						if ( isset( $product_list[$i * $cols_per_page + $j] ) )
							$product_table[$i][$j] = $product_list[$i * $cols_per_page + $j];
						else 
							$product_table[$i][$j] = array();
				
				$select=false;
				$selected_brand=''; $selected_brand_country='';  $selected_brand_picture='';
                $all_path=$catalogue_item['catalogue_url'];
                foreach( $brand_list as $brand_index => $brand_item )
				{
                    $brand_list[$brand_index]['brand_url'] = '/' . $catalogue_item['catalogue_url'] . '/brand/' . $brand_item['brand_url'] . '/';
					if ( $brand_item['brand_id'] == $product_brand )
					{
						$brand_list[$brand_index]['_selected'] = true;
						$catalogue_path[0]['title']=$brand_list[$brand_index]['brand_title'];
						$selected_brand=$brand_list[$brand_index]['brand_title'];
                        $selected_brand_country=$brand_list[$brand_index]['brand_country'];
                        $selected_brand_picture=$brand_list[$brand_index]['brand_picture'];
                        $selected_brand_translit=$brand_list[$brand_index]['brand_translit'];
                        if($catalogue_id==0)
                        {
                        $this -> tpl -> assign( 'catalogue_description_top', $brand_list[$brand_index]['brand_description'] );
                        $this -> meta = $this -> read_meta( 'brand', $product_brand ? $product_brand : '' );
                        }
                        $select=true;
					}
				}
				if (($product_brand==0)&&($select==false))
				{
					$catalogue_path[0]['title']='Все марки';
				}
				
				$hidden_fields = prepare_query( $_GET, array_merge( array_keys( $filter_binds ), array( 'page', 'count' ) ) );
				
				$sort_list = array(); $field_list = array( 'product_title' => 'по названию', 'product_price' => 'по цене' );
				foreach( $field_list as $field_name => $field_title )
				{
					$field_sort_order = $field_name == $sort_field && $sort_order == 'asc' ? 'desc' : 'asc';
					$field_sort_url = get_request_url( array( 'sort_field' => $field_name, 'sort_order' => $field_sort_order ), array( 'page' ) );
					$sort_list[$field_name] = array( 'sort_title' => $field_title, 'sort_url' => $field_sort_url );
					if ( $field_name == $sort_field )
						$sort_list[$field_name]['sort_sign'] = $field_sort_order == 'asc' ? 'desc' : 'asc';
				}
				
				$price_list_url = get_url( array( 'catalogue_id' => $catalogue_id ), array(), '/price.php' );
				
				$this -> tpl -> assign( 'price_list_url', $price_list_url );
				if ($catalogue_id>0)
				{
					array_unshift( $brand_list, array('brand_title' => 'Все марки', '_selected' => !$product_brand, 'brand_url'=>'/'.$all_path.'/' ) );
				}
				
				$this -> tpl -> assign( 'brand_list', $brand_list );
					$this -> tpl -> assign( 'brand_count', count( $brand_list ) );
					$this -> tpl -> assign( 'brand_col_count', ceil(count( $brand_list ) / 3) );
					
				$this -> tpl -> assign( $catalogue_item );
				
                $this -> tpl -> assign( 'selected_brand', $selected_brand );
                $this -> tpl -> assign( 'selected_brand_country', $selected_brand_country );
                $this -> tpl -> assign( 'selected_brand_picture', $selected_brand_picture );
				$this -> tpl -> assign( 'product_brand', $product_brand );
				$this -> tpl -> assign( 'product_price_from', $product_price_from );
				$this -> tpl -> assign( 'product_price_to', $product_price_to );
				//$this -> tpl -> assign( 'enable_desc', 1);
				if (count($product_table)<1)
				{
						$this -> tpl -> assign( 'no_item_catalog', 1 );
				}
				
				$this -> tpl -> assign( 'hidden', $hidden_fields );
				
				$this -> tpl -> assign( 'sort_list', $sort_list );
				
				$this -> tpl -> assign( 'product_table', $product_table );
				$this -> tpl -> assign( 'table_cell_width', round( 100 / $cols_per_page ) );
				
				if ( $product_count['_product_count'] > $records_per_page )
					$this -> tpl -> assign( 'pages', pages( $last_page + 1, $page ) );
				
				$this -> path = array_merge( $this -> path, array_reverse( $catalogue_path ) );
				$this -> content = $this -> tpl -> fetch( 'module/catalogue/product_list.tpl' );
			}
			
			//print_r($product_brand);
            if($catalogue_id!=0 && !$product_brand)
            {
                 $this -> meta = $this -> read_meta( 'catalogue', $catalogue_id ? $catalogue_id : '' );
            }
            if($catalogue_id!=0 && $product_brand)
            {
                 $this -> meta['title'] = $catalogue_item['catalogue_short_title_breadcrumb'].' '.$selected_brand.', купить '.mb_strtolower($catalogue_parent['catalogue_short_title']).' в интернет-магазине Sport-strong.ru';
                 $this -> meta['description'] = 'Интернет магазин тренажеров Sport-strong предлагает выбрать и купить '.mb_strtolower($catalogue_item['catalogue_short_title_breadcrumb']).' '.$selected_brand.'. Низкие цены. Доставка. 8 (495) 778-66-59 ';
                 $this -> meta['keywords'] = mb_strtolower($catalogue_item['catalogue_short_title_breadcrumb'].' '.$selected_brand.', купить '.$catalogue_item['catalogue_short_title_breadcrumb'].' '.$selected_brand_translit);
            }
		}
		
		// Вывод древовидного меню категорий
		protected function get_menu()
		{
			$catalogue_query = '
				select * from catalogue where catalogue_active = 1 order by catalogue_order';
			$catalogue_list = db::select_all( $catalogue_query );
			
			foreach( $catalogue_list as $catalogue_index => $catalogue_item )
				$catalogue_list[$catalogue_index]['catalogue_url'] =
					'/' . $catalogue_item['catalogue_url'] . '/';
			
			$catalogue_tree = tree::get_tree( $catalogue_list, 'catalogue_id', 'catalogue_parent' );
			
			$this -> tpl -> assign( 'catalogue_tree', $catalogue_tree );
			
			$this -> content = $this -> tpl -> fetch( 'module/catalogue/catalogue_menu.tpl' );
		}
		
		// Вывод списка брендов
		protected function get_brand()
		{
            //получение списка брендов
            $catalogue_id=0;
            $brand_query = '
                select distinct brand.brand_id, brand.brand_title,brand.brand_url
                from product
                    left join brand on brand.brand_id = product.product_brand
                where product.product_active = 1 
                order by brand.brand_title';
            $mas_1=$mas_2=$mas_3=$mas_4=array();
            $brand_list = db::select_all( $brand_query, array( 'catalogue_id' => $catalogue_id ) );						
            
            for($ii=0;$ii<count($brand_list);$ii++)
            {
                if (($ii+4)%4==0) $mas_1[]=$brand_list[$ii];
                if (($ii+4)%4==1) $mas_2[]=$brand_list[$ii];
                if (($ii+4)%4==2) $mas_3[]=$brand_list[$ii];
                if (($ii+4)%4==3) $mas_4[]=$brand_list[$ii];
                
            }
            
            $this -> tpl -> assign( 'brand_list_1',$mas_1 );
            $this -> tpl -> assign( 'brand_list_2',$mas_2 );
            $this -> tpl -> assign( 'brand_list_3',$mas_3 );
            $this -> tpl -> assign( 'brand_list_4',$mas_4 );
			
			$this -> content = $this -> tpl -> fetch( 'module/catalogue/catalogue_brand.tpl' );
		}
		
		// Вывод таблицу маркерованных товаров
		function get_marker_list()
		{
			$marker_count = max( intval( $this -> params['marker_count'] ), 1 );
			
			$marker_list = is_array( $this -> params['marker_list'] ) ? $this -> params['marker_list'] : array();
			$marker_list_in = "'" . join( "', '", $marker_list ) . "'";
			
			$product_query = '
				select product.*, catalogue.*, marker.*
				from product, catalogue, marker, product_marker
				where
					catalogue.catalogue_id = product.product_catalogue and
					product_marker.product_id = product.product_id and
					product_marker.marker_id = marker.marker_id and
					marker.marker_type in ( ' . $marker_list_in . ' ) and
					product.product_active = 1';
			$product_list = db::select_all( $product_query );
			
			if ( !count( $product_list ) ) return false;
			
			self::assign_properties( $product_list, true );
			
			$marker_list = array();
			foreach ( $product_list as $product_item )
				$marker_list[$product_item['marker_id']][$product_item['product_id']] = $product_item;
			
			foreach ( $marker_list as $product_table_index => $product_table_column )
			{
				shuffle( $product_table_column );
				$marker_list[$product_table_index] =
					array_slice( $product_table_column, 0, $marker_count );
			}
			
			$this -> tpl -> assign( 'marker_list', $marker_list );
			$this -> tpl -> assign( 'table_cell_width', round( 100 / $marker_count ) );
			ob_start();
			$this -> tpl -> display( 'module/catalogue/marker_list.tpl' );
			$content = ob_get_clean();
			return $content;
		}
		function display_list_marker()
		{
			echo $this->get_marker_list();
		}
		
		// Дополняет список товаров их свойствами
		public static function assign_properties( &$product_list, $only_active = false )
		{
			$product_value_cache = array();
			
			foreach( $product_list as $product_index => $product_item )
			{
				$product_list[$product_index]['product_url'] = $product_item['catalogue_use_url'] ?
					('/' . $product_item['catalogue_url'] . '/' . $product_item['product_url'] . '/') :
						get_url( array( 'product_id' => $product_item['product_id'] ), array(), '/product.php' );
				if ( !$product_item['product_picture_small'] )
					$product_list[$product_index]['product_picture_small'] = '/image/product/default';
				if ( !$product_item['product_picture_middle'] )
					$product_list[$product_index]['product_picture_middle'] = '/image/product/default';
				
				if ( !isset( $_SESSION['cart'][$product_item['product_id']] ) )
					$product_list[$product_index]['cart_url'] = '?in_cart=' . $product_item['product_id'];
				if ( !isset( $_SESSION['compare'][$product_item['product_id']] ) )
					$product_list[$product_index]['compare_url'] = '?in_compare=' . $product_item['product_id'];
				if ( !isset( $_SESSION['cart'][$product_item['product_id']] ) )
					$product_list[$product_index]['fast_url'] =
						get_request_url( array( 'product_id' => $product_item['product_id'] ), array( 'in_cart', 'in_compare' ), '/fast_order.php' );
				
				$product_list[$product_index]['product_price'] = recount_price( $product_item['product_price'] );
				
				$marker_query = '
					select marker.*
					from product, marker, product_marker
					where
						product_marker.product_id = product.product_id and
						product_marker.marker_id = marker.marker_id and
						product.product_id = :product_id';
				$product_list[$product_index]['marker_list'] = 
					db::select_all( $marker_query, array( 'product_id' => $product_item['product_id'] ) );
				
				$property_query = '
					select property.property_id, property.property_title, property.property_kind,
						product_property.value, property.property_unit
					from property
						inner join product on property.property_type = product.product_type
						inner join product_property on product_property.property = property.property_id and
							product_property.product = product.product_id
					where product.product_id = :product_id ' . ( $only_active ? 'and property.property_active = 1' : '' ) . '
					order by property.property_order';
				
				$product_list[$product_index]['property_list'] =
					db::select_all( $property_query, array( 'product_id' => $product_item['product_id'] ) );
				
				foreach( $product_list[$product_index]['property_list'] as $property_index => $property_value )
				{
					if ( $property_value['property_kind'] == 'select' )
					{
						if ( !isset( $product_value_cache[$property_value['property_id']] ) )
						{
							$values = db::select_all( 'select * from value where value_property = :value_property',
								array( 'value_property' => $property_value['property_id'] ) );
							
							foreach ( $values as $value_index => $value_item )
								$product_value_cache[$property_value['property_id']][$value_item['value_id']] = $value_item['value_title'];
						}
						
						$product_list[$product_index]['property_list'][$property_index]['values'] =
							$product_value_cache[$property_value['property_id']];
					}
				}
			}
		}
	}
?>
