<script src="/admin/script/check_form.js" type="text/javascript"></script>

<form id="form" action="index.php" method="post" enctype="multipart/form-data" onsubmit="return CheckForm.validate( this )">
	<table class="record">
		<tr>
			<td colspan="2" align="left">
				<b>{$record_title}</b><br/>{$action_title}
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="button" value="Вернуться" class="button" onclick="location.href = '{$back_url}'"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Файл<span class="require">*</span>:
			</td>
			<td class="field">
				<table class="file">
					<tr>
						<td>
							<input type="file" name="file_file" class="file" size="70%" errors="require"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Сохранить" class="button"/>
{foreach from=$hidden key=name item=value}
				<input type="hidden" name="{$name}" value="{$value}"/>
{/foreach}
			</td>
		</tr>
	</table>
</form>
