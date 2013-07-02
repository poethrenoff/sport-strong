<?php /* Smarty version 2.6.22, created on 2013-02-24 10:16:18
         compiled from path.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'path.tpl', 3, false),)), $this); ?>
<!--noindex--><div class="crumbs">
<?php $_from = $this->_tpl_vars['path']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['path'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['path']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['path']['iteration']++;
?>
<?php if ($this->_tpl_vars['item']['url']): ?><a href="<?php echo $this->_tpl_vars['item']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a><?php else: ?><span><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span><?php endif; ?><?php if (! ($this->_foreach['path']['iteration'] == $this->_foreach['path']['total'])): ?> / <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</div><!--/noindex-->