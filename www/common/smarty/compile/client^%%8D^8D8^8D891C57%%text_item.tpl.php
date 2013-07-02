<?php /* Smarty version 2.6.22, created on 2009-08-31 14:50:36
         compiled from module/text/text_item.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/text/text_item.tpl', 2, false),)), $this); ?>
<?php if ($this->_tpl_vars['text_title']): ?>
<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['text_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>
<?php endif; ?>
<?php if ($this->_tpl_vars['text_content']): ?>
<?php echo $this->_tpl_vars['text_content']; ?>

<?php endif; ?>