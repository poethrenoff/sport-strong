<h1>Консультации on-line</h1>
{if $error}
<div class="error">
	{$error|escape} 
</div>
{/if}
<script src="/script/check_form.js" type="text/javascript"></script>
<form action="/question.php" method="post" enctype="multipart/form-data" onsubmit="return CheckForm.validate( this )">
	<table class="question_table">
		<tr>
			<td class="title">
				Имя<span class="require">*</span>:
			</td>
			<td>
				<input type="hidden" name="mode" value="form"/>
				<input type="hidden" name="action" value="question"/>
				<input type="text" class="text" name="question_author" value="{$question_author|escape}" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Email<span class="require">*</span>:
			</td>
			<td>
				<input type="text" class="text" name="question_email" value="{$question_email|escape}" errors="require|email"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Вопрос<span class="require">*</span>:
			</td>
			<td>
				<textarea name="question_content" rows="5" cols="5" errors="require">{$question_content|escape}</textarea>
			</td>
		</tr>
		<tr>
			<td class="title">
				Введите число<span class="require">*</span>:
			</td>
			<td>
				<input type="hidden" name="captcha_id" value="{$captcha_id}"/>
				<input type="text" class="text" name="captcha_value" value="" errors="require|int"/>
				<img src="/image/captcha.php?captcha_id={$captcha_id}" alt="Контрольное число" align="absbottom"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" class="button" value="Отправить"/>
			</td>
		</tr>
	</table>
</form>
