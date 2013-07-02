<?php /* Smarty version 2.6.22, created on 2012-10-24 08:58:50
         compiled from module/order/order_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/order/order_form.tpl', 30, false),)), $this); ?>
<?php if ($this->_tpl_vars['error']): ?>
<div class="error">
	<?php echo $this->_tpl_vars['error']; ?>

</div>
<?php endif; ?>
<!--<table class="cart">
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
			<?php echo $this->_tpl_vars['item']['product_count']; ?>

		</td>
		<td class="cost">
			<?php echo $this->_tpl_vars['item']['product_cost']; ?>

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
	</tr>
	<tr class="buttons">
		<td colspan="5">
			<input type="button" value="Вернуться" onclick="document.location.href = '/cart.php'" class="button"/>
		</td>
	</tr>		
</table>
-->
<script src="/script/check_form.js" type="text/javascript"></script>
<!-- crumbs -->
<div id="crumbs">
<a href="/">Главная</a> &nbsp;»&nbsp; <a href="/cart.php">Корзина</a> &nbsp;»&nbsp; Оформление заказа
</div>
<!-- #crumbs -->

<!-- text -->
<div id="text">
<h1>Оформление заказа</h1>


<form id="order" action="/order.php" method="post" onsubmit="return CheckForm.validate( this )">
        


<!-- zakaz form -->
<div id="zakaz">
<p><label for="">Имя</label> <input type="text" name="order_client_name" errors="require" /> <span>*</span></p>
<p><label for="">Адрес</label> <input type="text" name="order_client_address" errors="require" /> <span>*</span></p>
<p><label for="">Город</label> <input type="text" name="order_client_city" errors="require"/> <span>*</span></p>
<p><label for="">Телефон</label> <input type="text" name="order_client_phone" errors="require" /> <span>*</span></p>
<p><label for="">Дополнительный телефон</label> <input type="text" name="order_client_phone2" /></p>
<p><label for="">E-mail</label> <input type="text" name="order_client_email" errors="require|email" /> <span>*</span></p>

<div class="clear"></div>
<div class="podp">Поля, отмеченные <span>*</span>, обязательны для заполнения </div>
<input name="action" type="hidden" value="order_save"/>
<input type="submit" value="Оформить заказ" class="otpravit_button"/>
<!--<div class="otpravit"><a href="">Оформить заказ</a></div>-->
<div class="clear"></div>


</div>
<div class="shadow"></div>
<!-- # zakaz form -->

            
            <!-- #text -->
            
        
<!--
	<table class="order">
		<tr>
			<td class="title">
				ФИО <span class="require">*</span>
			</td>
			<td class="value">
				<input type="text" class="text" name="order_client_name" value="" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				E-mail <span class="require">*</span>
			</td>
			<td class="value">
				<input type="text" class="text" name="order_client_email" value="" errors="require|email"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Контактные телефоны <span class="require">*</span>
			</td>
			<td class="value">
				<input type="text" class="text" name="order_client_phone" value="" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Адрес доставки<span class="require">*</span>
			</td>
			<td class="value">
				<textarea name="order_client_address" cols="10" rows="5" errors="require"></textarea>
			</td>
		</tr>
		<tr>
			<td class="title">
				Комментарий к заказу
			</td>
			<td class="value">
				<textarea name="order_client_comment" cols="10" rows="5"></textarea>
			</td>
		</tr>
		<tr class="buttons">
			<td colspan="2">
				<input name="action" type="hidden" value="order_save"/>
				<input type="submit" value="Отправить" class="button"/>
			</td>
		</tr>
	</table>-->
</form>
</div>