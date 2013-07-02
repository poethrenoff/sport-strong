<?
	include $_SERVER['DOCUMENT_ROOT'] . '/common/db/db_connect.php';
	
	abstract class db
	{
		private static $db_connect = null;
		
		private static function get_connect()
		{
			if ( self::$db_connect == null )
				self::$db_connect = db_connect::factory();
			
			return self::$db_connect;
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////
		
		public static function query( $query, $fields = array() )
		{
			return self::get_connect() -> query( $query, $fields );
		}
		
		public static function select( $query, $fields = array() )
		{
			return self::get_connect() -> select( $query, $fields );
		}
		
		public static function select_all( $query, $fields = array() )
		{
			return self::get_connect() -> select_all( $query, $fields );
		}
		
		public static function insert( $table, $fields = array() )
		{
			return self::get_connect() -> insert( $table, $fields );
		}
		
		public static function update( $table, $fields = array(), $where = array() )
		{
			return self::get_connect() -> update( $table, $fields, $where );
		}
		
		public static function delete( $table, $where = array() )
		{
			return self::get_connect() -> delete( $table, $where );
		}
		
		public static function last_insert_id()
		{
			return self::get_connect() -> last_insert_id();
		}
		
		public static function create()
		{
			return self::get_connect() -> create();
		}
	}
?>