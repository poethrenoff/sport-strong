<?
	include $_SERVER['DOCUMENT_ROOT'] . '/common/common.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/smarty.php';
	
	include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/metadata.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/table.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/tool.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/admin/include/field.php';
	
	function pages( $page_cnt, $page_cur, $tpl_path = 'pages.tpl' )
	{
		$pages = array(); $link_cnt = 10;
		$first_page = max( 0, min( $page_cnt - $link_cnt , $page_cur - $link_cnt / 2 ) );
		$last_page = min( max( $link_cnt, $page_cur + $link_cnt / 2 ), $page_cnt );
		
		if ( $first_page > 0 )
			$pages[] = array( 'num' => '1', 'url' => get_request_url( array( 'page' => 0 ) ) );
		if ( $first_page > 1 )
			$pages[] = array( 'num' => '...', 'url' => get_request_url( array( 'page' => $first_page - 1 ) ) );
		
		for ( $p = $first_page; $p < $last_page; $p++ )
			$pages[] = array( 'num' => $p + 1, 'url' => $p != $page_cur ? get_request_url( array( 'page' => $p ) ) : '' );
		
		if ( $last_page < $page_cnt - 1 )
			$pages[] = array( 'num' => '...', 'url' => get_request_url( array( 'page' => $last_page ) ) );
		if ( $last_page < $page_cnt )
			$pages[] = array( 'num' => $page_cnt, 'url' => get_request_url( array( 'page' => $page_cnt - 1 ) ) );
		
		$page_tpl = new SmartyAdmin();
		$page_tpl -> assign( 'pages', $pages );
		
		return $page_tpl -> fetch( $tpl_path );
	}
	
	class prebuild
	{
		public static function prepare_metadata()
		{
			foreach ( metadata::$tables as $table_name => $table_desc )
			{
				if ( isset( $table_desc['links'] ) && is_array( $table_desc['links'] ) )
					foreach ( $table_desc['links'] as $link_name => $link_desc )
					{
						if ( !isset( $link_desc['table'] ) || !$link_desc['table'] ||
								!isset( metadata::$tables[$link_desc['table']] ) || !metadata::$tables[$link_desc['table']] )
							throw new Exception( 'Ошибка в описании связи таблиц "' . $table_name . '.' . $link_name . '". Ошибка при задании целевой таблицы.' );
						if ( !isset( $link_desc['field'] ) || !$link_desc['field'] ||
								!isset( metadata::$tables[$link_desc['table']]['fields'][$link_desc['field']]['type'] ) ||
									metadata::$tables[$link_desc['table']]['fields'][$link_desc['field']]['type'] !== 'table' ||
								!isset( metadata::$tables[$link_desc['table']]['fields'][$link_desc['field']]['table'] ) ||
									metadata::$tables[$link_desc['table']]['fields'][$link_desc['field']]['table'] != $table_name )
							throw new Exception( 'Ошибка в описании связи таблиц "' . $table_name . '.' . $link_name . '". Ошибка при задании целевого поля.' );
						
						if ( isset( $link_desc['show'] ) && is_array( $link_desc['show'] ) )
							foreach ( $link_desc['show'] as $show_field_name => $show_field_values )
								if ( !isset( metadata::$tables[$table_name]['fields'][$show_field_name] ) )
									throw new Exception( 'Ошибка в описании связи таблиц "' . $table_name . '.' . $link_name . '". Ошибка при задании целевого поля в опции "show".' );
						
						if ( isset( metadata::$tables[$link_desc['table']]['internal'] ) && metadata::$tables[$link_desc['table']]['internal'] )
							metadata::$tables[$table_name]['links'][$link_name]['hidden'] = 1;
						
						if ( !isset( $link_desc['hidden'] ) || $link_desc['hidden'] )
							metadata::$tables[$link_desc['table']]['fields'][$link_desc['field']]['filter'] = 1;
					}
				
				if ( isset( $table_desc['relations'] ) && is_array( $table_desc['relations'] ) )
					foreach ( $table_desc['relations'] as $relation_name => $relation_desc )
					{
						if ( !isset( $relation_desc['secondary_table'] ) || !$relation_desc['secondary_table'] ||
								!isset( metadata::$tables[$relation_desc['secondary_table']] ) || !metadata::$tables[$relation_desc['secondary_table']] )
							throw new Exception( 'Ошибка в описании отношения таблиц "' . $table_name . '.' . $relation_name . '". Ошибка при задании вторичной таблицы.' );
						if ( !isset( $relation_desc['relation_table'] ) || !$relation_desc['relation_table'] ||
								!isset( metadata::$tables[$relation_desc['relation_table']] ) || !metadata::$tables[$relation_desc['relation_table']] )
							throw new Exception( 'Ошибка в описании отношения таблиц "' . $table_name . '.' . $relation_name . '". Ошибка при задании связующей таблицы.' );
						
						if ( !isset( $relation_desc['primary_field'] ) || !$relation_desc['primary_field'] ||
								!isset( metadata::$tables[$relation_desc['relation_table']]['fields'][$relation_desc['primary_field']]['type'] ) ||
									metadata::$tables[$relation_desc['relation_table']]['fields'][$relation_desc['primary_field']]['type'] !== 'table' ||
								!isset( metadata::$tables[$relation_desc['relation_table']]['fields'][$relation_desc['primary_field']]['table'] ) ||
									metadata::$tables[$relation_desc['relation_table']]['fields'][$relation_desc['primary_field']]['table'] != $table_name )
							throw new Exception( 'Ошибка в описании отношения таблиц "' . $table_name . '.' . $relation_name . '". Ошибка при задании первичного поля связующей таблицы.' );
						if ( !isset( $relation_desc['secondary_field'] ) || !$relation_desc['secondary_field'] ||
								!isset( metadata::$tables[$relation_desc['relation_table']]['fields'][$relation_desc['secondary_field']]['type'] ) ||
									metadata::$tables[$relation_desc['relation_table']]['fields'][$relation_desc['secondary_field']]['type'] !== 'table' ||
								!isset( metadata::$tables[$relation_desc['relation_table']]['fields'][$relation_desc['secondary_field']]['table'] ) ||
									metadata::$tables[$relation_desc['relation_table']]['fields'][$relation_desc['secondary_field']]['table'] != $relation_desc['secondary_table'] )
							throw new Exception( 'Ошибка в описании отношения таблиц "' . $table_name . '.' . $relation_name . '". Ошибка при задании вторичного поля связующей таблицы.' );
						
						metadata::$tables[$relation_desc['secondary_table']]['links'][$table_name] =
							array( 'table' => $relation_desc['relation_table'], 'field' => $relation_desc['secondary_field'],
								'hidden' => 1, 'ondelete' => 'cascade' );
					}
			}
			
			foreach ( metadata::$tables as $table_name => $table_desc )
			{
				if ( isset( $table_desc['internal'] ) && $table_desc['internal'] ) continue;
			
				if ( isset( $table_desc['fields'] ) )
					foreach ( $table_desc['fields'] as $field_name => $field_desc )
					{
					    if ( !isset( $field_desc['type'] ) || !$field_desc['type'] )
							throw new Exception( 'Ошибка в описании поля "' . $table_name . '.' . $field_name . '". Не задан тип поля.' );
					
						if ( $field_desc['type'] == 'pk' )
							metadata::$tables[$table_name]['primary_field'] = $field_name;
						if ( $field_desc['type'] == 'parent' )
							metadata::$tables[$table_name]['parent_field'] = $field_name;
						if ( $field_desc['type'] == 'active' )
							metadata::$tables[$table_name]['active_field'] = $field_name;
						if ( $field_desc['type'] == 'order' )
							metadata::$tables[$table_name]['order_field'] = $field_name;
						if ( isset( $field_desc['main'] ) && $field_desc['main'] &&
								$field_desc['type'] != 'pk' && $field_desc['type'] != 'parent' &&
								$field_desc['type'] != 'active' && $field_desc['type'] != 'order' &&
								$field_desc['type'] != 'default' )
							metadata::$tables[$table_name]['main_field'] = $field_name;
						
						if ( ( isset( $field_desc['show'] ) && $field_desc['show'] ||
								isset( $field_desc['main'] ) && $field_desc['main'] ) &&
								$field_desc['type'] != 'pk' && $field_desc['type'] != 'parent' &&
								$field_desc['type'] != 'image' && $field_desc['type'] != 'file' &&
								$field_desc['type'] != 'active' && $field_desc['type'] != 'order' )
							metadata::$tables[$table_name]['show_fields'][] = $field_name;
						if ( ( isset( $field_desc['filter'] ) && $field_desc['filter'] ||
								isset( $field_desc['main'] ) && $field_desc['main'] || $field_desc['type'] == 'active' ) &&
								$field_desc['type'] != 'pk' && $field_desc['type'] != 'parent' &&
								$field_desc['type'] != 'order' && $field_desc['type'] != 'default' &&
								$field_desc['type'] != 'date' && $field_desc['type'] != 'datetime' )
							metadata::$tables[$table_name]['filter_fields'][] = $field_name;
						if ( isset( $field_desc['sort'] ) &&
								( isset( $field_desc['show'] ) && $field_desc['show'] || isset( $field_desc['main'] ) &&
								$field_desc['main'] ) && $field_desc['type'] != 'pk' && $field_desc['type'] != 'parent' &&
								$field_desc['type'] != 'active' && $field_desc['type'] != 'default' )
						{
							metadata::$tables[$table_name]['sort_field'] = $field_name;
							metadata::$tables[$table_name]['sort_order'] = $field_desc['sort'] == 'desc' ? 'desc' : 'asc'; 
						}
						
						if ( $field_desc['type'] == 'table' &&
								( !( isset( $field_desc['table'] ) && isset( metadata::$tables[$field_desc['table']] ) ) ||
									( isset( metadata::$tables[$field_desc['table']]['internal'] ) && metadata::$tables[$field_desc['table']]['internal'] ) ) )
							throw new Exception( 'Ошибка в описании поля "' . $table_name . '.' . $field_name . '". Ошибка при задании целевой таблицы.' );
						if ( $field_desc['type'] == 'select' &&
								( !isset( $field_desc['values'] ) || !is_array( $field_desc['values'] ) || !count( $field_desc['values'] ) ) )
							throw new Exception( 'Ошибка в описании поля "' . $table_name . '.' . $field_name . '". Ошибка при задании списка значений поля типа "select".' );
							
						if ( isset( $field_desc['group'] ) )
						{
							if ( !is_array( $field_desc['group'] ) )
								throw new Exception( 'Ошибка в описании поля "' . $table_name . '.' . $field_name . '". Ошибка при задании целевого поля в опции "group".' );
							foreach ( $field_desc['group'] as $group_field_name )
								if ( $group_field_name == $field_name ||
										!isset( $table_desc['fields'][$group_field_name] ) ||
										$table_desc['fields'][$group_field_name]['type'] == 'pk' ||
										$table_desc['fields'][$group_field_name]['type'] == 'active' ||
										$table_desc['fields'][$group_field_name]['type'] == 'order' ||
										$table_desc['fields'][$group_field_name]['type'] == 'default' )
									throw new Exception( 'Ошибка в описании поля "' . $table_name . '.' . $field_name . '". Ошибка при задании целевого поля в опции "group".' );
						}
						
						if ( ( $field_desc['type'] == 'image' || $field_desc['type'] == 'file' ) &&
								!( isset( $field_desc['upload_dir'] ) && $field_desc['upload_dir'] ) )
							throw new Exception( 'Ошибка в описании поля "' . $table_name . '.' . $field_name . '". Не задан каталог для закачки файлов.' );
						
						$errors_code = isset( $field_desc['errors'] ) && $field_desc['errors'] ?
							field::get_errors_code( $field_desc['errors'] ) : 0;
						
						if ( $field_desc['type'] == 'pk' )
							$errors_code |= field::$errors['require'] | field::$errors['int'];
						if ( $field_desc['type'] == 'parent' ||
								$field_desc['type'] == 'order' || $field_desc['type'] == 'table' )
							$errors_code |= field::$errors['int'];
						if ( $field_desc['type'] == 'date' )
							$errors_code |= field::$errors['date'];
						if ( $field_desc['type'] == 'datetime' )
							$errors_code |= field::$errors['datetime'];
						if ( $field_desc['type'] == 'order' )
							$errors_code |= field::$errors['require'];
						if ( $field_desc['type'] == 'int' )
							$errors_code |= field::$errors['int'];
						if ( $field_desc['type'] == 'float' )
							$errors_code |= field::$errors['float'];
						if ( $field_desc['type'] == 'password' )
							$errors_code |= field::$errors['alpha'];
						
						metadata::$tables[$table_name]['fields'][$field_name]['errors_code'] = $errors_code;
						metadata::$tables[$table_name]['fields'][$field_name]['errors'] = field::get_errors_value( $errors_code );
						
						if ( $field_desc['type'] == 'table' )
						{
							$link_show = false;
							if ( isset( metadata::$tables[$field_desc['table']]['links'] ) &&
									is_array( metadata::$tables[$field_desc['table']]['links'] ) )
								foreach ( metadata::$tables[$field_desc['table']]['links'] as $link_name => $link_desc )
									if ( $link_desc['table'] == $table_name )
										$link_show = true;
							
							if ( !$link_show )
								metadata::$tables[$field_desc['table']]['links'][$table_name] =
									array( 'table' => $table_name, 'field' => $field_name, 'hidden' => 1 ) +
										( !( $errors_code & field::$errors['require'] ) ? array( 'ondelete' => 'set_null' ): array() );
						}
						
						if ( isset( $field_desc['translate'] ) && $field_desc['translate'] &&
								!( $field_desc['type'] == 'string' || $field_desc['type'] == 'text' ) )
							throw new Exception( 'Ошибка в описании поля "' . $table_name . '.' . $field_name . '". Переводимыми могут быть только поля типа string и text.' );
					}
				
				if ( !( isset( metadata::$tables[$table_name]['primary_field'] ) && metadata::$tables[$table_name]['primary_field'] ) )
					throw new Exception( 'Ошибка в описании таблицы "' . $table_name . '". Отсутствует ключевое поле.' );
				if ( !( isset( metadata::$tables[$table_name]['main_field'] ) && metadata::$tables[$table_name]['main_field'] ) )
					throw new Exception( 'Ошибка в описании таблицы "' . $table_name . '". Отсутствует главное поле.' );
				
				if ( isset( metadata::$tables[$table_name]['order_field'] ) && metadata::$tables[$table_name]['order_field'] )
				{
					metadata::$tables[$table_name]['sort_field'] = metadata::$tables[$table_name]['order_field'];
					metadata::$tables[$table_name]['sort_order'] = 'asc'; 
				}
				else if ( !( isset( metadata::$tables[$table_name]['sort_field'] ) && metadata::$tables[$table_name]['sort_field'] ) &&
					isset( metadata::$tables[$table_name]['main_field'] ) && metadata::$tables[$table_name]['main_field'] )
				{
					metadata::$tables[$table_name]['sort_field'] = metadata::$tables[$table_name]['main_field'];
					metadata::$tables[$table_name]['sort_order'] = 'asc'; 
				}
				
				if ( isset( metadata::$tables[$table_name]['class'] ) && metadata::$tables[$table_name]['class'] )
				{
					$class_file = $_SERVER['DOCUMENT_ROOT'] . '/admin/include/class/' . metadata::$tables[$table_name]['class'] . '.php';
					if ( !file_exists( $class_file ) )
						throw new Exception( 'Ошибка в описании таблицы "' . $table_name . '". Не найден файл "' . $class_file . '".' );
				}
			}
			
			foreach ( metadata::$tools as $tool_name => $tool_desc )
			{
				if ( isset( metadata::$tools[$tool_name]['class'] ) && metadata::$tools[$tool_name]['class'] )
				{
					$class_file = $_SERVER['DOCUMENT_ROOT'] . '/admin/include/class/' . metadata::$tools[$tool_name]['class'] . '.php';
					if ( !file_exists( $class_file ) )
						throw new Exception( 'Ошибка в описании утилиты "' . $tool_name . '". Не найден файл "' . $class_file . '".' );
				}
				else
					throw new Exception( 'Ошибка в описании утилиты "' . $tool_name . '". Не указан класс объекта.' );
			}
		}
	}
	
	prebuild::prepare_metadata();
	
	// db::create();
?>
