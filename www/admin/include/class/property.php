<?
	class property extends table
	{
		protected function action_copy_save( $redirect = true )
		{
			$primary_field = parent::action_copy_save( false );
			
			$values = db::select_all( 'select * from value where value_property = :value_property',
				array( 'value_property' => init_string( $this -> primary_field ) ) );
			
			foreach( $values as $value )
				db::insert( 'value', array( 'value_property' => $primary_field, 'value_title' => $value['value_title'] ) );
			
			if ( $redirect )
				$this -> redirect();
			
			return $primary_field;
		}
		
		protected function action_delete( $primary_field = '', $redirect = true )
		{
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			$records_count = db::select( '
					select count(*) as _count from product_property where property = :property',
				array( 'property' => $primary_field ) );
			
			if ( $records_count['_count'] )
				throw new Exception( 'Ошибка. Невозможно удалить запись, так как у нее есть зависимые записи в таблице "Свойства товаров".' );
			
			parent::action_delete( $primary_field, $redirect );
		}
	}
?>
