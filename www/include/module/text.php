<?
	class text extends module
	{
		// Параметры представления модуля по умолчанию
		protected $params = array( 'tag' => '', 'template' => '' );
		
		// Заполнение контента модуля
		protected function dispatcher()
		{
			$text_item = db::select( 'select * from text where text_tag = :text_tag and text_active = 1',
				array( 'text_tag' => $this -> params['tag'] ) );
			
			if ( !$text_item ) {
				$this -> meta = $this -> read_meta( 'text' ); return false;
			}
			
			if ( $this -> params['template'] )
			{
				$text_tpl = new SmartyClient();
				$text_tpl -> assign( 'text', $text_item['text_content'] );
				
				$this -> content = $text_tpl -> fetch( $this -> params['template'] );
			}
			else
			{
				$this -> content = $text_item['text_content'];
			}
			
			$this -> path = array_merge( $this -> path, array( array( 'title' => $text_item['text_title'] ) ) );
			
			$this -> meta = $this -> read_meta( 'text', $text_item['text_id'] );
		}
	}
?>
