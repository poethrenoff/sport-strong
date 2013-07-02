<?
	class fm extends tool
	{
		protected $upload_path = '/upload/';
	
		protected $real_upload_path = '/upload/';
	
		protected $records_per_page = 30;
		
		protected $sort_field = 'name';
		
		protected $sort_order = 'asc';
		
		protected function __construct( $tool )
		{
			parent::__construct( $tool );
			
			$this -> real_upload_path = realpath( $_SERVER['DOCUMENT_ROOT'] . $this -> upload_path ) . DIRECTORY_SEPARATOR;
		}
		
		protected function action_tool()
		{
			if( !file_exists( $this -> real_upload_path ) )
				if ( !( @mkdir( $this -> real_upload_path , 0777, true ) ) )
					throw new Exception( 'Ошибка. Невозможно создать каталог "' . $this -> real_upload_path . '".' );
			
			if( !is_readable( $this -> real_upload_path ) )
				throw new Exception( 'Ошибка. Невозможно прочитать каталог "' . $this -> real_upload_path . '".' );
			
			$sort_field = init_string( 'sort_field' );
			$sort_order = init_string( 'sort_order' );
			if ( $sort_field && in_array( $sort_field, array( 'name', 'size', 'date' ) ) )
				$this -> sort_field = $sort_field;
			if ( $sort_order && in_array( $sort_order, array( 'asc', 'desc' ) ) )
				$this -> sort_order = $sort_order;
			
			$records_header['_index'] = array( 'title' => 'ID' );
			$records_header['name'] = array( 'title' => 'Название', 'type' => 'string', 'main' => 1 );
			$records_header['size'] = array( 'title' => 'Размер', 'type' => 'int' );
			$records_header['date'] = array( 'title' => 'Дата', 'type' => 'datetime' );
			$records_header['_action'] = array( 'title' => 'Действия' );
			
			foreach( array( 'name', 'size', 'date' ) as $show_field )
			{
				$field_sort_order = $show_field == $this -> sort_field && $this -> sort_order == 'asc' ? 'desc' : 'asc';
				$records_header[$show_field]['sort_url'] =
					get_request_url( array( 'sort_field' => $show_field, 'sort_order' => $field_sort_order ), array( 'page' ) );
				if ( $show_field == $this -> sort_field )
					$records_header[$show_field]['sort_sign'] = $field_sort_order == 'asc' ? 'desc' : 'asc';
			}
			
			$prev_url = $this -> encode_object( $_GET );
			$upload_dir = opendir( $this -> real_upload_path );
			
			$file_list = array();
			while ( ( $file = readdir( $upload_dir ) ) !== false )
			{
				$real_file_path = $this -> real_upload_path . $file;
				if ( is_file( $real_file_path ) )
					$file_list[] = array( 'name' => '<a href="' . $this -> upload_path . $file . '">' . $file . '</a>',
						'size' => filesize( $real_file_path ), 'date' => str_replace( ' ', '&nbsp;', date( 'd.m.Y H:i', filemtime( $real_file_path ) ) ),
						'_action' => array(	'delete' => array( 'title' => 'Удалить', 'url' =>
							get_url( array( 'object' => 'fm', 'action' => 'delete',
								'file' => urlencode( $file ), 'prev_url' => $prev_url ) ),
							'event' => array( 'method' => 'onclick', 'value' => 'return confirm( \'Вы действительно хотите удалить этот файл?\' )' ) ) ) );
			}
			closedir( $upload_dir );
			
			usort( $file_list, array( $this, 'sort_file_list' ) );
			
			foreach ( $file_list as $file_index => $file_item )
				$file_list[$file_index]['_index'] = $file_index + 1;
			
			$records_count = count( $file_list );
			
			if ( $records_count > $this -> records_per_page )
			{
				$first_page = 0; $last_page = max( floor( ( $records_count - 1 ) / $this -> records_per_page ), 0 );
				$page = min( max( intval( init_string( 'page' ) ), $first_page ), $last_page );
				
				foreach ( $file_list as $file_index => $file_item )
					if ( $file_index < $page * $this -> records_per_page ||
							$file_index >= ( $page + 1 ) * $this -> records_per_page )
						unset( $file_list[$file_index] );
			}
			
			$actions = array( 'add' => array( 'title' => 'Закачать файл', 'url' =>
				get_url( array( 'object' => $this -> tool, 'action' => 'upload', 'prev_url' => $prev_url ) ) ) );
			
			$tpl = new SmartyAdmin();
			
			$tpl -> assign( 'title', $this -> title );
			$tpl -> assign( 'actions', $actions );
			$tpl -> assign( 'records', $file_list );
			$tpl -> assign( 'header', $records_header );
			$tpl -> assign( 'counter', $records_count );
			
			if ( $records_count > $this -> records_per_page )
				$tpl -> assign( 'pages', pages( $last_page + 1, $page ) );
			
			$this -> content = $tpl -> fetch( 'table.tpl' );
		}
		
		protected function action_delete()
		{
			$file = init_string( 'file' );
			
			$real_file_path = $this -> real_upload_path . $file;

			if( $real_file_path != realpath( $real_file_path ) )
				throw new Exception( 'Ошибка. Недопустимое имя файла "' . $real_file_path . '".' );
			
			if( !file_exists( $real_file_path ) || !is_file( $real_file_path ) )
				throw new Exception( 'Ошибка. Файл "' . $real_file_path . '" не существует.' );
			
			@unlink( $real_file_path );
		
			if ( file_exists( $real_file_path ) )
				throw new Exception( 'Ошибка. Невозможно удалить файл "' . $real_file_path . '".' );
		
			$this -> redirect();
		}
		
		protected function action_upload()
		{
			$action = 'upload'; $action_save = $action . '_save';
			
			$form_fields = array();
			$query_params = $this -> decode_object( init_string( 'prev_url' ) );
			
			$hidden_fields = make_hidden( array_merge( $_GET, array( 'action' => $action_save ) ) );
			
			$action_title = 'Закачка файла';
			
			$tpl = new SmartyAdmin();
			
			$tpl -> assign( 'record_title', $this -> title );
			$tpl -> assign( 'action_title', $action_title );
			$tpl -> assign( 'hidden', $hidden_fields );
			
			$back_url = get_url( $this -> decode_object( init_string( 'prev_url' ) ) );
			$tpl -> assign( 'back_url', $back_url );
			
			$this -> title = $this -> title . ' :: ' . $action_title;
			
			$this -> content = $tpl -> fetch( 'class/fm/upload.tpl' );
		}
		
		protected function action_upload_save()
		{
			$field_name = 'file';
					
			if ( isset( $_FILES[$field_name . '_file']['name'] ) && $_FILES[$field_name . '_file']['name'] )
				upload::upload_file( $_FILES[$field_name . '_file'], $this -> upload_path );
			else
				throw new Exception( 'Ошибка. Отсутствует файл для закачки.' );
			
			$this -> redirect();
		}
		
		protected function redirect()
		{
			header( 'Location: ' . get_url( $this -> decode_object( init_string( 'prev_url' ) ), array(), '', '&' ) ); exit;
		}
		
		protected function encode_object( $obj )
		{
			return urlencode( base64_encode( serialize( $obj ) ) );
		}
		
		protected function decode_object( $url )
		{
			$obj = @unserialize( base64_decode( $url ) );
			return $obj === false ? array() : $obj;
		}
	
		private function sort_file_list( $a, $b )
		{
			if ( $this -> sort_field == 'size' )
				$result = strnatcmp( $a[ $this -> sort_field ], $b[ $this -> sort_field ] );
			else
				$result = strcmp( $a[ $this -> sort_field ], $b[ $this -> sort_field ] );
			return ( ( $this -> sort_order == 'asc' ) ? 1 : -1 ) * $result;
		}
	}
?>
