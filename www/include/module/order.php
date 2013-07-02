<?
	include_once $_SERVER['DOCUMENT_ROOT'] . '/include/module/cart.php';
	
	class order extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array( 'mode' => 'order' );
		
		// Содержимое корзины
		protected $cart = array();
		
		// Сумма заказа
		protected $order_sum = 0;
		
		// Описание ошибки на этапе сохранения заказа
		protected $error = '';
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			if ( !isset( $_SESSION['cart'] ) || !is_array( $_SESSION['cart'] ) )
				$_SESSION['cart'] = array();
			
			$action = init_string( 'action' );
			
			if ( $this -> params['mode'] == 'fast_order' )
			{
				if ( $action == 'order_complete' )
					$this -> fast_order_complete();
				else
				{
					if ( $action == 'order_save' )
						$this -> error = $this -> fast_order_save();
					
					$this -> fast_order_view();
				}
			}
			else
			{
				if ( $action == 'order_complete' )
					$this -> order_complete();
				else
				{
					list( $this -> cart, $this -> order_sum ) = cart::get_cart();
					
					if ( $action == 'order_save' && count( $this -> cart ) )
						$this -> error = $this -> order_save();
						
					$this -> order_view();
				}
			}
		}
		
		// Форма оформления заказа
		protected function order_view()
		{
			$this -> tpl -> assign( 'cart', $this -> cart );
			$this -> tpl -> assign( 'order_sum', $this -> order_sum );
			$this -> tpl -> assign( 'error', $this -> error );
				
			$this -> content = $this -> tpl -> fetch( 'module/order/order_form.tpl' );
			$this -> path = array_merge( $this -> path, array( array( 'title' => 'Оформление заказа' ) ) );
			
			$this -> meta = $this -> read_meta( 'order' );
		}
		
		// Оформление заказа
		protected function order_save()
		{
			$order_client_name = init_string( 'order_client_name' ); $order_client_email = init_string( 'order_client_email' );
			$order_client_phone = init_string( 'order_client_phone' ); $order_client_address = init_string( 'order_client_address' );
			$order_client_comment = init_string( 'order_client_comment' );
			$order_client_city = init_string( 'order_client_city' );
			
			if ( !$order_client_name || !$order_client_email || !$order_client_phone || !$order_client_address )
				return 'Не заполнено обязательное поле!';
			
			db::insert( 'orders', array(
				'order_client_name' => $order_client_name, 'order_client_email' => $order_client_email,
				'order_client_phone' => $order_client_phone, 'order_client_address' => $order_client_address,
				'order_client_comment' => $order_client_comment,
				'order_client_city' => $order_client_city,
				'order_date' => set_date( date( 'd.m.Y H:i:s', time() ) , 'full' ),
				'order_sum' => $this -> order_sum, 'order_status' => 'new' ) );
			
			$order_id = db::last_insert_id();
			
			foreach ( $this -> cart as $product_index => $product_item )
				db::insert( 'item', array(
					'item_order' => $order_id, 'order_product' => $product_item['product_title'],
					'order_price' => $product_item['product_price'], 'order_count' => $product_item['product_count'] ) );
			
			$manager_email = get_preference( 'admin_email' );
			$manager_phone = get_preference( 'manager_phone' );
			
			$site_name = strtoupper( $_SERVER['SERVER_NAME'] );
			$site_url = 'http://' . $_SERVER['SERVER_NAME'];
			
			$client_subject = email_encode( "{$site_name}: Ваш заказ получен!" );
			$manager_subject = email_encode( "Новый заказ на {$site_name}!" );
			
			$mail_tpl = new SmartyClient();
			
			$mail_tpl -> assign( 'manager_email', $manager_email );
			$mail_tpl -> assign( 'manager_phone', $manager_phone );
			
			$mail_tpl -> assign( 'site_url', $site_url );
			$mail_tpl -> assign( 'site_name', $site_name );
			
			$mail_tpl -> assign( 'cart', $this -> cart );
			$mail_tpl -> assign( 'order_sum', $this -> order_sum );
			
			$mail_tpl -> assign( 'order_client_name', $order_client_name );
			$mail_tpl -> assign( 'order_client_email', $order_client_email );
			$mail_tpl -> assign( 'order_client_phone', $order_client_phone );
			$mail_tpl -> assign( 'order_client_address', strip_tags( $order_client_address ) );
			$mail_tpl -> assign( 'order_client_comment', strip_tags( $order_client_comment ) );
			$mail_tpl -> assign( 'order_client_city', strip_tags( $order_client_city ) );
			
			$manager_text = $mail_tpl -> fetch( 'module/order/manager_mail.tpl' );
			$client_text = $mail_tpl -> fetch( 'module/order/client_mail.tpl' );
			
			@mail( $manager_email, $manager_subject, $manager_text, "From: \"{$_SERVER['SERVER_NAME']}\" <admin@{$_SERVER['SERVER_NAME']}\nMIME-Version: 1.0\nContent-Type: text/plain; charset=\"UTF-8\"");
			@mail( $order_client_email, $client_subject, $client_text, "From: \"{$_SERVER['SERVER_NAME']}\" <$manager_email>\nMIME-Version: 1.0\nContent-Type: text/plain; charset=\"UTF-8\"");
			
			$_SESSION['cart'] = array();
			
			header( 'Location: ' . get_url( array( 'action' => 'order_complete' ), array(), '/order.php', '&' ) );
			
			exit;
		}
		
		// Собщение об успешном оформлении заказа
		protected function order_complete()
		{
			$this -> tpl -> assign( 'manager_phone', get_preference( 'manager_phone' ) );
			
			$this -> content = $this -> tpl -> fetch( 'module/order/order_complete.tpl' );
			
			$this -> meta = $this -> read_meta( 'order' );
		}
		
		// Форма оформления быстрого заказа
		protected function fast_order_view()
		{
			$product_id = $this -> get_param( 'product_id' );
			$product_query = '
				select product.*, brand.*, catalogue.*
				from product
					inner join brand on brand.brand_id = product.product_brand
					inner join catalogue on catalogue.catalogue_id = product.product_catalogue
				where product_id = :product_id and product_active = 1';
			$product_item = db::select( $product_query, array( 'product_id' => $product_id ) );
			
			if ( !$product_item )
			{
				$this -> meta = $this -> read_meta( 'product' ); return false;
			}
			
			$this -> tpl -> assign( $product_item );
			$this -> tpl -> assign( 'error', $this -> error );
			
			$this -> content = $this -> tpl -> fetch( 'module/order/fast_order_form.tpl' );
			
			$this -> meta = $this -> read_meta( 'order' );
		}
		
		// Оформление заказа
		protected function fast_order_save()
		{
			$product_id = $this -> get_param( 'product_id' );
			$product_query = 'select product.* from product where product_id = :product_id and product_active = 1';
			$product_item = db::select( $product_query, array( 'product_id' => $product_id ) );
			
			if ( !$product_item )
				return 'Не выбран товар!';
			
			$order_client_name = init_string( 'order_client_name' );
			$order_client_phone = init_string( 'order_client_phone' );
			$order_client_comment = init_string( 'order_client_comment' );
			
			if ( !$order_client_name || !$order_client_phone )
				return 'Не заполнено обязательное поле!';
			
			db::insert( 'orders', array(
				'order_client_name' => $order_client_name, 'order_client_email' => '',
				'order_client_phone' => $order_client_phone, 'order_client_address' => '',
				'order_client_comment' => $order_client_comment,
				'order_date' => set_date( date( 'd.m.Y H:i:s', time() ) , 'full' ),
				'order_sum' => $product_item['product_price'], 'order_status' => 'fast' ) );
			
			$order_id = db::last_insert_id();
			
			db::insert( 'item', array(
				'item_order' => $order_id, 'order_product' => $product_item['product_title'],
				'order_price' => $product_item['product_price'], 'order_count' => 1 ) );
			
			$manager_email = get_preference( 'admin_email' );
			
			$site_name = strtoupper( $_SERVER['SERVER_NAME'] );
			$site_url = 'http://' . $_SERVER['SERVER_NAME'];
			
			$manager_subject = email_encode( "Новый быстрый заказ на {$site_name}!" );
			
			$mail_tpl = new SmartyClient();
			
			$mail_tpl -> assign( 'manager_email', $manager_email );
			
			$mail_tpl -> assign( 'site_url', $site_url );
			$mail_tpl -> assign( 'site_name', $site_name );
			
			$mail_tpl -> assign( $product_item );
			
			$mail_tpl -> assign( 'order_client_name', $order_client_name );
			$mail_tpl -> assign( 'order_client_phone', $order_client_phone );
			$mail_tpl -> assign( 'order_client_comment', strip_tags( $order_client_comment ) );
			
			$manager_text = $mail_tpl -> fetch( 'module/order/fast_manager_mail.tpl' );
			
			@mail( $manager_email, $manager_subject, $manager_text, "From: \"{$_SERVER['SERVER_NAME']}\" <admin@{$_SERVER['SERVER_NAME']}\nMIME-Version: 1.0\nContent-Type: text/plain; charset=\"UTF-8\"");
			
			header( 'Location: ' . get_url( array( 'action' => 'order_complete' ), array(), '/fast_order.php', '&' ) );
			
			exit;
		}
		
		// Собщение об успешном оформлении заказа
		protected function fast_order_complete()
		{
			$this -> tpl -> assign( 'manager_phone', get_preference( 'manager_phone' ) );
			
			$this -> content = $this -> tpl -> fetch( 'module/order/fast_order_complete.tpl' );
			
			$this -> meta = $this -> read_meta( 'order' );
		}
	}
?>
