<?
	class content extends table
	{
		protected function action_copy_save( $redirect = true )
		{
			$primary_field = parent::action_copy_save( false );
			
			$metatags = db::select( '
					select meta_title, meta_keywords, meta_description, page_bottom
					from meta where meta_module = :module and meta_content = :content',
				array( 'module' => $this -> table, 'content' => init_string( $this -> primary_field ) ) );
			
			if ( $metatags )
				db::insert( 'meta', array( 'meta_module' => $this -> table, 'meta_content' => $primary_field ) + $metatags );
			
			if ( $redirect )
				$this -> redirect();
			
			return $primary_field;
		}
		
		protected function action_delete( $primary_field = '', $redirect = true )
		{
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			parent::action_delete( $primary_field, false );
			
			db::delete( 'meta', array( 'meta_module' => $this -> table, 'meta_content' => $primary_field ) );
			
			if ( $redirect )
				$this -> redirect();
		}
		
		protected function action_meta()
		{
			$card_url = $this -> decode_object( init_string( 'card_url' ) );
			
			if ( isset( $card_url[$this -> primary_field] ) )
			{
				$primary_field = $card_url[$this -> primary_field];
				$record = $this -> get_record( $primary_field );
				$record_title = $record[$this -> main_field];
			}
			else
			{
				$primary_field = ''; $record_title = '';
			}
			
			$metatags = db::select( '
					select meta_title, meta_keywords, meta_description, page_bottom
					from meta where meta_content = :content and meta_module = :module',
				array( 'content' => $primary_field, 'module' => $this -> table ) );
			
			if ( !$metatags )
				$metatags = array( 'meta_title' => '', 'meta_keywords' => '', 'meta_description' => '', 'page_bottom' => '' );
			
			$form_fields = array();
			foreach( array( 'meta_title', 'meta_keywords', 'meta_description', 'page_bottom' ) as $field_name )
			{
				$form_fields[$field_name] = metadata::$tables['meta']['fields'][$field_name];
				$form_fields[$field_name]['value'] = field::form_field( $metatags[$field_name],
						metadata::$tables['meta']['fields'][$field_name]['type'] );
			}
			
			$hidden_fields = make_hidden( array_merge( $_GET,
				array( 'action' => 'meta_save', $this -> primary_field => $primary_field ) ), array( 'card_url' ) );
			
			$action_title = 'Редактирование метатегов';
			
			$tpl = new SmartyAdmin();
			
			$tpl -> assign( 'record_title', metadata::$tables[$this -> table]['title'] . ( $record_title ? ' :: ' . $record_title : '' ) );
			$tpl -> assign( 'action_title', $action_title );
			$tpl -> assign( 'fields', $form_fields );
			$tpl -> assign( 'hidden', $hidden_fields );
			
			$this -> title = $this -> title . ( $record_title ? ' :: ' . $record_title : '' ) . ' :: ' . $action_title;
			
			$this -> content = $tpl -> fetch( 'form.tpl' );
		}
		
		protected function action_meta_save( $redirect = true )
		{
			$primary_field = init_string( $this -> primary_field );
			
			$meta_fields = array();
			foreach( array( 'meta_title', 'meta_keywords', 'meta_description' ) as $field_name )
				$meta_fields[$field_name] = field::set_field( init_string( $field_name ),
					metadata::$tables['meta']['fields'][$field_name] );
			
			$metatags = db::select( '
					select meta_id from meta where meta_content = :content and meta_module = :module',
				array( 'content' => $primary_field, 'module' => $this -> table ) );
			
			if ( $metatags )
				db::update( 'meta', $meta_fields, array( 'meta_module' => $this -> table, 'meta_content' => $primary_field ) );
			else
				db::insert( 'meta', array( 'meta_module' => $this -> table, 'meta_content' => $primary_field ) + $meta_fields );
			
			if ( $redirect )
				$this -> redirect();
		}
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function get_table_actions()
		{
			$actions = parent::get_table_actions();
			$prev_url = $this -> encode_object( $_GET );
			
			$actions['meta'] = array( 'title' => 'Метатеги', 'url' =>
				get_url( array( 'object' => $this -> table, 'action' => 'meta', 'prev_url' => $prev_url ) ) );
			
			return $actions;
		}
		
		protected function get_record_actions( $record )
		{
			$actions = parent::get_record_actions( $record );
			
			$prev_url = $this -> encode_object( $_GET );
			$card_url = $this -> encode_object( array( $this -> primary_field => $record[$this -> primary_field] ) );
			
			$actions['meta'] = array( 'title' => 'Метатеги', 'url' =>
				get_url( array( 'object' => $this -> table, 'action' => 'meta',
				'card_url' => $card_url, 'prev_url' => $prev_url ) ) );
			
			return $actions;
		}
	}
?>
