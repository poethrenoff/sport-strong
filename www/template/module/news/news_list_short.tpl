{if $news_list}
<div class="newsbox" style="margin-top: 20px">
	<span class="newstitle">Новости</span>
{foreach item=news_item from=$news_list name=news}
	<p><span class="newsdate">{$news_item.news_date}</span><br><a href="{$news_item.news_url}">{$news_item.news_title}</a></p>
{/foreach}
	<a href="/news.php"><b>Все новости</b></a>
</div>
{/if}