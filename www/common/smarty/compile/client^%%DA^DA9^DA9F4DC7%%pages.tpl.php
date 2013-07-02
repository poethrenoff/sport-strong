<?php /* Smarty version 2.6.22, created on 2012-09-04 14:49:37
         compiled from pages.tpl */ ?>
<?php if ($this->_tpl_vars['pages']): ?>
<div class="paginav">
            	<div class="navig">
					&larr; 
					<?php if ($this->_tpl_vars['page_first'] != 1): ?><a href="?page=<?php echo $this->_tpl_vars['page']-1; ?>
">предыдущая</a><?php else: ?>предыдущая<?php endif; ?> &nbsp; &nbsp; 
					<?php if ($this->_tpl_vars['page_last'] != 1): ?><a href="?page=<?php echo $this->_tpl_vars['page']+1; ?>
">следующая</a><?php else: ?>следующая<?php endif; ?> &rarr;					
				</div>
                <div id="dk">
	<?php $_from = $this->_tpl_vars['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pages'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pages']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['page']):
        $this->_foreach['pages']['iteration']++;
?>
	<?php if ($this->_tpl_vars['page']['url']): ?>
		<a  class="dl" href="<?php echo $this->_tpl_vars['page']['url']; ?>
"><?php echo $this->_tpl_vars['page']['num']; ?>
</a>
	<?php else: ?>
		<b class="dm"><?php echo $this->_tpl_vars['page']['num']; ?>
</b>
	<?php endif; ?>
	<?php if (! ($this->_foreach['pages']['iteration'] == $this->_foreach['pages']['total'])): ?> 

	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
                </div>
            </div>	
<?php endif; ?>