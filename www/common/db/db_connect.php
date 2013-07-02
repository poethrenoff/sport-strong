<?
	abstract class db_connect
	{
		protected $dbh = null;
		
		protected function __construct()
		{
			try {
				$this -> dbh = new PDO( DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME,
					DB_USER, DB_PASS, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ) );
			}
			catch ( PDOException $e ) {
				die( "<center>" . $e -> getMessage() . "<center>" );
			}
		}
		
		public static function factory()
		{
			$driver_name = 'db_connect_' . DB_TYPE;
			$driver_file = $_SERVER['DOCUMENT_ROOT'] . '/common/db/' . $driver_name . '.php';
			if ( !file_exists( $driver_file ) )
				throw new Exception( 'Ошибка. Не найден файл "' . $driver_file . '".' );
			
			include_once $driver_file;
			
			return new $driver_name();
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////
		
		protected function execute( $query, $fields = array() )
		{
			$sth = $this -> dbh -> prepare( $query );
			
			foreach ( $fields as $name => $value )
				$sth -> bindValue( ":" . $name, $value );
			$sth -> execute();
			
			return $sth;
		}
		
		public function query( $query, $fields = array() )
		{
			$this -> execute( $query, $fields );
		}
		
		public function select( $query, $fields = array() )
		{
			return $this -> execute( $query, $fields ) -> fetch( PDO::FETCH_ASSOC );
		}
		
		public function select_all( $query, $fields = array() )
		{
			return $this -> execute( $query, $fields ) -> fetchAll( PDO::FETCH_ASSOC );
		}
		
		public function select_cell( $query, $fields = array() )
		{
			return $this -> execute( $query, $fields ) -> fetchColumn( 0 );
		}
		
		public function insert( $table, $fields = array() )
		{
			$columns = array(); $values = array();
			foreach ( $fields as $name => $value )
			{
				$columns[] = "{$name}"; $values[] = ":$name";
			}
			$columns = join( ", ", $columns );
			$values = join( ", ", $values );
			
			$query = "insert into {$table} ( {$columns} ) values ( {$values} )";
			
			return $this -> execute( $query, $fields ) -> rowCount();
		}
		
		public function update( $table, $fields = array(), $where = array() )
		{
			$pairs = array();
			foreach ( $fields as $name => $value )
				$pairs[] = "{$name} = :{$name}";
			$pairs = join( ", ", $pairs );
			
			$conds = array();
			foreach( $where as $name => $value)
			{
				$conds[] = "{$name} = :conds_{$name}";
				$fields["conds_" . $name] = $value;
			}
			$conds = join( " and ", $conds );
			
			$query = "update {$table} set {$pairs}" . ( $conds ? " where " : " " ) . $conds;
			
			return $this -> execute( $query, $fields ) -> rowCount();
		}
		
		public function delete( $table, $where = array() )
		{
			$conds = array(); $fields = array();
			foreach( $where as $name => $value )
			{
				$conds[] = "{$name} = :conds_{$name}";
				$fields["conds_" . $name] = $value;
			}
			$conds = join(" and ", $conds);
			
			$query = "delete from {$table}" . ( $conds ? " where " : " " ) . $conds;
			
			return $this -> execute( $query, $fields ) -> rowCount();
		}
		
		public function last_insert_id()
		{
			return $this -> dbh -> lastInsertId();
		}
		
		public function create()
		{
			return $this -> dbh -> create();
		}
	}
?>