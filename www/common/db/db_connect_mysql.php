<?
	class db_connect_mysql extends db_connect
	{
		protected function __construct()
		{
			parent::__construct();
			
			$this -> query( 'set names utf8' );
			$this -> query( 'set character set utf8' );
		}
		
		public function create()
		{
			$sql = "<pre>\n";
			
			foreach ( metadata::$tables as $table_name => $table_desc )
			{
				$sql .= "drop table if exists {$table_name};\n";
				$sql .= "create table {$table_name} (\n";
				
				$fields = array(); $pk_field = '';
				foreach ( $table_desc['fields'] as $field_name => $field_desc )
				{
					switch ( $field_desc['type'] )
					{
						case 'pk': $type = "int(11) unsigned not null auto_increment"; $pk_field = $field_name; break;
						case 'string': case 'select': case 'image': case 'file': case 'password':
							$type = "varchar(255) not null default ''"; break;
						case 'date': case 'datetime': $type = "varchar(14) not null default ''"; break;
						case 'text': $type = "text not null default ''"; break;
						case 'int': $type = "int(11) default '0'"; break;
						case 'float': $type = "double default '0'"; break;
						case 'active': case 'boolean': case 'order':
						case 'default': case 'table': case 'parent':
							$type = "int(11) unsigned not null default '0'"; break;
						default: $type = "error";
					}
					$fields[] = "\t{$field_name} {$type}";
				}
				if ( $pk_field )
					$fields[] = "\tprimary key ({$pk_field})";
				
				$sql .= join( ",\n", $fields ) . "\n";
				$sql .= ") engine=MyISAM default charset=utf8;\n\n";
			}
			
			$system_map_order = 1;
			foreach ( metadata::$tables as $table_name => $table_desc )
				if ( !isset( $table_desc['internal'] ) || !$table_desc['internal'] )
					$sql .= "insert into system_map ( system_map_title, system_map_object, system_map_order, system_map_active ) values( '" . $table_desc['title'] . "', '" . $table_name . "', '" . $system_map_order++ . "', '1' );\n";
			foreach ( metadata::$tools as $tool_name => $tool_desc )
				$sql .= "insert into system_map ( system_map_title, system_map_object, system_map_order, system_map_active ) values( '" . $tool_desc['title'] . "', '" . $tool_name . "', '" . $system_map_order++ . "', '1' );\n";
			
			$sql .= "</pre>\n";
			
			print $sql;
			
			exit;
		}
	}
?>