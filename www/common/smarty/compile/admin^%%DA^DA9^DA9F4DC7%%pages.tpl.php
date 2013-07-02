<?php /* Smarty version 2.6.22, created on 2009-08-31 15:07:16
         compiled from pages.tpl */ ?>
<?php $_from = $this->_tpl_vars['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pages'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pages']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['page']):
        $this->_foreach['pages']['iteration']++;
?><?php if ($this->_tpl_vars['page']['url']): ?><a href="<?php echo $this->_tpl_vars['page']['url']; ?>
"><?php echo $this->_tpl_vars['page']['num']; ?>
</a><?php else: ?><b><?php echo $this->_tpl_vars['page']['num']; ?>
</b><?php endif; ?><?php if (! ($this->_foreach['pages']['iteration'] == $this->_foreach['pages']['total'])): ?> <?php endif; ?><?php endforeach; endif; unset($_from); ?>