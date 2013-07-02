<?
	abstract class module
	{
		// Объект шаблона модуля
		protected $tpl = null;
		
		// Содержимое документа
		protected $content = '';
		
		// Набор метатегов модуля
		protected $meta = array();
		
		// Путь до раздела
		protected $path = array( array( 'title' => 'Главная', 'url' => '/' ) );
		
		// Параметры представления модуля
		protected $params = array();
		
		// Признак нахождения модуля в главной области
		protected $main_area = false;
		
		/////////////////////////////////////////////////////////////////////////////////////
		
		// Создание экземпляра модуля
		public static function factory( $module )
		{
			$module_file = $_SERVER['DOCUMENT_ROOT'] . '/include/module/' . $module . '.php';
			if ( !file_exists( $module_file ) )
				throw new Exception( 'Ошибка. Не найден файл "' . $module_file . '".' );
			
			include_once $module_file;
			
			return new $module();
		}
		
		// Инициализация модуля
		public final function init( $params = array(), $main_area = false )
		{
			foreach ( $params as $param_name => $param_value )
				$this -> params[$param_name] = $param_value;
			
			$this -> tpl = new SmartyClient();
			
			$this -> main_area = $main_area;
			
			$this -> dispatcher();
		}
		
		// Заполнение контента модуля
		abstract protected function dispatcher();
		
		// Возвращает содержимое документа
		public function get_content()
		{
			return $this -> content;
		}
		
		// Возвращает набор метатегов модуля
		public function get_meta()
		{
			return $this -> meta;
		}
		
		// Возвращает путь до раздела
		public function get_path()
		{
			$path_tpl = new SmartyClient();
			$path_tpl -> assign( 'path', $this -> path );
			
			return $path_tpl -> fetch( 'path.tpl' );
		}
		
		////////////////////////////////////////////////////////////////////////
		
		// Возврашает значение параметра по его имени 
		public function get_param( $varname, $vardef = '' )
        {
			if ( isset( $this -> params[$varname] ) )
				return $this -> params[$varname];
			else
				return init_string( $varname, $vardef );
        }
        
		// Извлекает набор метатегов модуля из базы
		protected function read_meta( $module = '', $content = '' )
		{
			if ( !$this -> main_area ) return array();
			
			$metatags = db::select( '
					select meta_title as title, meta_keywords as keywords, meta_description as description, page_top, page_bottom
					from meta where meta_module = :module and meta_content = :content',
				array( 'module' => $module, 'content' => $content ) );
			
			if ( $metatags )
				return $metatags;
			else if ( $module != '' && $content != '' )
				return $this -> read_meta( $module );
			else if ( $module != '' )
				return $this -> read_meta();
			
			return array();
		}
	}
?>
