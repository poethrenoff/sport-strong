
{if $cart}
<script type="text/javascript">
	var bCartModified = false;
	{literal}
	function changeProduct( sId, iShift )
	{ldelim}
		oInput = document.getElementById( sId );
		oInput.value = Math.max( parseInt( oInput.value ) + iShift, 0 );
		
		bCartModified = true;
	{rdelim}
	function calculate_item(id_item)
	{
		count=jQuery('#product_'+id_item).val();
		window.location = "/?recheck_cart="+id_item+"&count="+count;
	}
	{/literal}
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
    
{foreach from=$cart item=item name=cart}

    <div class="stroka">
    	<div class="k1">
        	<img src="{$item.product_pic}" width="90" alt="" class="korzimg">
            {$item.product_title|escape}
        </div>
        <div class="k2">{$item.product_price} р.</div>
        <div class="k3">
			<input class="korzinp" id="product_{$item.product_id}" name="cart[{$item.product_id}]" type="text" value="{$item.product_count}" onchange="calculate_item({$item.product_id})" />
		</div>
        <div class="k4"><b>{$item.product_cost} р.</b></div>
        <div class="k5"><a href="?out_cart={$item.product_id}" onclick="return confirm( 'Вы уверены, что хотите удалить товар из корзины?' )"><img src="img/del.gif" width="10" alt=""></a></div>
    <div class="clear"></div></div>
  {/foreach}    
    <div class="itogo">
    	<div class="oform">
			<a onclick="document.location.href = '../order.php'" href="#">Оформить заказ</a>
		</div>
		
    	<div class="summa" ><span style="float:left">Итого: <b>{$order_sum} р.</b></span> <div style="float:left" class="recalculate"></div></div> 
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
{foreach from=$cart item=item name=cart}
		<tr>
			<td class="counter">
				{$smarty.foreach.cart.iteration}.
			</td>
			<td class="product">
				{$item.product_title|escape}
			</td>
			<td class="price">
				{$item.product_price}
			</td>
			<td class="count">
				<input id="product_{$item.product_id}" name="cart[{$item.product_id}]" type="text" value="{$item.product_count}" readonly="readonly"/>
			</td>
			<td class="cost">
				{$item.product_cost}
			</td>
			<td class="change">
				<a href="" onclick="changeProduct( 'product_{$item.product_id}', 1 ); return false" title="Увеличить"><img src="/image/design/plus.gif" alt="Увеличить"/></a> / <a href="" onclick="changeProduct( 'product_{$item.product_id}', -1 ); return false" title="Уменьшить"><img src="/image/design/minus.gif" alt="Уменьшить"/></a>
			</td>
			<td class="delete">
				<a href="{$item.delete_url}" onclick="return confirm( 'Вы уверены, что хотите удалить товар из корзины?' )"><img src="/image/design/delete.gif" alt="Удалить"/></a>
			</td>
		</tr>
{/foreach}
		<tr class="order_sum">
			<td colspan="4">
				Итоговая сумма:
			</td>
			<td>
				{$order_sum}
			</td>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>		
		<tr class="buttons">
			<td colspan="7">
				<input type="hidden" name="action" value="cart_save"/>
				
				<input type="submit" value="Пересчитать" class="button"/>
				<input type="button" value="Очистить" class="button" onclick="if ( confirm( 'Вы уверены, что хотите очистить корзину?' ) ) document.location.href = '{$clear_url}'"/>
				<input type="button" value="Оформить" class="button" onclick="if ( !bCartModified || confirm( 'В форме имеются несохраненные данные.\nВсе равно перейти к оформлению заказа?' ) ) document.location.href = '/order.php'"/>
			</td>
		</tr>		
	</table>-->
</form>
<div class="error">
	<!--После любого изменения бланка заказа не забывайте нажимать на кнопку "пересчитать"!-->
</div>
{else}
<div class="error">
	Корзина пуста!
</div>
{/if}
