<script src="/script/check_form.js" type="text/javascript"></script>
<form id="fast_order" action="/fast_order.php" method="post" onsubmit="return CheckForm.validate( this )">
	<table class="fast_order">
		<tr>
			<td class="left picture">
				<img src="{$product_picture_small}" alt="{$product_title|escape}" class="product"/>
			</td>
			<td class="right">
				<div class="product_title">
					{$product_title|escape}
				</div>
				<div class="product_price">
					{$product_price} p.
				</div>
			</td>
		</tr>
{if $error}
		<tr class="info">
			<td colspan="2">
				<div class="error">
					{$error}
				</div>
			</td>
		</tr>
{/if}
		<tr>
			<td class="left">
				Ваше имя <span class="require">*</span>
			</td>
			<td class="right">
				<input type="text" class="text" name="order_client_name" value="" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="left">
				Ваш телефон <span class="require">*</span>
			</td>
			<td class="right">
				<input type="text" class="text" name="order_client_phone" value="" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="left">
				Комментарий к заказу
			</td>
			<td class="right">
				<textarea name="order_client_comment" cols="10" rows="5"></textarea>
			</td>
		</tr>
		<tr class="buttons">
			<td colspan="2">
				<input name="action" type="hidden" value="order_save"/>
				<input name="product_id" type="hidden" value="{$product_id}"/>
				<input type="submit" value="Отправить" class="button"/>
			</td>
		</tr>
		<tr class="info">
			<td colspan="2">
				<p class="c"><b>Менеджер свяжется с Вами в течении часа.<br/>Время приема заказов с 10 до 20</b></p>
				<br/>
				<p><span class="require">*</span> поля, обязательные для заполнения</p>
			</td>
		</tr>
	</table>
</form>
