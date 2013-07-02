<div class="title">
	Ваша корзина
</div>
{if $order_count}
<div class="product_count">
	<strong>Корзина</strong>&nbsp;&nbsp;: {$order_count} шт.
</div>
<div class="order_sum">
	<strong>Сумма</strong>: {$order_sum} руб.
</div>
{else}
<div class="cart_empty">
	ещё пуста
</div>
{/if}
