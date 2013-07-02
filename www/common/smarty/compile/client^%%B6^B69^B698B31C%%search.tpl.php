<?php /* Smarty version 2.6.22, created on 2012-09-04 11:34:14
         compiled from module/search/search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/search/search.tpl', 2, false),)), $this); ?>
<?php if ($this->_tpl_vars['search_value']): ?>
<h2>Результаты поиска: <b><?php echo ((is_array($_tmp=$this->_tpl_vars['search_value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</b> (<?php echo $this->_tpl_vars['search_count']; ?>
)</h2><br/><br/>
<?php if ($this->_tpl_vars['search_list']): ?>
<table class="search_list">
<?php $_from = $this->_tpl_vars['search_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	<tr>
		<td class="counter">
			<?php echo $this->_tpl_vars['item']['search_index']; ?>
.
		</td>
		<td>
			<a href="<?php echo $this->_tpl_vars['item']['product_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
		</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<?php if ($this->_tpl_vars['pages']): ?>
<div class="pages">
	Страницы: <?php echo $this->_tpl_vars['pages']; ?>

</div>
<?php endif; ?>
<?php else: ?>
<p class="p">
	<b>По Вашему запросу ничего не найдено, обратитесь к менеджеру по телефону <?php echo $this->_tpl_vars['manager_phone']; ?>
 или e-mail: <a href="mailto:<?php echo $this->_tpl_vars['admin_email']; ?>
"><?php echo $this->_tpl_vars['admin_email']; ?>
</a>.</b>
</p>
<?php endif; ?>
<?php endif; ?>