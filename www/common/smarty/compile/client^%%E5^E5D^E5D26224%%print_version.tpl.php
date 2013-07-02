<?php /* Smarty version 2.6.22, created on 2009-09-03 15:31:23
         compiled from module/price/print_version.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/price/print_version.tpl', 21, false),)), $this); ?>
<div class="print_version">
	<table class="print_head">
		<tr>
			<td class="left">
				&nbsp;
			</td>
			<td class="center">
				<h1>Прайс-лист</h1>
			</td>
			<td class="right">
				<input type="button" class="button" value="Закрыть" onclick="window.close()"/>
				<input type="button" class="button" value="Печать" onclick="window.print()"/>
			</td>
		</tr>
	</table>

	<table class="price_list">
	<?php $_from = $this->_tpl_vars['price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['price_item']):
?>
		<tr>
			<td colspan="3" class="catalogue">
				<?php echo ((is_array($_tmp=$this->_tpl_vars['price_item']['catalogue_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 
			</td>
		</tr>
	<?php $_from = $this->_tpl_vars['price_item']['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_item']):
        $this->_foreach['products']['iteration']++;
?>
		<tr class="<?php if ((1 & $this->_foreach['products']['iteration'])): ?>selected<?php endif; ?>">
			<td>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['product_item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 
			</td>
			<td>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['product_item']['brand_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 
			</td>
			<td>
				<?php echo $this->_tpl_vars['product_item']['product_price']; ?>

			</td>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
	<?php endforeach; endif; unset($_from); ?>
	</table>
</div>