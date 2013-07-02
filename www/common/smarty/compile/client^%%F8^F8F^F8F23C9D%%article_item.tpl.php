<?php /* Smarty version 2.6.22, created on 2013-03-12 08:17:42
         compiled from module/article/article_item.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/article/article_item.tpl', 3, false),)), $this); ?>
<?php echo $this->_tpl_vars['path']; ?>


<h2><?php echo ((is_array($_tmp=$this->_tpl_vars['article_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>

<div id="text">
<?php echo $this->_tpl_vars['article_content']; ?>

</div>

<?php if ($this->_tpl_vars['product_table']): ?>
<hr/>
<h1>Купить <?php echo $this->_tpl_vars['catalogue_title']; ?>
 в нашем магазине:</h1>
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
		<td style="padding-top:10px;width: <?php echo $this->_tpl_vars['product_cell_width']; ?>
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
</table>
<!--/noindex--->
<?php endif; ?>