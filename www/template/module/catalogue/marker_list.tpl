<div id="tabs_wrapper">
	<div id="tabs_container">
		<ul id="tabs">
			{assign var="index" value=0}
			{foreach from=$marker_list item=product_list name=marker_list}
				{assign var="index" value=$index+1}
				<li {if $index==1}class="active"{/if}><a href="#tab{$index}">{$product_list[0].marker_title|escape}</a></li>
			{/foreach}			
		</ul>
	</div>
	<div id="tabs_content_container">
	
	{assign var="index" value=0}
	{foreach from=$marker_list item=product_list name=marker_list}
		{assign var="index" value=$index+1}
		<div id="tab{$index}" class="tab_content" {if $index==1} style="display: block;"{/if}>
		<!--noindex-->
		{foreach from=$product_list item=item}
		{if $item}
			<div class="tabpoz" >
				<div class="tabpic">
					<img src="{$item.product_picture_small}" alt="{$item.product_title|escape}" class="product" style="   max-height: 170px;
    max-width: 150px;"/>
				</div>
				<div class="tablnk">
				<a href="{$item.product_url}">{$item.product_title|escape}</a>
				</div>
				<div>

{if $item.product_price_old}
				<span class="cena_discount">
					<s>{$item.product_price_old} р.</s>
				</span>
{/if}
				<span class="cena">
					{$item.product_price} р.
				</span>
				<span>
				{if $item.cart_url}
						<a href="{$item.cart_url}" class="kupbut" title="В корзину">В корзину</a>
				{else}
						<img src="/image/design/in_basket.gif" alt="В корзине"/>
				{/if}				
				</span>
				</div> <!-- end price -->
			</div>
		{/if}
		{/foreach}
		</div>
	{/foreach}
	</div>
</div>