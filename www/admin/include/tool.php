<?
	class tool
	{
		protected $tool = '';
		
		protected $title = '';
		
		protected $content = '';
		
		//////////////////////////////////////////////////////////////////////////
		
		protected function __construct( $tool )
		{
			$this -> tool = $tool;
			
			$this -> title = metadata::$tools[$this -> tool]['title'];
		}
		
		public static function factory( $tool )
		{
			if ( !isset( metadata::$tools[$tool] ) )
				throw new Exception( 'Ошибка. Объект "' . $tool . '" не описан в метаданных.' );
            
			if ( isset( metadata::$tools[$tool]['class'] ) && metadata::$tools[$tool]['class'] )
			{
				$class_name = metadata::$tools[$tool]['class'];
				include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/include/class/' . $class_name . '.php';
				return new $class_name( $tool );
			}
			else
				return new tool( $tool );
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
			$method_name = 'action_' . init_string( 'action', 'tool' );
			
			if ( method_exists( $this, $method_name ) )
				$this -> $method_name();
		}
	}
?>
