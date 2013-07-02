<?php /* Smarty version 2.6.22, created on 2013-02-06 15:17:31
         compiled from error.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
	<head>
		<title>Ошибка!!!</title>
		<link rel="stylesheet" href="/style/index.css" type="text/css"/>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body>
<?php if ($this->_tpl_vars['error']): ?>
		<div class="error"><?php echo $this->_tpl_vars['error']; ?>
</div>
<?php endif; ?>
	</body>
</html>