<?
	class cart extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array( 'mode' => 'status' );
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			if ( !isset( $_SESSION['cart'] ) || !is_array( $_SESSION['cart'] ) )
				$_SESSION['cart'] = array();
			
			if ( $this -> params['mode'] == 'form' )
				$this -> get_form();
			else if ( $this -> params['mode'] == 'info' )
				$this -> get_info();
			else
				$this -> get_status();
		}
		
		// Операции с корзиной
		protected function get_status()
		{
			$count_item=0;
			if (isset($_GET['count']))
				$count_item=(int)$_GET['count'];
			
			// Добавление товара в корзину
			if ( $in_cart = init_string( 'in_cart' ) )
			{
				$product_item = db::select( '
					select product_id, product_title, if(product_price_special, product_price_special, product_price) as product_price, product_picture_small
					from product where product_id = :product_id and product_active = 1',
						array( 'product_id' => $in_cart ) );
					
				if ( $product_item )
				{
					$product_item['product_price'] = recount_price( $product_item['product_price'] );
					
					$_SESSION['cart'][$in_cart] = $product_item + array( 'product_count' => 1,
						'product_cost' => $product_item['product_price'], 'product_pic' => $product_item['product_picture_small'] );
				}
				
				$this -> redirect();
			}
			// Добавление товара в корзину
			if ( $recheck_cart = init_string( 'recheck_cart' ))
			{
				if ($count_item>0)
				{
					$product_item = db::select( '
						select product_id, product_title, if(product_price_special, product_price_special, product_price) as product_price, product_picture_small
						from product where product_id = :product_id and product_active = 1',
							array( 'product_id' => $recheck_cart ) );
					
					if ( $product_item )
					{
						$product_item['product_price'] = recount_price( $product_item['product_price']);
						
						$_SESSION['cart'][$recheck_cart] = $product_item + array( 'product_count' => $count_item,
							'product_cost' => $product_item['product_price']*$count_item, 'product_pic' => $product_item['product_picture_small'] );
					}
                    
                    $this -> redirect();
				}
				else
				{
					unset( $_SESSION['cart'][$recheck_cart] );
                    
                    $this -> redirect();
				}
			}
						
			// Удаление товара из корзины
			if ( $out_cart = init_string( 'out_cart' ) )
			{
				unset( $_SESSION['cart'][$out_cart] );
				
				$this -> redirect();
			}
			
			// Сохранение корзины
			if ( init_string( 'action' ) == 'cart_save' )
			{
				unset( $_SESSION['cart'] );
				
				self::set_cart( init_array( 'cart' ) );
				
				$this -> redirect();
			}
		}
		
		// Редактирование товаров в корзине
		protected function get_form()
		{
			list( $cart, $order_sum, $order_count ) = self::get_cart();
			$this -> tpl -> assign( 'cart', $cart );
			$this -> tpl -> assign( 'order_sum', $order_sum );
			$this -> tpl -> assign( 'clear_url', get_url( array( 'action' => 'cart_save' ) ) );
			
			$this -> content = $this -> tpl -> fetch( 'module/cart/cart_form.tpl' );
			$this -> path = array_merge( $this -> path, array( array( 'title' => 'Корзина' ) ) );
			
			$this -> meta = $this -> read_meta( 'cart' );
		}
		
		// Информация о количестве товаров в корзине
		protected function get_info()
		{
			list( $cart, $order_sum, $order_count ) = self::get_cart();
			
			$this -> tpl -> assign( 'order_sum', $order_sum );
			$this -> tpl -> assign( 'order_count', $order_count );
			
			$this -> content = $this -> tpl -> fetch( 'module/cart/cart_info.tpl' );
		}
		
		// Перенаправление на список товаров в корзине
		protected function redirect()
		{
			header( 'Location: /cart.php' ); exit;
		}
		
		// Извлекает корзину из сессии
		static function get_cart()
		{
			$order_sum = $order_count = 0;
			
			foreach ( $_SESSION['cart'] as $product_id => $product_item )
			{
				$order_sum += $product_item['product_cost'];
				$order_count += $product_item['product_count'];
			}
			
			return array( $_SESSION['cart'], $order_sum, $order_count );
		}
		
		// Помещает корзину в сессию
		static function set_cart( $cart )
		{
			foreach ( $cart as $product_id => $product_count )
			{
				$product_item = db::select( '
					select product_id, product_title, if(product_price_special, product_price_special, product_price) as product_price
					from product where product_id = :product_id and product_active = 1',
						array( 'product_id' => $product_id ) );
				$product_count = intval( $product_count );
				
				if ( !$product_item || $product_count <= 0 ) continue;
				
				$product_item['product_price'] = recount_price( $product_item['product_price'] );
				
				$_SESSION['cart'][$product_id] = $product_item + array( 'product_count' => $product_count,
					'product_cost' => $product_item['product_price'] * $product_count,'product_pic' => $product_item['product_picture_small'] );
				$_SESSION['cart'][$product_id]['delete_url'] = get_url( array( 'out_cart' => $product_id ) );
			}
		}
	}
?>
