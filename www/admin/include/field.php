<?
	class field
	{
		public static $errors = array(
			'require' => 1, 'int' => 2, 'float' => 4, 'date' => 8, 'datetime' => 16, 'email' => 32, 'alpha' => 64
		);
		
		public static function get_errors_code( $errors_string = '' )
		{
			$errors_code = 0;
			foreach ( explode( '|', $errors_string ) as $error_name )
				if ( isset( self::$errors[$error_name] ) )
					$errors_code |= self::$errors[$error_name];
			return $errors_code;
		}
		
		public static function get_errors_value( $errors_code = 0 )
		{
			$errors_value = array();
			foreach( self::$errors as $error_name => $error_code )
				if ( $errors_code & $error_code )
					$errors_value[] = $error_name;
			return join( '|', $errors_value );
		}
		
		///////////////////////////////////////////////////////////////////////////
		
		public static function get_field( $content, $type )
		{
			$get_method = 'get_' . $type;
			
			if ( is_array( $content ) )
				foreach( $content as $item_id => $item )
					$content[$item_id] = self::get_field( $item, $type );
			else
				$content = self::$get_method( $content );
			
			return $content;
		}
		
		public static function get_string( $content )
		{
			return htmlspecialchars( $content, ENT_QUOTES );
		}
		
		public static function get_text( $content )
		{
			return self::get_string( ( mb_strlen( $content, 'utf-8' ) > 80 ) ? mb_substr( $content, 0, 80, 'utf-8' ) . '...' : $content );
		}
		
		public static function get_boolean( $content )
		{
			return $content ? 'да' : 'нет';
		}
		
		public static function get_default( $content )
		{
			return self::get_boolean( $content );
		}
		
		public static function get_date( $content )
		{
			return preg_replace( '/\s+/', '&nbsp;', get_date( $content, 'short' ) );
		}
		
		public static function get_datetime( $content )
		{
			return preg_replace( '/\s+/', '&nbsp;', get_date( $content, 'long' ) );
		}
		
		public static function get_image( $content )
		{
			return self::get_string( $content );
		}
		
		public static function get_file( $content )
		{
			return self::get_string( $content );
		}
		
		public static function get_int( $content )
		{
			return self::get_string( $content );
		}
		
		public static function get_float( $content )
		{
			return self::get_string( $content );
		}
		
		public static function get_select( $content )
		{
			return self::get_string( $content );
		}
		
		public static function get_table( $content )
		{
			return self::get_string( $content );
		}
		
		public static function get_password( $content )
		{
			return str_repeat( '*', rand( 5, 8 ) );
		}
		
		///////////////////////////////////////////////////////////////////////////
		
		public static function form_field( $content, $type )
		{
			$form_method = 'form_' . $type;
			
			if ( is_array( $content ) )
				foreach( $content as $item_id => $item )
					$content[$item_id] = self::form_field( $item, $type );
			else
				$content = self::$form_method( $content );
			
			return $content;
		}
		
		public static function form_string( $content )
		{
			return htmlspecialchars( $content, ENT_QUOTES );
		}
		
		public static function form_text( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_boolean( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_active( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_default( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_date( $content )
		{
			return get_date( $content, 'short' );
		}
		
		public static function form_datetime( $content )
		{
			return get_date( $content, 'long' );
		}
		
		public static function form_image( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_file( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_int( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_float( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_select( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_table( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_parent( $content )
		{
			return self::form_string( $content );
		}
		
		public static function form_password( $content )
		{
			return '';
		}
		
		///////////////////////////////////////////////////////////////////////////
		
		public static function check_field( $content, $type )
		{
			$check_method = 'check_' . $type;
			return self::$check_method( $content );
		}
		
		public static function check_require( $content )
		{
			return ( trim( $content ) !== '' );
		}
		
		public static function check_int( $content )
		{
			return ( $content === '' || preg_match( '/^\-?\+?\d+$/', $content ) );
		}
		
		public static function check_float( $content )
		{
			return ( $content === '' || preg_match( '/^\-?\+?\d+[\.,]?\d*$/', $content ) );
		}
		
		public static function check_date( $content )
		{
			return ( $content === '' || ( 
				preg_match( '/^(\d{2})\.(\d{2})\.(\d{4})$/', $content, $match ) && 
				checkdate ( $match[2], $match[1], $match[3] ) ) );
		}
		
		public static function check_datetime( $content )
		{
			return ( $content === '' || ( 
				preg_match( '/^(\d{2})\.(\d{2})\.(\d{4}) (\d{2})\:(\d{2})$/', $content, $match ) && 
				checkdate ( $match[2], $match[1], $match[3] ) &&
					( $match[4] >= 0 && $match[4] <= 23 && $match[5] >= 0 && $match[5] <= 59 ) ) );
		}
		
		public static function check_email( $content )
		{
			return ( $content === '' || preg_match( '/^[a-z0-9_\.-]+@[a-z0-9_\.-]+\.[a-z]{2,}$/i', $content ) );
		}
		
		public static function check_alpha( $content )
		{
			return ( $content === '' || preg_match( '/^[a-z0-9_]+$/i', $content ) );
		}
		
		///////////////////////////////////////////////////////////////////////////
		
		public static function set_field( $content, $field_desc )
		{
			$set_method = 'set_' . $field_desc['type'];
			
			if ( is_array( $content ) )
				foreach( $content as $item_id => $item )
					$content[$item_id] = self::set_field( $item, $field_desc );
			else
			{
				foreach( self::$errors as $error_name => $error_code )
					if ( $field_desc['errors_code'] & $error_code )
						if ( !self::check_field( $content, $error_name ) )
							throw new Exception( 'Ошибочное значение поля "' . $field_desc['title'] . '".' );
				
				$content = self::$set_method( $content );
			}
			
			return $content;
		}
		
		public static function set_string( $content )
		{
			return $content;
		}
		
		public static function set_text( $content )
		{
			return self::set_string( $content );
		}
		
		public static function set_boolean( $content )
		{
			return strval( $content ? 1 : 0 );
		}
		
		public static function set_active( $content )
		{
			return self::set_boolean( $content );
		}
		
		public static function set_default( $content )
		{
			return self::set_boolean( $content );
		}
		
		public static function set_date( $content )
		{
			return set_date( $content, 'short' );
		}
		
		public static function set_datetime( $content )
		{
			return set_date( $content, 'long' );
		}
		
		public static function set_image( $content )
		{
			return self::set_string( $content );
		}
		
		public static function set_file( $content )
		{
			return self::set_string( $content );
		}
		
		public static function set_int( $content )
		{
			return $content !== '' ? strval( intval( $content ) ) : null;
		}
		
		public static function set_float( $content )
		{
			return $content !== '' ? str_replace( ',', '.', $content ) : null;
		}
		
		public static function set_select( $content )
		{
			return self::set_string( $content );
		}
		
		public static function set_table( $content )
		{
			return strval( intval( $content ) );
		}
		
		public static function set_parent( $content )
		{
			return strval( intval( $content ) );
		}
		
		public static function set_order( $content )
		{
			return strval( intval( $content ) );
		}
		
		public static function set_password( $content )
		{
			return md5( $content );
		}
	}
?>
