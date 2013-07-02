<table class="title">
	<tr>
		<td class="title">
			<b>{$title}</b>
		</td>
	</tr>
</table>	
<br/>
<form action="index.php" method="get">
	<table class="filter" style="width: 500px">
		<tr>
			<td class="title">
				Модуль:
			</td>
			<td class="field">
				<select name="meta_module" class="list">
					<option value=""/>
{foreach from=$module_list item=module_item}
					<option value="{$module_item.value}">{$module_item.title}</option>
{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class="title">
				Заголовок:
			</td>
			<td class="field">
				<input type="text" name="meta_title" value="" class="text"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="object" value="meta_export"/>
				<input type="hidden" name="action" value="export"/>
				<input type="submit" value="Начать экспорт" class="button" style="width: 150px"/>
			</td>
		</tr>
	</table>
</form>
