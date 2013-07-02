{if $error}
<div class="error">
	{$error}
</div>
{/if}
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
			{$item.product_count}
		</td>
		<td class="cost">
			{$item.product_cost}
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