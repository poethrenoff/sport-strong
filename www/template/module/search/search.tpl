{if $search_value}
<h2>Результаты поиска: <b>{$search_value|escape}</b> ({$search_count})</h2><br/><br/>
{if $search_list}
<table class="search_list">
{foreach from=$search_list item=item}
	<tr>
		<td class="counter">
			{$item.search_index}.
		</td>
		<td>
			<a href="{$item.product_url}">{$item.product_title|escape}</a>
		</td>
	</tr>
{/foreach}
</table>

{if $pages}
<div class="pages">
	Страницы: {$pages}
</div>
{/if}
{else}
<p class="p">
	<b>По Вашему запросу ничего не найдено, обратитесь к менеджеру по телефону {$manager_phone} или e-mail: <a href="mailto:{$admin_email}">{$admin_email}</a>.</b>
</p>
{/if}
{/if}
