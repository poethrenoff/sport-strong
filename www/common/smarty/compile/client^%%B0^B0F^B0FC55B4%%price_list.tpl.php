<?php /* Smarty version 2.6.22, created on 2009-09-03 15:30:28
         compiled from module/price/price_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/price/price_list.tpl', 24, false),)), $this); ?>
<h1>Прайс-лист</h1><br/><br/>

<script type="text/javascript">
	function fnOpenWindow( sUrl )
	{
		iWidth = screen.width * 0.8, iHeight = screen.height * 0.6, iPosX = screen.width / 2 - iWidth / 2, iPosY = screen.height / 2 - iHeight / 2;
		oWin = window.open( sUrl, 'oWindow', 'left=' + iPosX + ', top=' + iPosY + ', width=' + iWidth + ', height=' + iHeight + ', toolbar=0, status=0, menubar=0, resizable=1, scrollbars=1' );
		oWin.focus();
	}
</script>

<a name="top"></a>

<form action="/price.php" method="get">
	<table class="price_filter">
		<tr>
			<td class="catalogue">
				Каталог:
			</td>
			<td class="catalogue_select">
				<select name="catalogue_id">
					<option value=""/>
<?php $_from = $this->_tpl_vars['catalogue_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['catalogue_item']):
?>
					<option value="<?php echo $this->_tpl_vars['catalogue_item']['catalogue_id']; ?>
"<?php if ($this->_tpl_vars['catalogue_item']['_selected']): ?> selected="selected"<?php endif; ?>><?php unset($this->_sections['offset']);
$this->_sections['offset']['name'] = 'offset';
$this->_sections['offset']['start'] = (int)0;
$this->_sections['offset']['loop'] = is_array($_loop=$this->_tpl_vars['catalogue_item']['_depth']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['offset']['show'] = true;
$this->_sections['offset']['max'] = $this->_sections['offset']['loop'];
$this->_sections['offset']['step'] = 1;
if ($this->_sections['offset']['start'] < 0)
    $this->_sections['offset']['start'] = max($this->_sections['offset']['step'] > 0 ? 0 : -1, $this->_sections['offset']['loop'] + $this->_sections['offset']['start']);
else
    $this->_sections['offset']['start'] = min($this->_sections['offset']['start'], $this->_sections['offset']['step'] > 0 ? $this->_sections['offset']['loop'] : $this->_sections['offset']['loop']-1);
if ($this->_sections['offset']['show']) {
    $this->_sections['offset']['total'] = min(ceil(($this->_sections['offset']['step'] > 0 ? $this->_sections['offset']['loop'] - $this->_sections['offset']['start'] : $this->_sections['offset']['start']+1)/abs($this->_sections['offset']['step'])), $this->_sections['offset']['max']);
    if ($this->_sections['offset']['total'] == 0)
        $this->_sections['offset']['show'] = false;
} else
    $this->_sections['offset']['total'] = 0;
if ($this->_sections['offset']['show']):

            for ($this->_sections['offset']['index'] = $this->_sections['offset']['start'], $this->_sections['offset']['iteration'] = 1;
                 $this->_sections['offset']['iteration'] <= $this->_sections['offset']['total'];
                 $this->_sections['offset']['index'] += $this->_sections['offset']['step'], $this->_sections['offset']['iteration']++):
$this->_sections['offset']['rownum'] = $this->_sections['offset']['iteration'];
$this->_sections['offset']['index_prev'] = $this->_sections['offset']['index'] - $this->_sections['offset']['step'];
$this->_sections['offset']['index_next'] = $this->_sections['offset']['index'] + $this->_sections['offset']['step'];
$this->_sections['offset']['first']      = ($this->_sections['offset']['iteration'] == 1);
$this->_sections['offset']['last']       = ($this->_sections['offset']['iteration'] == $this->_sections['offset']['total']);
?>&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['catalogue_item']['catalogue_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</option>
<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
			<td class="show">
<?php $_from = $this->_tpl_vars['hidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
				<input type="hidden" name="<?php echo $this->_tpl_vars['name']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
"/>
<?php endforeach; endif; unset($_from); ?>
				<input type="submit" class="button show" value="Показать"/>
				<input type="button" class="button print" value="Версия для печати" onclick="fnOpenWindow( '<?php echo $this->_tpl_vars['print_url']; ?>
' )"/>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="sort">
				<noindex>
					Сортировка:
<?php $_from = $this->_tpl_vars['sort_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<a href="<?php echo $this->_tpl_vars['item']['sort_url']; ?>
"><?php echo $this->_tpl_vars['item']['sort_title']; ?>
</a><?php if ($this->_tpl_vars['item']['sort_sign']): ?> <img src="/image/design/<?php echo $this->_tpl_vars['item']['sort_sign']; ?>
.gif" alt=""/><?php endif; ?> 
<?php endforeach; endif; unset($_from); ?>
				</noindex>
			</td>
		</tr>
	</table>
</form>

<table class="price_list">
<?php $_from = $this->_tpl_vars['price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['price_item']):
?>
	<tr>
		<td colspan="3" class="catalogue">
			<a href="<?php echo $this->_tpl_vars['price_item']['catalogue_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['price_item']['catalogue_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
		</td>
	</tr>
<?php $_from = $this->_tpl_vars['price_item']['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_item']):
        $this->_foreach['products']['iteration']++;
?>
	<tr class="<?php if ((1 & $this->_foreach['products']['iteration'])): ?>selected<?php endif; ?>">
		<td class="title">
			<a href="<?php echo $this->_tpl_vars['product_item']['product_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['product_item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
		</td>
		<td class="brand">
			<?php echo ((is_array($_tmp=$this->_tpl_vars['product_item']['brand_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 
		</td>
		<td class="price">
			<?php echo $this->_tpl_vars['product_item']['product_price']; ?>
 
		</td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>
</table>

<table class="price_nav">
	<tr>
		<td class="up">
			<a href="#top">Наверх</a>
		</td>
		<td class="print">
			<input type="button" class="button" value="Версия для печати" onclick="fnOpenWindow( '<?php echo $this->_tpl_vars['print_url']; ?>
' )"/>
		</td>
	</tr>
</table>