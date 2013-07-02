<?
	class SmartyClient extends SmartyEx
	{
		function SmartyClient()
		{
			$this -> SmartyEx();
			
			$this -> template_dir = $_SERVER['DOCUMENT_ROOT'] . '/template/';
			
	        $this -> compile_id = 'client';
		}
	}
?>
