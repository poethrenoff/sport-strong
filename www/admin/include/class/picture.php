<?
	class picture extends table
	{
		protected function record_card( $action = 'edit' )
		{
			if ( $action == 'add' )
			{
				$query_params = array_merge(
					$this -> decode_object( init_string( 'prev_url' ) ),
					$this -> decode_object( init_string( 'card_url' ) ) );
				
				if ( isset( $query_params['picture_product'] ) )
				{
					$product_query = '
						select product_title, 
							( select count(*) from picture where picture_product = product_id ) as picture_count
						from product
						where product_id = :product_id';
					$product_record = db::select( $product_query, array( 'product_id' => $query_params['picture_product'] ) );
					
					$this -> fields['picture_title']['default'] =
						$product_record['product_title'] . ' (' . ( $product_record['picture_count'] + 1 ) . ')';
				}
			}
			
			parent::record_card( $action );
		}
		
		protected function action_add_save( $redirect = true )
		{
			$primary_field = parent::action_add_save( false );
			
			if ( ( isset( $_FILES['picture_name_big_file']['name'] ) && $_FILES['picture_name_big_file']['name'] ) &&
					!( isset( $_FILES['picture_name_small_file']['name'] ) && $_FILES['picture_name_small_file']['name'] ) )
				$this -> make_preview_images( $primary_field );
			
			if ( $redirect )
				$this -> redirect();
			
			return $primary_field;
		}
		
		protected function action_edit_save( $redirect = true )
		{
			parent::action_edit_save( false );
			
			if ( ( isset( $_FILES['picture_name_big_file']['name'] ) && $_FILES['picture_name_big_file']['name'] ) &&
					!( isset( $_FILES['picture_name_small_file']['name'] ) && $_FILES['picture_name_small_file']['name'] ) )
				$this -> make_preview_images();
			
			if ( $redirect )
				$this -> redirect();
		}
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function make_preview_images( $primary_field = '' )
		{
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
				
			$record = $this -> get_record( $primary_field );
			
			$small_picture_path = upload::resize_image(
				$record['picture_name_big'], $this -> fields['picture_name_small']['upload_dir'], 90, 90 );
			
			db::update( 'picture', array( 'picture_name_small' => $small_picture_path ),
				array( $this -> primary_field => $primary_field ) );
		}
	}
?>
