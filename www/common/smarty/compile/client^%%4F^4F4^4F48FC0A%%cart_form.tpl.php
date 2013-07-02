<?php /* Smarty version 2.6.22, created on 2013-02-01 16:57:11
         compiled from module/cart/cart_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/cart/cart_form.tpl', 40, false),)), $this); ?>

<?php if ($this->_tpl_vars['cart']): ?>
<script type="text/javascript">
	var bCartModified = false;
	<?php echo '
	function changeProduct( sId, iShift )
	{ldelim}
		oInput = document.getElementById( sId );
		oInput.value = Math.max( parseInt( oInput.value ) + iShift, 0 );
		
		bCartModified = true;
	{rdelim}
	function calculate_item(id_item)
	{
		count=jQuery(\'#product_\'+id_item).val();
		window.location = "/?recheck_cart="+id_item+"&count="+count;
	}
	'; ?>

</script>

<form id="cart" action="/cart.php" method="post">
<div id="text">
<h1>Корзина</h1>

<div id="korzina">

	<div class="k_title">
    	<div class="k1">Наименование</div>
        <div class="k2">Цена</div>
        <div class="k3">Кол-во</div>
        <div class="k4">Сумма</div>
        
    <div class="clear"></div></div>
    
<?php $_from = $this->_tpl_vars['cart']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cart'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cart']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['cart']['iteration']++;
?>

    <div class="stroka">
    	<div class="k1">
        	<img src="<?php echo $this->_tpl_vars['item']['product_pic']; ?>
" width="90" alt="" class="korzimg">
            <a href=""><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
        </div>
        <div class="k2"><?php echo $this->_tpl_vars['item']['product_price']; ?>
 р.</div>
        <div class="k3">
			<input class="korzinp" id="product_<?php echo $this->_tpl_vars['item']['product_id']; ?>
" name="cart[<?php echo $this->_tpl_vars['item']['product_id']; ?>
]" type="text" value="<?php echo $this->_tpl_vars['item']['product_count']; ?>
" onchange="calculate_item(<?php echo $this->_tpl_vars['item']['product_id']; ?>
)" />
		</div>
        <div class="k4"><b><?php echo $this->_tpl_vars['item']['product_cost']; ?>
 р.</b></div>
        <div class="k5"><a href="?out_cart=<?php echo $this->_tpl_vars['item']['product_id']; ?>
" onclick="return confirm( 'Вы уверены, что хотите удалить товар из корзины?' )"><img src="img/del.gif" width="10" alt=""></a></div>
    <div class="clear"></div></div>
  <?php endforeach; endif; unset($_from); ?>    
    <div class="itogo">
    	<div class="oform">
			<a onclick="document.location.href = '../order.php'" href="#">Оформить заказ</a>
		</div>
		
    	<div class="summa" ><span style="float:left">Итого: <b><?php echo $this->_tpl_vars['order_sum']; ?>
 р.</b></span> <div style="float:left" class="recalculate"></div></div> 
    </div>
<div class="text">
<br><br><br><br><br>После оформления заказа с Вами свяжется менеджер (в рабочее время - в течение 30 минут) и уточнит удобное для Вас время доставки, а также учтет остальные Ваши пожелания.<br>
С условиями доставки и оплаты товара Вы можете ознакомиться в разделе "<a href="/delivery.php">Доставка и оплата</a>" или по телефонам <b>8 (916) 810-09-02</b> и <b>8 (495) 778-66-59</b>.
</div>
</div>
    
            </div>


<!--
	<table class="cart">
		<tr class="header">
			<td>
				№
			</td>
			<td>
				Товар
			</td>
			<td>
				Цена
			</td>
			<td>
				Кол-во
			</td>
			<td>
				Стоимость
			</td>
			<td>
				Изменить
			</td>
			<td>
				Удалить
			</td>
		</tr>
<?php $_from = $this->_tpl_vars['cart']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cart'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cart']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['cart']['iteration']++;
?>
		<tr>
			<td class="counter">
				<?php echo $this->_foreach['cart']['iteration']; ?>
.
			</td>
			<td class="product">
				<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

			</td>
			<td class="price">
				<?php echo $this->_tpl_vars['item']['product_price']; ?>

			</td>
			<td class="count">
				<input id="product_<?php echo $this->_tpl_vars['item']['product_id']; ?>
" name="cart[<?php echo $this->_tpl_vars['item']['product_id']; ?>
]" type="text" value="<?php echo $this->_tpl_vars['item']['product_count']; ?>
" readonly="readonly"/>
			</td>
			<td class="cost">
				<?php echo $this->_tpl_vars['item']['product_cost']; ?>

			</td>
			<td class="change">
				<a href="" onclick="changeProduct( 'product_<?php echo $this->_tpl_vars['item']['product_id']; ?>
', 1 ); return false" title="Увеличить"><img src="/image/design/plus.gif" alt="Увеличить"/></a> / <a href="" onclick="changeProduct( 'product_<?php echo $this->_tpl_vars['item']['product_id']; ?>
', -1 ); return false" title="Уменьшить"><img src="/image/design/minus.gif" alt="Уменьшить"/></a>
			</td>
			<td class="delete">
				<a href="<?php echo $this->_tpl_vars['item']['delete_url']; ?>
" onclick="return confirm( 'Вы уверены, что хотите удалить товар из корзины?' )"><img src="/image/design/delete.gif" alt="Удалить"/></a>
			</td>
		</tr>
<?php endforeach; endif; unset($_from); ?>
		<tr class="order_sum">
			<td colspan="4">
				Итоговая сумма:
			</td>
			<td>
				<?php echo $this->_tpl_vars['order_sum']; ?>

			</td>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>		
		<tr class="buttons">
			<td colspan="7">
				<input type="hidden" name="action" value="cart_save"/>
				
				<input type="submit" value="Пересчитать" class="button"/>
				<input type="button" value="Очистить" class="button" onclick="if ( confirm( 'Вы уверены, что хотите очистить корзину?' ) ) document.location.href = '<?php echo $this->_tpl_vars['clear_url']; ?>
'"/>
				<input type="button" value="Оформить" class="button" onclick="if ( !bCartModified || confirm( 'В форме имеются несохраненные данные.\nВсе равно перейти к оформлению заказа?' ) ) document.location.href = '/order.php'"/>
			</td>
		</tr>		
	</table>-->
</form>
<div class="error">
	<!--После любого изменения бланка заказа не забывайте нажимать на кнопку "пересчитать"!-->
</div>
<?php else: ?>
<div class="error">
	Корзина пуста!
</div>
<?php endif; ?>