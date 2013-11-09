<?
	class callback extends module
	{
		// Описание ошибки на этапе отправки
		protected $error = '';
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			$action = init_string( 'action' );
			
			if ( $action == 'callback_complete' )
				$this -> callback_complete();
			else
			{
				if ( $action == 'callback_save' )
					$this -> error = $this -> callback_save();
				
				$this -> callback_view();
			}
		}
		
		// Форма обратного звонка
		protected function callback_view()
		{
			$this -> tpl -> assign( 'error', $this -> error );
			
			$this -> content = $this -> tpl -> fetch( 'module/callback/callback_form.tpl' );
			
			$this -> meta = $this -> read_meta( 'callback' );
		}
		
		// Отправка сообщения об обратном звонке
		protected function callback_save()
		{
			$callback_person = init_string( 'callback_person' );
			$callback_phone = init_string( 'callback_phone' );
			$callback_time = init_string( 'callback_time' );
			$callback_comment = init_string( 'callback_comment' );
			
			if ( !$callback_person || !$callback_phone )
				return 'Не заполнено обязательное поле!';
			
			$callback_item = array(
				'callback_person' => $callback_person,
				'callback_phone' => $callback_phone,
				'callback_time' => $callback_time,
				'callback_comment' => $callback_comment );
			
			$manager_email = get_preference( 'admin_email' );
			
			$site_name = strtoupper( $_SERVER['SERVER_NAME'] );
			$site_url = 'http://' . $_SERVER['SERVER_NAME'];
			
			$manager_subject = email_encode( "Запрос обратного звонка на {$site_name}" );
			
			$mail_tpl = new SmartyClient();
			
			$mail_tpl -> assign( 'manager_email', $manager_email );
			
			$mail_tpl -> assign( 'site_url', $site_url );
			$mail_tpl -> assign( 'site_name', $site_name );
			
			$mail_tpl -> assign( $callback_item );
			
			$manager_text = $mail_tpl -> fetch( 'module/callback/callback_mail.tpl' );
			
			@mail( $manager_email, $manager_subject, $manager_text, "From: \"{$_SERVER['SERVER_NAME']}\" <admin@{$_SERVER['SERVER_NAME']}\nMIME-Version: 1.0\nContent-Type: text/plain; charset=\"UTF-8\"");
			
			header( 'Location: ' . get_url( array( 'action' => 'callback_complete' ), array(), '/callback.php', '&' ) );
			
			exit;
		}
		
		// Собщение об отправке сообщения 
		protected function callback_complete()
		{
			$this -> tpl -> assign( 'manager_phone', get_preference( 'manager_phone' ) );
			
			$this -> content = $this -> tpl -> fetch( 'module/callback/callback_complete.tpl' );
			
			$this -> meta = $this -> read_meta( 'callback' );
		}
	}
?>
