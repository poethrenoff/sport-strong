<?php /* Smarty version 2.6.22, created on 2012-09-04 09:24:40
         compiled from module/cart/cart_info.tpl */ ?>
<div class="title">
	Ваша корзина
</div>
<?php if ($this->_tpl_vars['order_count']): ?>
<div class="product_count">
	<strong>Корзина</strong>&nbsp;&nbsp;: <?php echo $this->_tpl_vars['order_count']; ?>
 шт.
</div>
<div class="order_sum">
	<strong>Сумма</strong>: <?php echo $this->_tpl_vars['order_sum']; ?>
 руб.
</div>
<?php else: ?>
<div class="cart_empty">
	ещё пуста
</div>
<?php endif; ?>