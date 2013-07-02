<?
	class meta_import extends tool
	{
		protected function action_tool()
		{
			$tpl = new SmartyAdmin();
				
			$tpl -> assign( 'title', $this -> title );
			
			if ( init_string( 'result' ) == 'ok' )
				$tpl -> assign( 'message', 'Импорт успешно завершен!' );
			
			if ( init_string( 'result' ) == 'error' )
				$tpl -> assign( 'message', 'При импорте произошла ошибка!' );
			
			$this -> content = $tpl -> fetch( 'class/meta_import/import.tpl' );
		}
		
		protected function action_import()
		{
			if ( !( isset( $_FILES['file'] ) && $_FILES['file'] ) )
				$this -> redirect();
			
			if ( $_FILES['file']['error'] != UPLOAD_ERR_OK )
				$this -> redirect( 'error' );
			
			$fhandle = fopen( $_FILES['file']['tmp_name'], 'r' );
			
			while ( ( $string = fgetcsv( $fhandle, 512, ';', '"' ) ) !== false )
			{
				@list( $meta_id, $meta_module, $meta_content, $meta_title, $meta_keywords, $meta_description, $page_top, $page_bottom ) = $string;
				
				$meta_title = iconv( 'windows-1251', 'UTF-8', $meta_title );
				$meta_keywords = iconv( 'windows-1251', 'UTF-8', $meta_keywords );
				$meta_description = iconv( 'windows-1251', 'UTF-8', $meta_description );
				$page_top = iconv( 'windows-1251', 'UTF-8', $page_top );
				$page_bottom = iconv( 'windows-1251', 'UTF-8', $page_bottom );
				
				if ( $meta_id !== '' )
					db::update( 'meta', array( 'meta_module' => $meta_module, 'meta_content' => $meta_content,
						'meta_title' => $meta_title, 'meta_keywords' => $meta_keywords, 'meta_description' => $meta_description ), array( 'meta_id' => $meta_id ) );
			}
			
			fclose( $fhandle );
			
			$this -> redirect( 'ok' );
		}
		
		protected function redirect( $result = '' )
		{
			header( 'Location: ' . get_url( array( 'object' => 'meta_import', 'result' => $result ), array(), '', '&' ) ); exit;
		}
	}
?>
