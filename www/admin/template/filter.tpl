<form action="index.php" method="get">
	<table class="filter">
{foreach from=$fields key=name item=field}
		<tr>
			<td class="title">
				{$field.title}:
			</td>
			<td class="field">
{if $field.type === 'boolean' || $field.type === 'active'}
				<select name="{$name}" class="check">
					<option value=""/>
					<option value="1"{if $field.value === "1"} selected="selected"{/if}>да</option>
					<option value="0"{if $field.value === "0"} selected="selected"{/if}>нет</option>
				</select>
{elseif $field.type === 'select' || $field.type === 'table'}
				<select name="{$name}" class="list">
					<option value=""/>
{foreach from=$field.values item=option}
					<option value="{$option.value|escape}"{if $option.value === $field.value} selected="selected"{/if}>{section name=offset start=0 loop=$option._depth}&nbsp;&nbsp;&nbsp;{/section}{$option.title|escape}</option>
{/foreach}
				</select>
{else}
				<input type="text" name="{$name}" value="{$field.value}" class="text"/>
{/if}
			</td>
		</tr>
{/foreach}
		<tr>
			<td>
				&nbsp;
			</td>
			<td colspan="2">
				<input type="submit" value="Искать" class="button"/>
{foreach from=$hidden key=name item=value}
				<input type="hidden" name="{$name}" value="{$value}"/>
{/foreach}
			</td>
		</tr>
	</table>
</form>
