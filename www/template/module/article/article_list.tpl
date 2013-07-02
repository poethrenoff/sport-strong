{$path}

<h1>Статьи</h1>

{foreach item=article_item from=$article_list}
<div class="article_title">
	<a href="{$article_item.article_url}">{$article_item.article_title|escape}</a>
</div>
<div class="article_announce">
	{$article_item.article_announce} 
</div>
{/foreach}

{if $pages}
<div class="pages">
	Страницы: {$pages}
</div>
{/if}
