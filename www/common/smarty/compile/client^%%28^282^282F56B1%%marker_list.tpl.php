<?php /* Smarty version 2.6.22, created on 2012-12-13 08:35:23
         compiled from module/catalogue/marker_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/catalogue/marker_list.tpl', 7, false),)), $this); ?>
<div id="tabs_wrapper">
	<div id="tabs_container">
		<ul id="tabs">
			<?php $this->assign('index', 0); ?>
			<?php $_from = $this->_tpl_vars['marker_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['marker_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['marker_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_list']):
        $this->_foreach['marker_list']['iteration']++;
?>
				<?php $this->assign('index', $this->_tpl_vars['index']+1); ?>
				<li <?php if ($this->_tpl_vars['index'] == 1): ?>class="active"<?php endif; ?>><a href="#tab<?php echo $this->_tpl_vars['index']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['product_list'][0]['marker_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>			
		</ul>
	</div>
	<div id="tabs_content_container">
	
	<?php $this->assign('index', 0); ?>
	<?php $_from = $this->_tpl_vars['marker_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['marker_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['marker_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_list']):
        $this->_foreach['marker_list']['iteration']++;
?>
		<?php $this->assign('index', $this->_tpl_vars['index']+1); ?>
		<div id="tab<?php echo $this->_tpl_vars['index']; ?>
" class="tab_content" <?php if ($this->_tpl_vars['index'] == 1): ?> style="display: block;"<?php endif; ?>>
		<!--noindex-->
		<?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<?php if ($this->_tpl_vars['item']): ?>
			<div class="tabpoz" >
				<div class="tabpic">
					<img src="<?php echo $this->_tpl_vars['item']['product_picture_small']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="product" style="   max-height: 170px;
    max-width: 150px;"/>
				</div>
				<div class="tablnk">
				<a href="<?php echo $this->_tpl_vars['item']['product_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
				</div>
				<div>

<?php if ($this->_tpl_vars['item']['product_price_old']): ?>
				<span class="cena_discount">
					<s><?php echo $this->_tpl_vars['item']['product_price_old']; ?>
 р.</s>
				</span>
<?php endif; ?>
				<span class="cena">
					<?php echo $this->_tpl_vars['item']['product_price']; ?>
 р.
				</span>
				<span>
				<?php if ($this->_tpl_vars['item']['cart_url']): ?>
						<a href="<?php echo $this->_tpl_vars['item']['cart_url']; ?>
" class="kupbut" title="В корзину">В корзину</a>
				<?php else: ?>
						<img src="/image/design/in_basket.gif" alt="В корзине"/>
				<?php endif; ?>				
				</span>
				</div> <!-- end price -->
			</div>
		<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		</div>
	<?php endforeach; endif; unset($_from); ?>
	</div>
</div>