<?
	class question extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array( 'items_per_page' => 10 );
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			$mode = init_string( 'mode' );
			
			if ( $mode == 'form' )
				$this -> get_form();
			else
				$this -> get_list();
		}
		
		// Вывод списка вопросов
		protected function get_list()
		{
			
			$items_per_page = max( intval( $this -> params['items_per_page'] ), 1 );
			
			$question_query = 'select count(*) as _question_count from question where question_active = 1';
			$question_count = db::select( $question_query );
			
			if ( $question_count = $question_count['_question_count'] )
			{
				$first_page = 0; $last_page = max( floor( ( $question_count - 1 ) / $items_per_page ), 0 );
				$page = min( max( intval( init_string( 'page' ) ), $first_page ), $last_page );
				$limit = $items_per_page; $offset = $items_per_page * $page;
				
				$question_query = 'select * from question where question_active = 1
					order by question_answer <> \'\', question_date desc, question_id desc
					limit ' . $limit . ' offset ' . $offset;
				$question_list = db::select_all( $question_query );
				
				foreach ( $question_list as $question_index => $question_item )
					$question_list[$question_index]['question_content'] = nl2br( htmlspecialchars( $question_item['question_content'] ) );
				
				$this -> tpl -> assign( 'question_list', $question_list );

				if ( $question_count > $items_per_page )
				{
					$this -> tpl -> assign( 'pages', pages( $last_page + 1, $page ) );
					
					
				}
			}
			
			
			$error = ( init_string( 'action' ) == 'question_list' ) ? $this -> add_question() : '';
			 
			$this -> tpl -> assign( 'error', $error );
			
			$this -> tpl -> assign( 'question_author', init_string( 'question_author' ) );
			$this -> tpl -> assign( 'question_email', init_string( 'question_email' ) );
			$this -> tpl -> assign( 'question_content', init_string( 'question_content' ) );
			
			$this -> tpl -> assign( 'captcha_id', captcha::generate() );
			
			$this -> tpl -> assign( 'question_form_url',
				get_url( array( 'mode' => 'form' ), array(), '/question.php' ) );
			
			$this -> content = $this -> tpl -> fetch( 'module/question/question_list.tpl' );
			
			$this -> meta = $this -> read_meta( 'question' );
		}		
		
		// Вывод формы добавления вопроса
		protected function get_form()
		{
			$error = ( init_string( 'action' ) == 'question' ) ? $this -> add_question() : '';
			 
			$this -> tpl -> assign( 'error', $error );
			
			$this -> tpl -> assign( 'question_author', init_string( 'question_author' ) );
			$this -> tpl -> assign( 'question_email', init_string( 'question_email' ) );
			$this -> tpl -> assign( 'question_content', init_string( 'question_content' ) );
			
			$this -> tpl -> assign( 'captcha_id', captcha::generate() );
			
			$this -> content = $this -> tpl -> fetch( 'module/question/question_form.tpl' );
			
			$this -> meta = $this -> read_meta( 'question' );
		}
		
		// Добавление вопроса
		protected function add_question()
		{
			$question_author = init_string( 'question_author' );
			$question_email = init_string( 'question_email' );
			$question_content = init_string( 'question_content' );
			
			$captcha_id = init_string( 'captcha_id' );
			$captcha_value = init_string( 'captcha_value' );
			
			if ( !$question_author )
				return 'Ошибка! Не заполнено поле "ИМЯ"!';
			if ( !$question_email )
				return 'Ошибка! Не заполнено поле "EMAIL"!';
			if ( !$question_content )
				return 'Ошибка! Не заполнено поле "ВОПРОС"!';
			if ( !$captcha_value )
				return 'Ошибка! Не заполнено поле "КОНТРОЛЬНОЕ ЧИСЛО"!';
			
			if ( !captcha::check( $captcha_id, $captcha_value ) )
				return 'Ошибка! Введеное число не соответствует коду на изображении!';
			
			$question_date = date( 'YmdHis', time() );
			
			$question_record = array( 'question_content' => $question_content,
				'question_author' => $question_author, 'question_email' => $question_email,
				'question_date' => $question_date, 'question_active' => 1 );
			
			db::insert( 'question', $question_record );
			
			$admin_email = get_preference( 'admin_email' ); //"sport-strong@yandex.ru"; zakaz-sport@mail.ru
			$mail_subject = email_encode( 'Новый вопрос на сайте Sport-Strong.ru' );
			
			$mail_tpl = new SmartyClient();
			
			$question_record['question_date'] = get_date( $question_record['question_date'], 'long' );
			
			$mail_tpl -> assign( $question_record );
			$mail_text = $mail_tpl -> fetch( 'module/question/question_mail.tpl' );
			
			mail( $admin_email, $mail_subject, $mail_text, "From: \"{$_SERVER['SERVER_NAME']}\" <sport-strong@yandex.ru>\nMIME-Version: 1.0\nContent-Type: text/plain; charset=\"UTF-8\"" );
			
			header( 'Location: /question.php' );
			
			exit;
		}
	}
?>
