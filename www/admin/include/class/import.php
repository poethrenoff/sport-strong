<?
	class import extends tool
	{
		protected function action_tool()
		{
			$tpl = new SmartyAdmin();
				
			$tpl -> assign( 'title', $this -> title );
			
			if ( init_string( 'result' ) == 'ok' )
				$tpl -> assign( 'message', 'Импорт успешно завершен!' );
			
			if ( init_string( 'result' ) == 'error' )
				$tpl -> assign( 'message', 'При импорте произошла ошибка!' );
			
			$this -> content = $tpl -> fetch( 'class/import/import.tpl' );
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
				@list( $product_id, $product_title, $product_price, $product_price_old, $product_available ) = $string;
				
				$product_price = str_replace( ',', '.', $product_price );
				$product_price_old = str_replace( ',', '.', $product_price_old );
				
				if ( $product_id !== '' && $product_price !== '' )
					db::update( 'product', array( 'product_price' => $product_price, 'product_price_old' => $product_price_old, 'product_available' => $product_available ), array( 'product_id' => $product_id ) );
			}
			
			fclose( $fhandle );
			
			$this -> redirect( 'ok' );
		}
		
		protected function redirect( $result = '' )
		{
			header( 'Location: ' . get_url( array( 'object' => 'import', 'result' => $result ), array(), '', '&' ) ); exit;
		}
	}
?>
