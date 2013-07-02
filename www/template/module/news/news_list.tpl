<h1>Новости</h1>
{foreach item=news_item from=$news_list}
		 	<div class="news_block">
				<p class="news">
					<b>{$news_item.news_date}</b><br />
					<a href="{$news_item.news_url}">{$news_item.news_title|escape}</a>
				</p>
				{$news_item.news_announce}<br/>
			</div>
{/foreach}

{$pages}
