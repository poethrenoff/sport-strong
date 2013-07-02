<?
	include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/include/class/content.php';
	
	class catalogue extends content
	{
		protected function action_add_save( $redirect = true )
		{
			if (!init_string('catalogue_url')) {
				$_REQUEST['catalogue_url'] = to_translit(init_string('catalogue_short_title'));
			}
			unset( $this -> fields['catalogue_url']['no_add'] );
			
			$primary_field = parent::action_add_save( false );
			
			if ( isset( $_FILES['catalogue_picture_file']['name'] ) && $_FILES['catalogue_picture_file']['name'] )
				$this -> resize_catalogue_picture( $primary_field );
			
			if ( $redirect )
				$this -> redirect();
			
			return $primary_field;
		}
		
		protected function action_edit_save( $redirect = true )
		{
			parent::action_edit_save( false );
			
			if ( isset( $_FILES['catalogue_picture_file']['name'] ) && $_FILES['catalogue_picture_file']['name'] )
				$this -> resize_catalogue_picture();
			
			if ( $redirect )
				$this -> redirect();
		}
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function resize_catalogue_picture( $primary_field = '' )
		{
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			$record = $this -> get_record( $primary_field );
			
			upload::resize_image( $record['catalogue_picture'], '', 120, 140 );
		}
	}
?>
