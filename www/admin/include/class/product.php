<?
	include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/include/class/content.php';
	
	class product extends content
	{
		protected function action_add_save( $redirect = true )
		{
			if (!init_string('product_url')) {
				$_REQUEST['product_url'] = to_translit(init_string('product_title'));
			}
			unset( $this -> fields['product_url']['no_add'] );
			
			$primary_field = parent::action_add_save( false );
			
			if ( ( isset( $_FILES['product_picture_big_file']['name'] ) && $_FILES['product_picture_big_file']['name'] ) &&
					!( isset( $_FILES['product_picture_middle_file']['name'] ) && $_FILES['product_picture_middle_file']['name'] ) &&
					!( isset( $_FILES['product_picture_small_file']['name'] ) && $_FILES['product_picture_small_file']['name'] ) )
				$this -> make_preview_images( $primary_field );
			
			$meta_fields = array();
			foreach( array( 'meta_title', 'meta_keywords', 'meta_description' ) as $field_name )
				$meta_fields[$field_name] = field::set_field( init_string( 'product_title' ),
					metadata::$tables['meta']['fields'][$field_name] );
			
			db::insert( 'meta', array( 'meta_module' => $this -> table, 'meta_content' => $primary_field ) + $meta_fields );
			
			if ( $redirect )
				$this -> redirect();
			
			return $primary_field;
		}
		
		protected function action_copy_save( $redirect = true )
		{
			$primary_field = $this -> action_add_save( false );
			
			$product_properties = db::select_all( '
					select property, value
					from product_property where product = :product',
				array( 'product' => init_string( $this -> primary_field ) ) );
			
			foreach( $product_properties as $product_property )
				db::insert( 'product_property', array( 'product' => $primary_field ) + $product_property );
			
			if ( $redirect )
				$this -> redirect();
			
			return $primary_field;
		}
		
		protected function action_edit_save( $redirect = true )
		{
			parent::action_edit_save( false );
			
			if ( ( isset( $_FILES['product_picture_big_file']['name'] ) && $_FILES['product_picture_big_file']['name'] ) &&
					!( isset( $_FILES['product_picture_middle_file']['name'] ) && $_FILES['product_picture_middle_file']['name'] ) &&
					!( isset( $_FILES['product_picture_small_file']['name'] ) && $_FILES['product_picture_small_file']['name'] ) )
				$this -> make_preview_images();
			
			if ( $redirect )
				$this -> redirect();
		}
		
		protected function action_delete( $primary_field = '', $redirect = true )
		{
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			parent::action_delete( $primary_field, false );
			
			db::delete( 'product_property', array( 'product' => $primary_field ) );
			
			if ( $redirect )
				$this -> redirect();
		}
		
		protected function action_property()
		{
			$card_url = $this -> decode_object( init_string( 'card_url' ) );
			
			if ( !isset( $card_url['product_id'] ) )
				throw new Exception( 'Ошибка. Запись не найдена.' );
			else
				$record = $this -> get_record( $card_url['product_id'] );
			
			$properties = db::select_all( '
					select property.property_id, property.property_title, property.property_kind,
						product_property.value, property.property_unit
					from property
						inner join product on property.property_type = product.product_type
						left join product_property on product_property.property = property.property_id and
							product_property.product = product.product_id
					where product.product_id = :product_id
					order by property.property_order',
				array( 'product_id' => $record['product_id'] ) );
			
			$form_fields = array();
			foreach( $properties as $property_index => $property_value )
			{
				$property_type = $property_value['property_kind'] == 'number' ? 'float' : $property_value['property_kind'];
				$property_errors = $property_type == 'float' ? 'float' : '';
				
				$form_fields['property[' . $property_value['property_id'] . ']'] = array(
						'title' => $property_value['property_title'] . ( $property_value['property_unit'] ?
							' (' . $property_value['property_unit'] . ')' : '' ),
						'type' => $property_type, 'errors' => $property_errors,
						'value' => field::form_field( $property_value['value'], $property_type ) );
				
				if ( $property_value['property_kind'] == 'select' )
				{
					$values = db::select_all( '
							select * from value
							where value_property = :value_property
							order by value_title',
						array( 'value_property' => $property_value['property_id'] ) );
						
					$value_records = array();
					foreach ( $values as $value )
						$value_records[] = array( 'value' => $value['value_id'], 'title' => $value['value_title'] );
					
					$form_fields['property[' . $property_value['property_id'] . ']']['values'] = $value_records;
				}
			}
			
			$hidden_fields = make_hidden( array_merge( $_GET,
				array( 'action' => 'property_save', 'product_id' => $record['product_id'] ) ), array( 'card_url' ) );
			
			$record_title = $record[$this -> main_field];
			$action_title = 'Редактирование свойств';
			
			$tpl = new SmartyAdmin();
			
			$tpl -> assign( 'record_title', metadata::$tables[$this -> table]['title'] . ' :: ' . $record_title );
			$tpl -> assign( 'action_title', $action_title );
			$tpl -> assign( 'fields', $form_fields );
			$tpl -> assign( 'hidden', $hidden_fields );
			
			$this -> title = $this -> title . ' :: ' . $record_title . ' :: ' . $action_title;
			
			$this -> content = $tpl -> fetch( 'form.tpl' );
		}
		
		protected function action_property_save( $redirect = true )
		{
			$record = $this -> get_record( init_string( 'product_id' ) );
			
			$properties = db::select_all( '
					select property.property_id, property.property_title, property.property_kind
					from property
						inner join product on property.property_type = product.product_type
					where product.product_id = :product_id',
				array( 'product_id' => $record['product_id'] ) );
			
			$property_values = init_array( 'property' );
			
			$insert_fields = array();
			foreach( $properties as $property_index => $property_value )
			{
				$property_type = $property_value['property_kind'] == 'number' ? 'float' : $property_value['property_kind'];
				$property_errors_code = $property_type == 'float' ? field::$errors['float'] : 0;
				
				if ( isset( $property_values[$property_value['property_id']] ) )
					$insert_fields[$property_value['property_id']] =
						field::set_field( $property_values[$property_value['property_id']],
					array( 'title' => $property_value['property_title'],
						'type' => $property_type, 'errors_code' => $property_errors_code ) );
			}
			
			db::delete( 'product_property', array( 'product' => $record['product_id'] ) );
			
			foreach( $insert_fields as $property_id => $property_value )
				if ( $property_value !== null && $property_value !== '' )
					db::insert( 'product_property', array(
						'product' => $record['product_id'], 'property' => $property_id, 'value' => $property_value ) );
			
			if ( $redirect )
				$this -> redirect();
		}
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function get_record_actions( $record )
		{
			$actions = parent::get_record_actions( $record );
			
			$prev_url = $this -> encode_object( $_GET );
			$card_url = $this -> encode_object( array( $this -> primary_field => $record[$this -> primary_field] ) );
			
			$actions['property'] = array( 'title' => 'Свойства', 'url' =>
				get_url( array( 'object' => $this -> table, 'action' => 'property',
				'card_url' => $card_url, 'prev_url' => $prev_url ) ) );
			
			return $actions;
		}
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function make_preview_images( $primary_field = '' )
		{
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
				
			$record = $this -> get_record( $primary_field );
			
			$middle_picture_path = upload::resize_image(
				$record['product_picture_big'], $this -> fields['product_picture_middle']['upload_dir'], 300, 300 );
			db::update( 'product', array( 'product_picture_middle' => $middle_picture_path ),
				array( $this -> primary_field => $primary_field ) );
				
			$small_picture_path = upload::resize_image(
				$record['product_picture_big'], $this -> fields['product_picture_small']['upload_dir'], 120, 130 );
			db::update( 'product', array( 'product_picture_small' => $small_picture_path ),
				array( $this -> primary_field => $primary_field ) );
		}
	}
?>
