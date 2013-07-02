<h1>{$catalogue_title|escape}</h1>

<table class="catalogue_list">
{foreach from=$catalogue_table item=row name=catalogue_table}
	<tr>
{foreach from=$row item=item}
		<td style="width: {$table_cell_width}%"{if $smarty.foreach.catalogue_table.last} class="last"{/if}>
{if $item}
			<b><a href="{$item.catalogue_url}">{$item.catalogue_title|escape}</a></b><br/><br/>
			<a href="{$item.catalogue_url}"><img src="{$item.catalogue_picture}" alt="{$item.catalogue_title|escape}" class="product"/></a>
{else}
			&nbsp;
{/if}
		</td>
{/foreach}
	</tr>
{/foreach}
</table>

<div>
	{$catalogue_description}
</div>

{if $pages}
<div class="pages">
	Страницы: {$pages}
</div>
{/if}
