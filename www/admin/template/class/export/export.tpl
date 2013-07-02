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
				Раздел:
			</td>
			<td class="field">
				<select name="product_catalogue" class="list">
					<option value=""/>
{foreach from=$catalogue_list item=catalogue_item}
					<option value="{$catalogue_item.value}">{section name=offset start=0 loop=$catalogue_item._depth}&nbsp;&nbsp;&nbsp;{/section}{$catalogue_item.title}</option>
{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class="title">
				Производитель:
			</td>
			<td class="field">
				<select name="product_brand" class="list">
					<option value=""/>
{foreach from=$brand_list item=brand_item}
					<option value="{$brand_item.value}">{$brand_item.title}</option>
{/foreach}
				</select>

			</td>
		</tr>
		<tr>
			<td class="title">
				Название:
			</td>
			<td class="field">
				<input type="text" name="product_title" value="" class="text"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Видимость:
			</td>
			<td class="field">
				<select name="product_active" class="check">
					<option value=""/>
					<option value="1">да</option>
					<option value="0">нет</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="object" value="export"/>
				<input type="hidden" name="action" value="export"/>
				<input type="submit" value="Начать экспорт" class="button" style="width: 150px"/>
			</td>
		</tr>
	</table>
</form>
