<?php /* Smarty version 2.6.22, created on 2013-06-26 15:40:09
         compiled from module/catalogue/product_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/catalogue/product_list.tpl', 19, false),)), $this); ?>
<script type="text/javascript" src="http://yandex.st/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript"><?php echo '
	jQuery(function(){
		jQuery(\'div.brands a\').click(function(){
			jQuery(\'#filter_form\').find(\'input[name="product_brand"]\').val($(this).attr(\'value\'));
			
			jQuery(\'#filter_form\').submit();
			return false;
		});
	});
	
	'; ?>

</script>
<?php if ($this->_tpl_vars['no_item_catalog']): ?>
<div style="margin:20px;">
<span >В данном разделе товар отсутствует.</span>
</div>
<?php else: ?>
<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['catalogue_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>
<?php if ($this->_tpl_vars['catalogue_description_top']): ?>
<div style="margin-bottom: 10px">
	<?php echo $this->_tpl_vars['catalogue_description_top']; ?>

</div>
<?php endif; ?>

<!--noindex---><div class="brands">
	<table><tr>
<?php $_from = $this->_tpl_vars['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['brand_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brand_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['brand_list']['iteration']++;
?>
<?php if (( $this->_foreach['brand_list']['iteration']-1 ) % $this->_tpl_vars['brand_col_count'] == 0): ?>
		<td style="padding-left:10px;"><ul>
<?php endif; ?>
<?php if ($this->_tpl_vars['item']['_selected']): ?>
			<li><b><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['brand_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</b></li>
<?php else: ?>
			<li><a href="" value="<?php echo $this->_tpl_vars['item']['brand_id']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['brand_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></li>
<?php endif; ?>
<?php if (( $this->_foreach['brand_list']['iteration']-1 ) % $this->_tpl_vars['brand_col_count'] == $this->_tpl_vars['brand_col_count']-1 || ( $this->_foreach['brand_list']['iteration']-1 ) == $this->_tpl_vars['brand_count']-1): ?>
		</ul></td>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
	</tr></table>
</div><!--/noindex--->

<form id="filter_form" action="" method="get" style="display:none;" >
	<table class="product_filter">
		<tr>
			<td class="sort">
				Сортировка:
<?php $_from = $this->_tpl_vars['sort_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<a href="<?php echo $this->_tpl_vars['item']['sort_url']; ?>
"><?php echo $this->_tpl_vars['item']['sort_title']; ?>
</a> <?php if ($this->_tpl_vars['item']['sort_sign']): ?> <img  src="/image/design/<?php echo $this->_tpl_vars['item']['sort_sign']; ?>
.gif" alt=""/><?php endif; ?> 
<?php endforeach; endif; unset($_from); ?>
			</td>
			<td class="price_from">
				Цена от
			</td>
			<td class="price_from_input">
				<input name="product_price_from" class="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_price_from'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
			</td>
			<td class="price_to">
				до
			</td>
			<td class="price_to_input">
				<input name="product_price_to" class="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_price_to'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
			</td>
			<td class="price_rub">
				руб.
			</td>
			<td class="search">
<?php $_from = $this->_tpl_vars['hidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
				<input type="hidden" name="<?php echo $this->_tpl_vars['name']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
"/>
<?php endforeach; endif; unset($_from); ?>
				<input type="hidden" name="product_brand" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_brand'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
				<input type="submit" class="button" value="Искать"/>
			</td>
		</tr>
		<tr>
			<td class="pages">
<?php if ($this->_tpl_vars['pages']): ?>
				Страницы: <?php echo $this->_tpl_vars['pages']; ?>

<?php endif; ?>
			</td>
			<td class="price_list" colspan="5">
				<a href="<?php echo $this->_tpl_vars['price_list_url']; ?>
">Прайс-лист по разделу</a>
			</td>
			<td class="count">
				Показать по:
				<select name="count" onchange="$('#filter_form').submit()">
					<option value="15"<?php if ($_GET['count'] == 15): ?> selected="selected"<?php endif; ?>>15</option>
					<option value="30"<?php if ($_GET['count'] == 30 || ! $_GET['count']): ?> selected="selected"<?php endif; ?>>30</option>
					<option value="all"<?php if ($_GET['count'] == 'all'): ?> selected="selected"<?php endif; ?>>Все</option>
				</select>
			</td>
		</tr>
	</table>
</form>
<!--noindex--->


<table class="product_list">
<?php $_from = $this->_tpl_vars['product_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['product_table'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['product_table']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_list']):
        $this->_foreach['product_table']['iteration']++;
?>
	<tr>

<?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<td style="padding-top:10px;width: <?php echo $this->_tpl_vars['table_cell_width']; ?>
%"<?php if (($this->_foreach['product_table']['iteration'] == $this->_foreach['product_table']['total'])): ?> class="last"<?php endif; ?>>
<?php if ($this->_tpl_vars['item']): ?>
	
			<div class="kat2box">
			<a href="<?php echo $this->_tpl_vars['item']['product_url']; ?>
" class="kat1img"><img style="max-height: 170px;max-width:130px;" src="<?php echo $this->_tpl_vars['item']['product_picture_small']; ?>
"  alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></a>
			<div class="kat2link"<?php if ($this->_tpl_vars['item']['product_price_old']): ?> style="margin-bottom: 20px"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['item']['product_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></div>
<?php if ($this->_tpl_vars['item']['product_price_old']): ?>
				<div class="discountblock">
					<s><?php echo $this->_tpl_vars['item']['product_price_old']; ?>
 р.</s>
				</div>
<?php endif; ?>
				<div class="pricebox">
						<div class="priceblock">
							<?php echo $this->_tpl_vars['item']['product_price']; ?>
 р.
						</div>
						<div class="vkorzinu">
						<?php if ($this->_tpl_vars['item']['cart_url']): ?>
							<a href="<?php echo $this->_tpl_vars['item']['cart_url']; ?>
" title="В корзину">В корзину</a>
							<?php else: ?>
							<a href="" title="В корзине">В корзине</a>
							
							<?php endif; ?>
						</div>					
				<div class="clear"></div>
				</div>
			</div>			
<?php else: ?>
			&nbsp;
<?php endif; ?>
		</td>
<?php endforeach; endif; unset($_from); ?>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table><!--/noindex--->
<?php endif; ?>
<table class="product_pages">
	<tr>
<?php if ($this->_tpl_vars['pages']): ?>
		<td class="right">
			Страницы: <?php echo $this->_tpl_vars['pages']; ?>

		</td>
<?php endif; ?>
	</tr>
</table>

<div>

<?php if ($this->_tpl_vars['enable_desc'] == 1): ?>
	<?php echo $this->_tpl_vars['catalogue_description']; ?>

<?php endif; ?>
</div>