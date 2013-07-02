<?php /* Smarty version 2.6.22, created on 2013-01-30 10:00:30
         compiled from module/catalogue/catalogue_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/catalogue/catalogue_list.tpl', 1, false),)), $this); ?>
<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['catalogue_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>

<table class="catalogue_list">
<?php $_from = $this->_tpl_vars['catalogue_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['catalogue_table'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['catalogue_table']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['row']):
        $this->_foreach['catalogue_table']['iteration']++;
?>
	<tr>
<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<td style="width: <?php echo $this->_tpl_vars['table_cell_width']; ?>
%"<?php if (($this->_foreach['catalogue_table']['iteration'] == $this->_foreach['catalogue_table']['total'])): ?> class="last"<?php endif; ?>>
<?php if ($this->_tpl_vars['item']): ?>
			<b><a href="<?php echo $this->_tpl_vars['item']['catalogue_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['catalogue_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></b><br/><br/>
			<a href="<?php echo $this->_tpl_vars['item']['catalogue_url']; ?>
"><img src="<?php echo $this->_tpl_vars['item']['catalogue_picture']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['catalogue_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="product"/></a>
<?php else: ?>
			&nbsp;
<?php endif; ?>
		</td>
<?php endforeach; endif; unset($_from); ?>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<div>
	<?php echo $this->_tpl_vars['catalogue_description']; ?>

</div>

<?php if ($this->_tpl_vars['pages']): ?>
<div class="pages">
	Страницы: <?php echo $this->_tpl_vars['pages']; ?>

</div>
<?php endif; ?>