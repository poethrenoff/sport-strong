<?
	class SmartyAdmin extends SmartyEx
	{
		function SmartyAdmin()
		{
			$this -> SmartyEx();
			
			$this -> template_dir = $_SERVER['DOCUMENT_ROOT'] . '/admin/template/';
			
	        $this -> compile_id = 'admin';
		}
	}
?>
