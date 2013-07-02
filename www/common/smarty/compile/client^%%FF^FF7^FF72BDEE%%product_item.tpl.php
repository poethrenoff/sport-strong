<?php /* Smarty version 2.6.22, created on 2013-02-24 10:30:06
         compiled from module/product/product_item.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/product/product_item.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['product_title']): ?>
<div class="hkat" style="padding-left:13px;">
	<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>
</div>
<table class="product">
	<tr>
		<td class="left" style="width: 320px; vertical-align:top;">
<?php if ($this->_tpl_vars['product_picture_big']): ?>
			<a href="<?php echo $this->_tpl_vars['product_picture_big']; ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['product_picture_middle']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="product"/></a>
<?php else: ?>
			<img src="<?php echo $this->_tpl_vars['product_picture_middle']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="product"/>
<?php endif; ?>
<?php if ($this->_tpl_vars['picture_table']): ?>
			<table class="picture_table">
<?php $_from = $this->_tpl_vars['picture_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['picture_row']):
?>
				<tr>
<?php $_from = $this->_tpl_vars['picture_row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['picture']):
?>
					<td style="width: <?php echo $this->_tpl_vars['picture_cell_width']; ?>
%; vertical-align: top;">
<?php if ($this->_tpl_vars['picture']): ?>
<?php if ($this->_tpl_vars['picture']['picture_name_big']): ?>
						<a href="<?php echo $this->_tpl_vars['picture']['picture_name_big']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['picture']['picture_name_small']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="product"/></a>
<?php else: ?>
						<img src="<?php echo $this->_tpl_vars['picture']['picture_name_small']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_titl'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['picture']['picture_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="product"/>
<?php endif; ?>
						<p><?php echo $this->_tpl_vars['picture']['picture_title']; ?>
</p>
<?php else: ?>
						&nbsp;
<?php endif; ?>
					</td>
<?php endforeach; endif; unset($_from); ?>
				</tr>
<?php endforeach; endif; unset($_from); ?>
			</table>
<?php endif; ?>
		</td>
		<td class="right">
			<div class="marker">
<?php $_from = $this->_tpl_vars['marker_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['marker']):
?>
				<img src="<?php echo $this->_tpl_vars['marker']['marker_picture']; ?>
" alt="$marker.marker_title"/><br/>
<?php endforeach; endif; unset($_from); ?>
			</div>
			<div class="pricebut">
<?php if ($this->_tpl_vars['product_price_old']): ?>
				<s><?php echo $this->_tpl_vars['product_price_old']; ?>
 р.</s>
<?php endif; ?>
				<span><?php echo $this->_tpl_vars['product_price']; ?>
 р.</span>
				
				<a href="<?php echo $this->_tpl_vars['cart_url']; ?>
">В корзину</a>
				<div class="clear"></div>
			</div>
			<div class="description">
<?php if ($this->_tpl_vars['product_description_short']): ?>
				<?php echo $this->_tpl_vars['product_description_short']; ?>
<br/>
<?php endif; ?>
				<?php echo $this->_tpl_vars['product_description']; ?>

			</div>
<?php if ($this->_tpl_vars['file_list']): ?>
			<div class="file_list">
				<b>Дополнительные материалы:</b><br/>
<?php $_from = $this->_tpl_vars['file_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<a href="<?php echo $this->_tpl_vars['item']['file_name']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['file_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a><br/>
<?php endforeach; endif; unset($_from); ?>
			</div>
<?php endif; ?>
		</td>
	</tr>
</table>

<?php if ($this->_tpl_vars['like_table']): ?>
<br/><h2>Похожие товары:</h2><br/>
<table class="product_list">
<?php $_from = $this->_tpl_vars['like_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['product_table'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['product_table']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_list']):
        $this->_foreach['product_table']['iteration']++;
?>
	<tr>
<?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<td style="width: <?php echo $this->_tpl_vars['like_cell_width']; ?>
%"<?php if (($this->_foreach['product_table']['iteration'] == $this->_foreach['product_table']['total'])): ?> class="last"<?php endif; ?>>
<?php if ($this->_tpl_vars['item']): ?>
			<table class="product_item">
				<tr>
					<td class="title" colspan="2">
						<a href="<?php echo $this->_tpl_vars['item']['product_url']; ?>
" class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
					</td>
				</tr>
				<tr>
					<td class="image">
						<a href="<?php echo $this->_tpl_vars['item']['product_url']; ?>
"><img src="<?php echo $this->_tpl_vars['item']['product_picture_small']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="product"/></a>
					</td>
					<td class="price">
						<div class="marker">
<?php $_from = $this->_tpl_vars['item']['marker_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['marker']):
?>
							<img src="<?php echo $this->_tpl_vars['marker']['marker_picture']; ?>
" alt="$marker.marker_title"/><br/>
<?php endforeach; endif; unset($_from); ?>
						</div>
						<div class="price">
							<?php echo $this->_tpl_vars['item']['product_price']; ?>
 р.
						</div>
						<div class="cart">
<?php if ($this->_tpl_vars['item']['cart_url']): ?>
							<a href="<?php echo $this->_tpl_vars['item']['cart_url']; ?>
" title="В корзину"><img src="/image/design/basket.gif" alt="В корзину"/></a>
<?php else: ?>
							<img src="/image/design/in_basket.gif" alt="В корзине"/>
<?php endif; ?>
						</div>
					</td>
				</tr>
			</table>
<?php else: ?>
			&nbsp;
<?php endif; ?>
		</td>
<?php endforeach; endif; unset($_from); ?>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>

<?php else: ?>
<p class="p">
	<b>По Вашему запросу ничего не найдено, обратитесь к менеджеру по телефону <?php echo $this->_tpl_vars['manager_phone']; ?>
 или e-mail: <a href="mailto:<?php echo $this->_tpl_vars['manager_email']; ?>
"><?php echo $this->_tpl_vars['manager_email']; ?>
</a>.</b>
</p>
<?php endif; ?>