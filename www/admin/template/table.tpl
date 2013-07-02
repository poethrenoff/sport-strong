<script src="/admin/script/table.js" type="text/javascript"></script>

<table class="title">
	<tr>
		<td class="title">
			<b>{$title}</b>
		</td>
		<td class="filter">
{if $filter}
{$filter}
{else}
			&nbsp;
{/if}
		</td>
	</tr>
</table>	
<br/>
{if $mode == 'form'}
<form id="table" action="index.php" method="post" enctype="multipart/form-data">
{/if}
<table class="service">
	<tr>
		<td class="action">
{foreach from=$actions key=name item=action}
			<a href="{$action.url}" title="{$action.title}"{if $action.event} {$action.event.method}="{$action.event.value}"{/if}><img src="/admin/image/action/{$name}.gif" alt="{$action.title}"/></a>
{/foreach}
{if $mode == 'form'}
			<input type="button" value="Вернуться" class="button" onclick="location.href = '{$back_url}'"/>
{/if}
		</td>
		<td class="pages">
{if $mode == 'form'}
			<input type="submit" value="Применить" class="button"/>
{foreach from=$hidden key=name item=value}
			<input type="hidden" name="{$name}" value="{$value}"/>
{/foreach}
{/if}
		</td>
	</tr>
</table>
<br/>
<table class="table">
	<tr class="header">
{foreach from=$header key=field item=column name=header}
		<td{if $column.main} class="main"{/if}{if $field === '_index'} class="index"{/if}>
{if $field === '_index'}
			<div style="width: 40px">
				{$column.title}
			</div>
{elseif $field === '_checkbox'}
			<div style="text-align: center; width: 40px">
				<input type="checkbox" name="check_all" value="" class="check" onclick="checkAllBoxes( this.checked )"/>
			<div>
{else}
{if $column.sort_url}
			<a href="{$column.sort_url}">{$column.title}</a>
			{if $column.sort_sign}<img src="/admin/image/sort/{$column.sort_sign}.gif" alt=""/>{/if} 
{else}
			{$column.title}
{/if}
{/if}
		</td>
{/foreach}
	</tr>
{foreach from=$records item=record name=records}
	<tr class="record {if $smarty.foreach.records.iteration is odd}odd{else}even{/if}" onmouseover="this.className = 'record select'" onmouseout="this.className = 'record {if $smarty.foreach.records.iteration is odd}odd{else}even{/if}'">
{foreach from=$header key=field item=column}
		<td{if $column.main} class="main{if $record._hidden} hidden{/if}"{/if}{if $field === '_index'} class="index"{/if}{if $column.type === '_link'} class="link"{/if}{if $field === '_action'} class="action"{/if}>
{if $column.main && $record._depth}
{section name=offset start=0 loop=$record._depth}<div class="tree_offset">{/section} 
{/if}
{if $column.type === '_link'}
			<a href="{$record[$field].url}">{$record[$field].title}</a>
{elseif $field === '_action'}
{foreach from=$record[$field] key=name item=action name=actions}
{if $name == 'separator'}
{if !$smarty.foreach.actions.last}
			<img src="/admin/image/action/separator.gif" alt=""/>
{/if}
{else}
			<a href="{$action.url}" title="{$action.title}"{if $action.event} {$action.event.method}="{$action.event.value}"{/if}><img src="/admin/image/action/{$name}.gif" alt="{$action.title}"/></a>
{/if}
{/foreach}
{elseif $field === '_checkbox'}
			<div style="text-align: center">
				<input type="hidden" name="check[{$record[$field].id}]" value="0">
				<input type="checkbox" name="check[{$record[$field].id}]" value="1" class="check" {if $record[$field].checked} checked="checked"{/if}/>
			<div>
{else}
			{$record[$field]}
{/if}
{if $column.main && $record._depth}
{section name=offset start=0 loop=$record._depth}</div>{/section} 
{/if}
		</td>
{/foreach}
	</tr>
{/foreach}
</table>
<br/>
<table class="service">
	<tr>
		<td class="counter">
			Всего: {$counter}
		</td>
{if $pages}
		<td class="pages">
			Страницы: {$pages}
		</td>
{/if}
	</tr>
</table>
{if $mode == 'form'}
</form>
{/if}
