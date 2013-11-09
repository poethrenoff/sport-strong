	<script src="/script/check_form.js" type="text/javascript"></script>
	<br/>
	<h1>Обратный звонок </h1>
{if $error}
	<span class="red_text">{$error}</span>
{else}
	<span class="red_text">Поля с * обязательны к заполнению.</span>
{/if}
	<form id="callback_form" action="/callback.php" method="post">
		<p><label for="">Ваше имя</label> <input type="text" name="callback_person" value="{$smarty.post.callback_person|escape}" errors="require" /> <span>*</span></p>
		<p><label for="">Ваш телефон</label> <input type="text" name="callback_phone" value="{$smarty.post.callback_phone|escape}" errors="require" /> <span>*</span></p>
		<p><label for="">Удобное время звонка</label> <input type="text" name="callback_time" value="{$smarty.post.callback_time|escape}" /></p>
		<div class="clear"></div>
		<p><label for="">Комментарий<br>(например, товар, который Вас заинтересовал)</label> <textarea rows="" cols="" name="callback_comment">{$smarty.post.callback_comment|escape}</textarea></p>
		<input type="hidden" name="action" value="callback_save" />
		<input type="submit" value="Оформить заказ" class="otpravit_button"/>
	</form>
	<br/>
