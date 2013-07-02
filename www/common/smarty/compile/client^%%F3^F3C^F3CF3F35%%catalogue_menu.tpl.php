<?php /* Smarty version 2.6.22, created on 2012-09-04 09:24:40
         compiled from module/catalogue/catalogue_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/catalogue/catalogue_menu.tpl', 5, false),)), $this); ?>
<div>
<?php $_from = $this->_tpl_vars['catalogue_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<?php if ($this->_tpl_vars['item']['_depth']): ?>
	<div class="menu_category">
		<a href="<?php echo $this->_tpl_vars['item']['catalogue_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['catalogue_short_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
	</div>
<?php else: ?>
	</div>
	<div class="menu_group">
		<a href="<?php echo $this->_tpl_vars['item']['catalogue_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['catalogue_short_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
	
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</div>