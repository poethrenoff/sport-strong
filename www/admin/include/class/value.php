<?
	class value extends table
	{
		protected function action_delete( $primary_field = '', $redirect = true )
		{
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			$value_property = db::select( '
					select value_property from value where value_id = :value_id',
				array( 'value_id' => $primary_field ) );
			
			$records_count = db::select( '
					select count(*) as _count from product_property where property = :property and value = :value',
				array( 'property' => $value_property['value_property'], 'value' => $primary_field ) );
			
			if ( $records_count['_count'] )
				throw new Exception( 'Ошибка. Невозможно удалить запись, так как у нее есть зависимые записи в таблице "Свойства товаров".' );
			
			parent::action_delete( $primary_field, $redirect );
		}
	}
?>
