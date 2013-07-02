{if $pages}
<div class="paginav">
            	<div class="navig">
					&larr; 
					{if $page_first!=1}<a href="?page={$page-1}">предыдущая</a>{else}предыдущая{/if} &nbsp; &nbsp; 
					{if $page_last!=1}<a href="?page={$page+1}">следующая</a>{else}следующая{/if} &rarr;					
				</div>
                <div id="dk">
	{foreach name=pages item=page from=$pages}
	{if $page.url}
		<a  class="dl" href="{$page.url}">{$page.num}</a>
	{else}
		<b class="dm">{$page.num}</b>
	{/if}
	{if !$smarty.foreach.pages.last} 

	{/if}
	{/foreach}
                </div>
            </div>	
{/if}
