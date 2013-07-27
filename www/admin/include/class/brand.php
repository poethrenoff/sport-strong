<?
	include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/include/class/content.php';
	
	class brand extends content
	{
		protected function action_add_save( $redirect = true )
		{
			if (!init_string('brand_url')) {
				$_REQUEST['brand_url'] = to_translit(init_string('brand_title'));
			}
			unset( $this -> fields['brand_url']['no_add'] );
			
			$primary_field = parent::action_add_save( false );
			
			if ( $redirect )
				$this -> redirect();
			
			return $primary_field;
		}
	}
?>
