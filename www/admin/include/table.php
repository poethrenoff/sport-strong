<?
	class table
	{
		protected $table = '';
		
		protected $primary_field = '';
		protected $main_field = '';
		protected $parent_field = '';
		protected $active_field = '';
		protected $order_field = '';
		
		protected $fields = array();
		protected $show_fields = array();
		protected $filter_fields = array();
		
		protected $links = array();
		protected $relations = array();
		
		protected $sort_field = '';
		protected $sort_order = '';
		
		protected $limit_clause = '';
		
		protected $filter_clause = '';
		protected $filter_binds = array();
		
		protected $title = '';
		
		protected $content = '';
		
		protected $records_per_page = 30;
		
		protected $lang_list = array();
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function __construct( $table )
		{
			$this -> table = $table;
			
			$this -> primary_field = metadata::$tables[$this -> table]['primary_field'];
			$this -> main_field = metadata::$tables[$this -> table]['main_field'];
			
			if ( isset( metadata::$tables[$this -> table]['parent_field'] ) )
				$this -> parent_field = metadata::$tables[$this -> table]['parent_field'];
			if ( isset( metadata::$tables[$this -> table]['active_field'] ) )
				$this -> active_field = metadata::$tables[$this -> table]['active_field'];
			if ( isset( metadata::$tables[$this -> table]['order_field'] ) )
				$this -> order_field = metadata::$tables[$this -> table]['order_field'];
			
			$this -> fields = metadata::$tables[$this -> table]['fields'];
			$this -> show_fields = metadata::$tables[$this -> table]['show_fields'];
			if ( isset( metadata::$tables[$this -> table]['filter_fields'] ) )
				$this -> filter_fields = metadata::$tables[$this -> table]['filter_fields'];
			
			if ( isset( metadata::$tables[$this -> table]['links'] ) )
				$this -> links = metadata::$tables[$this -> table]['links'];
			if ( isset( metadata::$tables[$this -> table]['relations'] ) )
				$this -> relations = metadata::$tables[$this -> table]['relations'];
			
			if ( isset( metadata::$tables['lang'] ) )
				$this -> lang_list = db::select_all( 'select * from lang order by lang_default desc' );
			
			$this -> sort_field = metadata::$tables[$this -> table]['sort_field'];
			$this -> sort_order = metadata::$tables[$this -> table]['sort_order'];
			
			$this -> title = metadata::$tables[$this -> table]['title'];
		}
		
		public static function factory( $table )
		{
			if ( !isset( metadata::$tables[$table] ) )
				throw new Exception( 'Ошибка. Объект "' . $table . '" не описан в метаданных.' );
			
			if ( isset( metadata::$tables[$table]['internal'] ) && metadata::$tables[$table]['internal'] )
				throw new Exception( 'Ошибка. Попытка обратиться к внутренней таблице "' . $table . '".' );
			
			if ( isset( metadata::$tables[$table]['class'] ) && metadata::$tables[$table]['class'] )
			{
				$class_name = metadata::$tables[$table]['class'];
				include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/include/class/' . $class_name . '.php';
				return new $class_name( $table );
			}
			else
				return new table( $table );
		}
        
		public function get_title()
		{
			return $this -> title;
		}
		
		public function get_content()
		{
			return $this -> content;
		}
		
		public function init()
		{
			$method_name = 'action_' . init_string( 'action', 'table' );
			
			if ( method_exists( $this, $method_name ) )
				$this -> $method_name();
		}
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function action_table()
		{
			$sort_field = init_string( 'sort_field' );
			$sort_order = init_string( 'sort_order' );
			if ( $sort_field && in_array( $sort_field, $this -> show_fields ) )
				$this -> sort_field = $sort_field;
			if ( $sort_order && in_array( $sort_order, array( 'asc', 'desc' ) ) )
				$this -> sort_order = $sort_order;
			
			$records_header['_index'] = array( 'title' => 'ID' );
			
			foreach ( $this -> show_fields as $show_field )
			{
				$records_header[$show_field] = $this -> fields[$show_field];
				$field_sort_order = $show_field == $this -> sort_field && $this -> sort_order == 'asc' ? 'desc' : 'asc';
				$records_header[$show_field]['sort_url'] =
					get_request_url( array( 'sort_field' => $show_field, 'sort_order' => $field_sort_order ), array( 'page' ) );
				if ( $show_field == $this -> sort_field )
					$records_header[$show_field]['sort_sign'] = $field_sort_order == 'asc' ? 'desc' : 'asc';
			}
			
			$records_header += $this -> get_table_headers();
			
			$records_header['_action'] = array( 'title' => 'Действия' );
			
			if ( !$this -> parent_field )
				$this -> set_filter_condition();
			
			$records_count = $this -> get_records_count();
			
			if ( !$this -> parent_field )
			{
				$first_page = 0; $last_page = max( floor( ( $records_count - 1 ) / $this -> records_per_page ), 0 );
				$page = min( max( intval( init_string( 'page' ) ), $first_page ), $last_page );
				
				$this -> set_limit_condition( $this -> records_per_page, $this -> records_per_page * $page );
			}
		
			$records = $this -> get_records();
			
			if ( $this -> parent_field )
				$records = tree::get_tree( $records, $this -> primary_field, $this -> parent_field );
			
			foreach ( $records as $record_id => $record )
			{
				$records[$record_id]['_index'] = $records[$record_id][$this -> primary_field];
				
				foreach ( $this -> show_fields as $show_field )
					$records[$record_id][$show_field] = field::get_field(
						$records[$record_id][$show_field], $this -> fields[$show_field]['type'] );
				
				$records[$record_id] += $this -> get_record_links( $record );
				$records[$record_id] += $this -> get_record_relations( $record );
				
				$records[$record_id]['_action'] = $this -> get_record_actions( $record );
				
				$records[$record_id]['_hidden'] = $this -> active_field && !$records[$record_id][$this -> active_field];
			}
			
			$tpl = new SmartyAdmin();
			
			if ( !$this -> parent_field )
				$tpl -> assign( 'filter', $this -> get_filter() );
			$tpl -> assign( 'actions', $this -> get_table_actions() );
			
			$tpl -> assign( 'title', $this -> title );
			$tpl -> assign( 'records', $records );
			$tpl -> assign( 'header', $records_header );
			$tpl -> assign( 'counter', $records_count );
			
			if ( $records_count > $this -> records_per_page && !$this -> parent_field )
				$tpl -> assign( 'pages', pages( $last_page + 1, $page ) );
			
			$this -> content = $tpl -> fetch( 'table.tpl' );
		}
		
		protected function action_add()
		{
			$this -> is_action_allow( 'add', true );
			
			$this -> record_card( 'add' );
		}
		
		protected function action_copy()
		{
			$this -> is_action_allow( 'add', true );
			
			$this -> record_card( 'copy' );
		}
		
		protected function action_edit()
		{
			$this -> is_action_allow( 'edit', true );
			
			$this -> record_card( 'edit' );
		}
		
		protected function action_relation()
		{
			$primary_record = $this -> get_record();
			
			$relation_name = init_string( 'relation' );
			if ( !isset( $this -> relations[$relation_name] ) )
				throw new Exception( 'Ошибка. Связь "' . $relation_name . '" не описана в метаданных.' );
			
			$relation = $this -> relations[$relation_name];
			
			$secondary_object = table::factory( $relation['secondary_table'] );
			$secondary_object -> show_fields = array( $secondary_object -> main_field );
			
			$records_header['_index'] = array( 'title' => 'ID' );
			$records_header[$secondary_object -> main_field] = $secondary_object -> fields[$secondary_object -> main_field];
			$records_header['_checkbox'] = array( 'title' => 'Выбрать' );
			
			$sort_field = init_string( 'sort_field' );
			$sort_order = init_string( 'sort_order' );
			if ( $sort_field && $sort_field == $secondary_object -> main_field )
				$secondary_object -> sort_field = $sort_field;
			if ( $sort_order && in_array( $sort_order, array( 'asc', 'desc' ) ) )
				$secondary_object -> sort_order = $sort_order;
			
			$field_sort_order = $secondary_object -> main_field == $secondary_object -> sort_field && $secondary_object -> sort_order == 'asc' ? 'desc' : 'asc';
			$records_header[$secondary_object -> main_field]['sort_url'] =
				get_request_url( array( 'sort_field' => $secondary_object -> main_field, 'sort_order' => $field_sort_order ), array( 'page' ) );
			if ( $secondary_object -> main_field == $secondary_object -> sort_field )
				$records_header[$secondary_object -> main_field]['sort_sign'] = $field_sort_order == 'asc' ? 'desc' : 'asc';
			
			if ( !$secondary_object -> parent_field )
				$secondary_object -> set_filter_condition();
			
			$records_count = $secondary_object -> get_records_count();
			
			if ( !$secondary_object -> parent_field )
			{
				$first_page = 0; $last_page = max( floor( ( $records_count - 1 ) / $secondary_object -> records_per_page ), 0 );
				$page = min( max( intval( init_string( 'page' ) ), $first_page ), $last_page );
				
				$secondary_object -> set_limit_condition( $secondary_object -> records_per_page, $secondary_object -> records_per_page * $page );
			}
			
			$records = $secondary_object -> get_records();
			
			if ( $secondary_object -> parent_field )
				$records = tree::get_tree( $records, $secondary_object -> primary_field, $secondary_object -> parent_field );
			
			$secondary_list = array();
			foreach ( $records as $record_id => $record )
				$secondary_list[] = $record[$secondary_object -> primary_field];
			
			$checked_query = 'select ' . $relation['secondary_field'] . ' from ' . $relation['relation_table'] . ' where ' . $relation['primary_field'] . ' = :' . $relation['primary_field'] .
				( count( $secondary_list ) ? ' and ' . $relation['secondary_field'] . ' in ( ' . join( ', ', $secondary_list ) . ' )' : '' );
			$checked_records = db::select_all( $checked_query, array( $relation['primary_field'] => $primary_record[$this -> primary_field] ) );
			
			$checked_list = array();
			foreach ( $checked_records as $record_id => $record )
				$checked_list[] = $record[$relation['secondary_field']];
			
			foreach ( $records as $record_id => $record )
			{
				$records[$record_id]['_index'] = $record[$secondary_object -> primary_field];
				
				$records[$record_id][$secondary_object -> main_field] = field::get_field(
					$records[$record_id][$secondary_object -> main_field], $secondary_object -> fields[$secondary_object -> main_field]['type'] );
				
				$records[$record_id]['_checkbox'] = array( 'id' => $record[$secondary_object -> primary_field],
					'checked' => in_array( $record[$secondary_object -> primary_field], $checked_list ) );
			}
			
			$tpl = new SmartyAdmin();
			
			if ( !$secondary_object -> parent_field )
				$tpl -> assign( 'filter', $secondary_object -> get_filter() );
			
			$tpl -> assign( 'title', $this -> title );
			$tpl -> assign( 'records', $records );
			$tpl -> assign( 'header', $records_header );
			$tpl -> assign( 'counter', $records_count );
			
			$tpl -> assign( 'mode', 'form' );
			$hidden_fields = make_hidden( array_merge( $_GET,
				array( 'action' => 'relation_save', 'prev_url' => $this -> encode_object( $_GET ) ) ) );
			$tpl -> assign( 'hidden', $hidden_fields );
			
			$back_url = get_url( $this -> decode_object( init_string( 'prev_url' ) ) );
			$tpl -> assign( 'back_url', $back_url );
			
			if ( $records_count > $secondary_object -> records_per_page && !$secondary_object -> parent_field )
				$tpl -> assign( 'pages', pages( $last_page + 1, $page ) );
			
			$this -> content = $tpl -> fetch( 'table.tpl' );
		}
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function action_add_save( $redirect = true )
		{
			$this -> is_action_allow( 'add', true );
			
			$insert_fields = array(); $translate_values = array();
			foreach ( $this -> fields as $field_name => $field_desc )
			{
				if ( isset( $field_desc['no_add'] ) && $field_desc['no_add'] )
					continue;
				
				if ( $field_desc['type'] == 'image' || $field_desc['type'] == 'file' )
					$insert_fields[$field_name] = field::set_field(
						$this -> upload_file( $field_name, $field_desc ), $field_desc );
				else if ( $field_desc['type'] != 'pk' && $field_desc['type'] != 'order' &&
						!( $field_desc['type'] == 'password' && init_string( $field_name ) === '' ) )
				{
					if ( isset( $field_desc['translate'] ) && $field_desc['translate'] )
					{
						$translate_values[$field_name] = field::set_field( init_array( $field_name ), $field_desc );
						$insert_fields[$field_name] = current( $translate_values[$field_name] );
					}
					else
						$insert_fields[$field_name] = field::set_field( init_string( $field_name ), $field_desc );
				}
			}
			
			if ( $this -> order_field )
			{
				list( $group_conds, $group_binds ) =
					$this -> get_group_conds( $insert_fields, $this -> order_field );
				$insert_fields[$this -> order_field] = field::set_field(
					$this -> get_next_order( $group_conds, $group_binds ), $this -> fields[$this -> order_field] );
			}
			
			$this -> check_group_unique( $insert_fields );
			
			$this -> clear_default_fields( $insert_fields );
			
			db::insert( $this -> table, $insert_fields );
			
			$primary_field = db::last_insert_id();
			
			$this -> change_translate_record( $primary_field, $translate_values );
			
			if ( $redirect )
				$this -> redirect();
			
			return $primary_field;
		}
		
		protected function action_copy_save( $redirect = true )
		{
			return $this -> action_add_save( $redirect );
		}
		
		protected function action_edit_save( $redirect = true )
		{
			$this -> is_action_allow( 'edit', true );
			
			$primary_field = init_string( $this -> primary_field );
			
			$update_fields = array(); $translate_values = array();
			foreach ( $this -> fields as $field_name => $field_desc )
			{
				if ( isset( $field_desc['no_edit'] ) && $field_desc['no_edit'] )
					continue;
				
				if ( $field_desc['type'] == 'image' || $field_desc['type'] == 'file' )
					$update_fields[$field_name] = field::set_field(
						$this -> upload_file( $field_name, $field_desc ), $field_desc );
				else if ( $field_desc['type'] != 'pk' && $field_desc['type'] != 'order' &&
						!( $field_desc['type'] == 'password' && init_string( $field_name ) === '' ) )
				{
					if ( isset( $field_desc['translate'] ) && $field_desc['translate'] )
					{
						$translate_values[$field_name] = field::set_field( init_array( $field_name ), $field_desc );
						$update_fields[$field_name] = current( $translate_values[$field_name] );
					}
					else
						$update_fields[$field_name] = field::set_field( init_string( $field_name ), $field_desc );
				}
			}
			
			if ( $this -> order_field )
			{
				list( $group_conds, $group_binds ) =
					$this -> get_group_conds( $update_fields, $this -> order_field );
				
				$record = $this -> get_record();
				
				$group_permanent = true;
				foreach ( $group_binds as $field_name => $field_value )
					$group_permanent &= $record[$field_name] == $field_value;
				
				if ( !$group_permanent )
					$update_fields[$this -> order_field] = field::set_field(
						$this -> get_next_order( $group_conds, $group_binds ), $this -> fields[$this -> order_field] );
			}
			
			$this -> check_group_unique( $update_fields, $primary_field );
			
			$this -> clear_default_fields( $update_fields );
			
			db::update( $this -> table, $update_fields, array( $this -> primary_field => $primary_field ) );
			
			$this -> change_translate_record( $primary_field, $translate_values );
			
			if ( $redirect )
				$this -> redirect();
		}
		
		protected function action_move( $primary_field = '', $redirect = true )
		{
			$this -> is_action_allow( 'edit', true );
			
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			if ( $this -> order_field )
			{
				$record = $this -> get_record();
				
				list( $order_conds, $order_binds ) =
					$this -> get_group_conds( $record, $this -> order_field );
				
				if ( $prev_record = $this -> get_prev_order_record( $order_conds, $order_binds, $record ) )
				{
					db::update( $this -> table, array( $this -> order_field =>
						field::set_field( $prev_record[$this -> order_field], $this -> fields[$this -> order_field] ) ),
							array( $this -> primary_field => $primary_field ) );
					db::update( $this -> table, array( $this -> order_field =>
						field::set_field( $record[$this -> order_field], $this -> fields[$this -> order_field] ) ),
							array( $this -> primary_field => $prev_record[$this -> primary_field] ) );
				}
			}
			
			if ( $redirect )
				$this -> redirect();
		}
		
		protected function action_show( $primary_field = '', $redirect = true )
		{
			$this -> is_action_allow( 'edit', true );
			
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			if ( $this -> active_field )
				db::update( $this -> table, array( $this -> active_field => 1 ),
					array( $this -> primary_field => $primary_field ) );
			
			if ( $redirect )
				$this -> redirect();
		}
		
		protected function action_hide( $primary_field = '', $redirect = true )
		{
			$this -> is_action_allow( 'edit', true );
			
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			if ( $this -> active_field )
				db::update( $this -> table, array( $this -> active_field => 0 ),
					array( $this -> primary_field => $primary_field ) );
			
			if ( $redirect )
				$this -> redirect();
		}
		
		protected function action_delete( $primary_field = '', $redirect = true )
		{
			$this -> is_action_allow( 'delete', true );
			
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			if ( $this -> parent_field )
			{
				$query = 'select count(*) as _count from ' . $this -> table . '
					where ' . $this -> parent_field . ' = :primary_field';
				$records_count = db::select( $query, array( 'primary_field' => $primary_field ) );
				
				if ( $records_count['_count'] )
					throw new Exception( 'Ошибка. Невозможно удалить запись, так как у нее есть дочерние записи.' );
			}
			
			if ( isset( $this -> links ) && is_array( $this -> links ) )
			{
				foreach ( $this -> links as $link_name => $link_desc )
				{
					$ondelete_action = isset( $link_desc['ondelete'] ) ? $link_desc['ondelete'] : '';
					
					if ( $ondelete_action == 'set_null' )
					{
						db::update( $link_desc['table'], array( $link_desc['field'] => null ),
							array( $link_desc['field'] => $primary_field ) );
					}
					else if ( $ondelete_action == 'cascade' )
					{
						db::delete( $link_desc['table'], array( $link_desc['field'] => $primary_field ) );
					}
					else if ( $ondelete_action != 'ignore' )
					{
						$query = 'select count(*) as _count from ' . $link_desc['table'] . '
							where ' . $link_desc['field'] . ' = :primary_field';
						$records_count = db::select( $query, array( 'primary_field' => $primary_field ) );
						
						if ( $records_count['_count'] )
							throw new Exception( 'Ошибка. Невозможно удалить запись, так как у нее есть зависимые записи в таблице "' .
								metadata::$tables[$link_desc['table']]['title'] . '".' );
					}
				}
			}
			
			if ( isset( $this -> relations ) && is_array( $this -> relations ) )
				foreach ( $this -> relations as $relation_name => $relation_desc )
					db::delete( $relation_desc['relation_table'], array( $relation_desc['primary_field'] => $primary_field ) );
			
			$translate_values = array();
			foreach ( $this -> fields as $field_name => $field_desc )
				if ( isset( $field_desc['translate'] ) && $field_desc['translate'] )
					$translate_values[$field_name] = array();
			
			$this -> change_translate_record( $primary_field, $translate_values );
			
			db::delete( $this -> table, array( $this -> primary_field => $primary_field ) );
			
			if ( $redirect )
				$this -> redirect();
		}
		
		protected function action_relation_save( $redirect = true )
		{
			$primary_record = $this -> get_record();
			
			$relation_name = init_string( 'relation' );
			if ( !isset( $this -> relations[$relation_name] ) )
				throw new Exception( 'Ошибка. Связь "' . $relation_name . '" не описана в метаданных.' );
			
			$relation = $this -> relations[$relation_name];
			
			$checked_list = init_array( 'check' );
			foreach ( $checked_list as $checked_id => $checked_value )
			{
				$relation_key = array( $relation['primary_field'] => $primary_record[$this -> primary_field], $relation['secondary_field'] => $checked_id );
				
				db::delete( $relation['relation_table'], $relation_key );
				if ( $checked_value )
					db::insert( $relation['relation_table'], $relation_key );
			}
			
			if ( $redirect )
				$this -> redirect();
		}
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function set_limit_condition( $limit = 0, $offset = 0 )
		{
			$this -> limit_clause = 'limit ' . $limit . ( $offset ? ' offset ' . $offset : '' );
		}
		
		protected function set_filter_condition()
		{
			$filter_fields = array(); $filter_binds = array();
			foreach ( $this -> filter_fields as $filter_field )
			{
				$search_value = init_string( $filter_field );
				
				if ( $search_value !== '' )
				{
					if ( in_array( $this -> fields[$filter_field]['type'], array( 'string', 'text', 'image', 'file' ) ) )
					{
						$search_words = preg_split( '/\s+/', $search_value );
						
						foreach ( $search_words as $search_index => $search_word )
						{
							$filter_fields[] = '' . $this -> table . '.' . $filter_field . ' like :' . $filter_field . '_' . $search_index;
							$filter_binds[$filter_field . '_' . $search_index] = '%' . $search_word . '%';
						}
					}
					else
					{
						$filter_fields[] = '' . $this -> table . '.' . $filter_field . ' = :' . $filter_field;
						$filter_binds[$filter_field] = $search_value;
					}
				}
			}
			
			if ( count( $filter_fields ) )
			{
				$this -> filter_binds = $filter_binds;
				$this -> filter_clause = 'where ' . join( ' and ', $filter_fields );
			}
		}
		
		protected function get_records()
		{
			$select_fields = $this -> show_fields;
			$select_fields[] = $this -> primary_field;
			if ( $this -> parent_field )
				$select_fields[] = $this -> parent_field;
			if ( $this -> active_field )
				$select_fields[] = $this -> active_field;
			if ( $this -> order_field )
				$select_fields[] = $this -> order_field;
			
			if ( $this -> fields[$this -> sort_field]['type'] == 'table' )
				$sort_field = '' . $this -> fields[$this -> sort_field]['table'] . '.' .
					metadata::$tables[$this -> fields[$this -> sort_field]['table']]['main_field'] . '';
			else
				$sort_field = '' . $this -> table . '.' . $this -> sort_field . '';
			
			$query_fields = array(); $query_joins = array(); $query_binds = array();
			foreach ( $select_fields as $select_field )
			{
				if ( $this -> fields[$select_field]['type'] == 'table' )
				{
					$query_fields[] = '' . $this -> fields[$select_field]['table'] .
						'.' . metadata::$tables[$this -> fields[$select_field]['table']]['primary_field'] .
						' as _' . $select_field . '';
					$query_fields[] = '' . $this -> fields[$select_field]['table'] .
						'.' . metadata::$tables[$this -> fields[$select_field]['table']]['main_field'] .
						' as ' . $select_field . '';
					$query_joins[] = 'left join ' . $this -> fields[$select_field]['table'] .
						' on ' . $this -> fields[$select_field]['table'] .
						'.' . metadata::$tables[$this -> fields[$select_field]['table']]['primary_field'] .
						' = ' . $this -> table . '.' . $select_field . '';
				}
				else if ( $this -> fields[$select_field]['type'] == 'select' )
				{
					$case_items = array( 'case ' . $this -> table . '.' . $select_field . '' );
					for ( $i = 0; $i < count( $this -> fields[$select_field]['values'] ); $i++ )
					{
						$case_items[] = 'when :' . $select_field . '_value_' . $i . ' then :' . $select_field . '_title_' . $i;
						$query_binds[$select_field . '_value_' . $i] = $this -> fields[$select_field]['values'][$i]['value'];
						$query_binds[$select_field . '_title_' . $i] = $this -> fields[$select_field]['values'][$i]['title'];
					}
					$case_items[] = 'else \'\' end';
					
					$query_fields[] = '' . $this -> table . '.' . $select_field . ' as _' . $select_field . '';
					$query_fields[] = join( ' ', $case_items ) . ' as ' . $select_field . '';
				}
				else
				{
					$query_fields[] = '' . $this -> table . '.' . $select_field . '';
				}
			}
			
			$query = 'select ' . join( ', ', $query_fields ) . ' from ' . $this -> table . ' ' .join( ' ', $query_joins ) . ' ' .
				$this -> filter_clause . ' order by ' . $sort_field . ' ' . $this -> sort_order . ' ' . $this -> limit_clause;
			
			return db::select_all( $query, $this -> filter_binds + $query_binds );
		}
		
		public function get_table_records( $table, $except = array() )
		{
			$table_object = table::factory( $table );
			
			$table_object -> sort_field = $table_object -> main_field;
			$table_object -> sort_order = 'asc';
			
			$table_records = $table_object -> get_records();
			
			if ( $table_object -> parent_field )
				$table_records = tree::get_tree( $table_records,
					$table_object -> primary_field, $table_object -> parent_field, 0, $except );
			
			$result_records = array();
			foreach ( $table_records as $table_record )
				$result_records[] = array(
					'value' => (string) $table_record[$table_object -> primary_field],
					'title' => ( mb_strlen( $table_record[$table_object -> main_field], 'utf-8' ) > 50 ) ?
						mb_substr( $table_record[$table_object -> main_field], 0, 50, 'utf-8' ) . '...' :
							$table_record[$table_object -> main_field],
					'_depth' => isset( $table_record['_depth'] ) ? $table_record['_depth'] : '' );
			
			return $result_records;
		}
		
		protected function get_records_count()
		{
			$query = 'select count(*) as _count from ' . $this -> table . ' ' . $this -> filter_clause;
			$records_count = db::select( $query, $this -> filter_binds );
			
			return $records_count['_count'];
		}
		
		protected function get_table_actions()
		{
			$actions = array();
			$prev_url = $this -> encode_object( $_GET );
			
			if ( $this -> is_action_allow( 'add' ) )
				$actions['add'] = array( 'title' => 'Добавить', 'url' =>
					get_url( array( 'object' => $this -> table, 'action' => 'add', 'prev_url' => $prev_url ) ) );
			
			return $actions;
		}
		
		protected function get_table_headers()
		{
			$records_header = array();
			foreach ( $this -> links as $link_name => $link_desc )
				if ( !isset( $link_desc['hidden'] ) || !$link_desc['hidden'] )
					$records_header[$link_name] = array( 'title' => isset( $link_desc['title'] ) ? $link_desc['title'] :
						( isset( metadata::$tables[$link_desc['table']]['title'] ) ?
							metadata::$tables[$link_desc['table']]['title'] : '' ), 'type' => '_link' );
			foreach ( $this -> relations as $relation_name => $relation_desc )
				$records_header[$relation_name] = array( 'title' => isset( $relation_desc['title'] ) ? $relation_desc['title'] :
					( isset( metadata::$tables[$relation_desc['secondary_table']]['title'] ) ?
						metadata::$tables[$relation_desc['secondary_table']]['title'] : '' ), 'type' => '_link' );
			return $records_header;
		}
		
		protected function get_record_actions( $record )
		{
			$actions = array();
			$prev_url = $this -> encode_object( $_GET );
			
			if ( $this -> parent_field && $this -> is_action_allow( 'add' ) )
			{
				$card_url = $this -> encode_object( array( $this -> parent_field => $record[$this -> primary_field] ) );
				$actions['add'] = array( 'title' => 'Добавить', 'url' =>
					get_url( array( 'object' => $this -> table, 'action' => 'add',
					'card_url' => $card_url, 'prev_url' => $prev_url ) ) );
			}
			if ( $this -> is_action_allow( 'edit' ) )
				$actions['edit'] = array( 'title' => 'Редактировать', 'url' =>
					get_url( array( 'object' => $this -> table, 'action' => 'edit',
						$this -> primary_field => $record[$this -> primary_field], 'prev_url' => $prev_url ) ) );
			if ( $this -> is_action_allow( 'add' ) )
				$actions['copy'] = array( 'title' => 'Копировать', 'url' =>
					get_url( array( 'object' => $this -> table, 'action' => 'copy',
						$this -> primary_field => $record[$this -> primary_field], 'prev_url' => $prev_url ) ) );
			if ( $this -> order_field && $this -> is_action_allow( 'edit' ) )
				$actions['move'] = array( 'title' => 'Поднять наверх', 'url' =>
					get_url( array( 'object' => $this -> table, 'action' => 'move',
						$this -> primary_field => $record[$this -> primary_field], 'prev_url' => $prev_url ) ) );
			if ( $this -> active_field && $this -> is_action_allow( 'edit' ) )
			{
				if ( !$record[$this -> active_field] )
					$actions['show'] = array( 'title' => 'Показать', 'url' =>
						get_url( array( 'object' => $this -> table, 'action' => 'show',
							$this -> primary_field => $record[$this -> primary_field], 'prev_url' => $prev_url ) ) );
				else
					$actions['hide'] = array( 'title' => 'Скрыть', 'url' =>
						get_url( array( 'object' => $this -> table, 'action' => 'hide',
							$this -> primary_field => $record[$this -> primary_field], 'prev_url' => $prev_url ) ) );
			}
			if ( $this -> is_action_allow( 'delete' ) )
				$actions['delete'] = array( 'title' => 'Удалить', 'url' =>
					get_url( array( 'object' => $this -> table, 'action' => 'delete',
						$this -> primary_field => $record[$this -> primary_field], 'prev_url' => $prev_url ) ),
					'event' => array( 'method' => 'onclick', 'value' => 'return confirm( \'Вы действительно хотите удалить эту запись?\' )' ) );
			
			$actions['separator'] = array();
			
			return $actions;
		}
		
		protected function get_record_links( $record )
		{
			if ( !count( $this -> links ) )
				return array();
			
			$links = array();
			
			foreach ( $this -> links as $link_name => $link_desc )
			{
				if ( isset( $link_desc['hidden'] ) && $link_desc['hidden'] ) continue;
				
				$show_link = true;
				if ( isset( $link_desc['show'] ) && is_array( $link_desc['show'] ) )
				{
					foreach ( $link_desc['show'] as $show_field_name => $show_field_values )
					{
						if ( $this -> fields[$show_field_name]['type'] == 'select' ||
								$this -> fields[$show_field_name]['type'] == 'table' )
							$show_field_name = '_' . $show_field_name;
						$show_link &= in_array( $record[$show_field_name], $show_field_values );
					}
				}
				
				if ( !$show_link ) continue;
				
				$links[$link_name] = array( 'title' => 'Перейти',
					'url' => get_url( array( 'object' => $link_desc['table'], $link_desc['field'] => $record[$this -> primary_field] ) ) );
			}
			
			return $links;
		}
		
		protected function get_record_relations( $record )
		{
			if ( !count( $this -> relations ) )
				return array();
			
			$prev_url = $this -> encode_object( $_GET );
			
			$relations = array();
			foreach ( $this -> relations as $relation_name => $relation_desc )
				$relations[$relation_name] = array( 'title' => 'Перейти',
					'url' => get_url( array( 'object' => $this -> table, 'action' => 'relation', 'relation' => $relation_name,
						$this -> primary_field => $record[$this -> primary_field], 'prev_url' => $prev_url ) ) );
			
			return $relations;
		}
		
		protected function get_filter()
		{
			if ( !count( $this -> filter_fields ) )
				return '';
			
			$search_fields = array();
			
			foreach ( $this -> filter_fields as $field_name )
			{
				$search_fields[$field_name] = $this -> fields[$field_name];
				$search_fields[$field_name]['value'] = field::form_field(
					init_string( $field_name ), $this -> fields[$field_name]['type'] );
				
				if ( $this -> fields[$field_name]['type'] == 'select' )
					$search_fields[$field_name]['values'] = $this -> fields[$field_name]['values'];
				if ( $this -> fields[$field_name]['type'] == 'table' )
					$search_fields[$field_name]['values'] = $this -> get_table_records( $this -> fields[$field_name]['table'] );
			}
			
			$hidden_fields = make_hidden( $_GET, array_merge( array_keys( $search_fields ), array( 'page' ) ) );
			
			$tpl = new SmartyAdmin();
			
			$tpl -> assign( 'fields', $search_fields );
			$tpl -> assign( 'hidden', $hidden_fields );
			
			return $tpl -> fetch( 'filter.tpl' );
		}
		
		protected function get_group_conds( $record, $field_name )
		{
			$group_conds = array(); $group_binds = array();
			
			if ( isset( $this -> fields[$field_name]['group'] ) )
			{
				foreach ( $this -> fields[$field_name]['group'] as $group_field_name )
				{
					$group_conds[] = '' . $group_field_name . ' = :' . $group_field_name;
					$group_binds[$group_field_name] = $record[$group_field_name];
				}
			}
			
			return array( $group_conds, $group_binds );
		}
		
		protected function check_group_unique( $record, $primary_field = '' )
		{
			foreach ( $this -> fields as $field_name => $field_desc )
			{
				if ( !isset( $this -> fields[$field_name]['group'] ) ||
						$field_desc['type'] == 'order' || $field_desc['type'] == 'default' )
					continue;
				
				list( $group_conds, $group_binds ) =
					$this -> get_group_conds( $record, $field_name );
				
				$group_conds[] = '' . $field_name . ' = :' . $field_name;
				$group_binds[$field_name] = $record[$field_name];
				
				if ( $primary_field )
				{
					$group_conds[] = '' . $this -> primary_field . ' <> :' . $this -> primary_field;
					$group_binds[$this -> primary_field] = $primary_field;
				}
				
				$query = 'select count(*) as _count from ' . $this -> table . '
					where ' . join( ' and ', $group_conds );
				
				$records_count = db::select( $query, $group_binds );
				
				if ( $records_count['_count'] )
					throw new Exception( 'Ошибка. Запись не удовлетворяет условию группировки.' );
			}
		}
		
		protected function clear_default_fields( $record )
		{
			foreach ( $this -> fields as $field_name => $field_desc )
			{
				if ( $field_desc['type'] == 'default' && $record[$field_name] )
				{
					$group_where = array();
					if ( isset( $field_desc['group'] ) )
						foreach ( $field_desc['group'] as $group_field_name )
							$group_where[$group_field_name] = $record[$group_field_name];
					
					db::update( $this -> table, array( $field_name => 0 ), $group_where );
				}
			}
		}
		
		protected function get_next_order( $order_conds, $order_binds )
		{
			$order_clause = count( $order_conds ) ? 'where ' . join( ' and ', $order_conds ) : '';
			
			$query = 'select max( ' . $this -> order_field . ' ) as _max_order
				from ' . $this -> table . ' ' . $order_clause;
			$max_record = db::select( $query, $order_binds );
			
			return $max_record['_max_order'] + 1;
		}
		
		protected function get_prev_order_record( $order_conds, $order_binds, $record )
		{
			$order_conds[] = '' . $this -> order_field . ' < :' . $this -> order_field;
			$order_binds[$this -> order_field] = $record[$this -> order_field];
			
			$order_clause = count( $order_conds ) ? 'where ' . join( ' and ', $order_conds ) : '';
			
			$query = 'select * from ' . $this -> table . ' ' . $order_clause . '
				order by ' . $this -> order_field . ' desc limit 1';
			
			return db::select( $query, $order_binds );
		}
		
		protected function get_record( $primary_field = '' )
		{
			if ( $primary_field === '' )
				$primary_field = init_string( $this -> primary_field );
			
			$query = 'select * from ' . $this -> table . ' where ' . $this -> primary_field . ' = :primary_field';
			$record = db::select( $query, array( 'primary_field' => $primary_field ) );
			
			if ( !$record )
				throw new Exception( 'Ошибка. Запись не найдена.' );
			
			foreach ( $this -> fields as $field_name => $field_desc )
			{
				if ( isset( $field_desc['translate'] ) && $field_desc['translate'] )
				{
					$translate_values = db::select_all( '
							select lang.lang_id, translate.record_value
							from translate left join lang on lang.lang_id = translate.record_lang
							where table_name = :table_name and field_name = :field_name and table_record = :table_record
							order by lang.lang_default desc',
						array( 'table_name' => $this -> table, 'field_name' => $field_name, 'table_record' => $primary_field ) );
					
					$record[$field_name] = array();
					foreach ( $translate_values as $translate_value )
						$record[$field_name][$translate_value['lang_id']] = $translate_value['record_value'];
				}
			}
			
			return $record;
		}
		
		protected function record_card( $action = 'edit' )
		{
			if ( $action == 'edit' || $action == 'copy' )
				$record = $this -> get_record();
			
			$action_save = $action . '_save';
			
			$form_fields = array();
			$query_params = array_merge(
				$this -> decode_object( init_string( 'prev_url' ) ),
				$this -> decode_object( init_string( 'card_url' ) ) );
			
			foreach ( $this -> fields as $field_name => $field_desc )
			{
				if ( $field_desc['type'] != 'pk' && $field_desc['type'] != 'order' &&
					!( ( $action == 'add' || $action == 'copy' ) && isset( $field_desc['no_add'] ) && $field_desc['no_add'] ||
						$action == 'edit' && isset( $field_desc['no_edit'] ) && $field_desc['no_edit'] ) )
				{
					$form_fields[$field_name] = $field_desc;
					
					if ( $action == 'edit' || $action == 'copy' )
						$form_fields[$field_name]['value'] = field::form_field(
							$record[$field_name], $field_desc['type'] );
					
					if ( $action == 'add' && isset( $query_params[$field_name] ) &&
							( $field_desc['type'] == 'parent' || $field_desc['type'] == 'table' || $field_desc['type'] == 'select' ) )
						$form_fields[$field_name]['value'] = field::form_field(
							$query_params[$field_name], $field_desc['type'] );
					
					if ( $action == 'add' && isset( $field_desc['default'] ) &&
							( $field_desc['type'] == 'string' || $field_desc['type'] == 'text' ||
								$field_desc['type'] == 'int' || $field_desc['type'] == 'float' ) )
						$form_fields[$field_name]['value'] = field::form_field(
							$field_desc['default'], $field_desc['type'] );
					
					if ( $field_desc['type'] == 'select' )
						$form_fields[$field_name]['values'] = $field_desc['values'];
					if ( $field_desc['type'] == 'table' )
						$form_fields[$field_name]['values'] = $this -> get_table_records( $field_desc['table'] );
					if ( $field_desc['type'] == 'parent' )
					{
						$except = $action == 'edit' ? array( $record[$this -> primary_field] ) : array();
						$form_fields[$field_name]['values'] = $this -> get_table_records( $this -> table, $except );
					}
					
					$form_fields[$field_name]['require'] = $form_fields[$field_name]['errors_code'] & field::$errors['require'];
				}
			}
			
			if ( count( $form_fields ) == 0 )
				throw new Exception( 'Ошибка. Нет полей, доступных для изменения.' );
			
			$hidden_fields = make_hidden( array_merge( $_GET, array( 'action' => $action . '_save' ) ) );
			
			$record_title = ( $action != 'add' ) ? field::get_field(
				$record[$this -> main_field], $this -> fields[$this -> main_field]['type'] ) : '';
			if ( ( $action != 'add' ) && isset( $this -> fields[$this -> main_field]['translate'] ) &&
					$this -> fields[$this -> main_field]['translate'] )
				$record_title = current( $record_title );
			
			switch ( $action )
			{
				case 'edit': $action_title = 'Редактирование записи'; break;
				case 'copy': $action_title = 'Копирование записи'; break;
				default: $action_title = 'Добавление записи';
			}
			
			if ( $action == 'copy' && $this -> fields[$this -> main_field]['type'] == 'string' )
			{
				if ( isset( $this -> fields[$this -> main_field]['translate'] ) && $this -> fields[$this -> main_field]['translate'] )
					foreach ( $form_fields[$this -> main_field]['value'] as $field_name => $field_value )
						$form_fields[$this -> main_field]['value'][$field_name] = $field_value . ' (копия)';
				else
					$form_fields[$this -> main_field]['value'] = $form_fields[$this -> main_field]['value'] . ' (копия)';
			}
			
			$tpl = new SmartyAdmin();
			
			$tpl -> assign( 'lang_list', $this -> lang_list );
			$tpl -> assign( 'record_title', metadata::$tables[$this -> table]['title'] . ( $record_title ? ' :: ' . $record_title : '' ) );
			$tpl -> assign( 'action_title', $action_title );
			$tpl -> assign( 'fields', $form_fields );
			$tpl -> assign( 'hidden', $hidden_fields );
			
			$back_url = get_url( $this -> decode_object( init_string( 'prev_url' ) ) );
			$tpl -> assign( 'back_url', $back_url );
			
			$this -> title = $this -> title . ( $record_title ? ' :: ' . $record_title : '' ) . ' :: ' . $action_title;
			
			$this -> content = $tpl -> fetch( 'form.tpl' );
		}
		
		protected function redirect()
		{
			header( 'Location: ' . get_url( $this -> decode_object( init_string( 'prev_url' ) ), array(), '', '&' ) ); exit;
		}
		
		protected function encode_object( $obj )
		{
			return base64_encode( serialize( $obj ) );
		}
		
		protected function decode_object( $url )
		{
			$obj = @unserialize( base64_decode( $url ) );
			return $obj === false ? array() : $obj;
		}
		
		protected function upload_file( $field_name, $field_desc )
		{
			if ( isset( $_FILES[$field_name . '_file']['name'] ) && $_FILES[$field_name . '_file']['name'] )
				return upload::upload_file( $_FILES[$field_name . '_file'], $field_desc['upload_dir'] );
			else
				return init_string( $field_name );
		}
		
		protected function is_action_allow( $action, $throw = false )
		{
			$action_allow = !isset( metadata::$tables[$this -> table]['no_' . $action] ) ||
				!metadata::$tables[$this -> table]['no_' . $action];
			
			if ( !$action_allow && $throw )
				throw new Exception( 'Ошибка. Данная операция с таблицей "' . metadata::$tables[$this -> table]['title'] . '" запрещена.' );
			
			return $action_allow;
		}
		
		protected function change_translate_record( $primary_field, $translate_values )
		{
			foreach ( $translate_values as $field_name => $field_values )
			{
				$translate_record = array( 'table_name' => $this -> table, 'field_name' => $field_name, 'table_record' => $primary_field );
				
				db::delete( 'translate', $translate_record );
				
				foreach ( $field_values as $record_lang => $record_value )
				{
					$translate_record['record_lang'] = $record_lang;
					$translate_record['record_value'] = $record_value;
					
					db::insert( 'translate', $translate_record );
				}
			}
		}
	}
?>
