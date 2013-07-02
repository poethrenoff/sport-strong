<?php /* Smarty version 2.6.22, created on 2009-09-03 15:31:23
         compiled from print.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'print.tpl', 4, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
	<head>
		<title><?php echo ((is_array($_tmp=$this->_tpl_vars['meta']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</title>
		<link rel="stylesheet" href="/style/index.css" type="text/css"/>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="keywords" content="<?php echo ((is_array($_tmp=$this->_tpl_vars['meta']['keywords'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
	   	<meta name="description" content="<?php echo ((is_array($_tmp=$this->_tpl_vars['meta']['description'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
	</head>
	<body>
<?php echo $this->_tpl_vars['content']; ?>
 
	</body>
</html>