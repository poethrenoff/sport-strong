{if $no_item_catalog}
<div style="margin:20px;">
<span >В данном разделе товар отсутствует.</span>
</div>
{else}
<h1>{$catalogue_title|escape} {$selected_brand|escape}</h1>
{if $selected_brand_country}
<div style="margin-bottom: 10px; font-weight: bold;">
	Страна: {$selected_brand_country}
</div>
{/if}
{if $catalogue_description_top}
<div style="margin-bottom: 10px">
{if $selected_brand_picture}
	<img src="{$selected_brand_picture}" style="max-width: 150px; max-height: 150px; margin: 0px 20px 20px 0px; float: left">
{/if}
	{$catalogue_description_top}
</div>
{/if}

{if $brand_count > 1}
<!--noindex---><div class="brands">
	<table><tr>
{foreach from=$brand_list item=item name=brand_list}
{if ($smarty.foreach.brand_list.iteration-1) % $brand_col_count == 0}
		<td style="padding-left:10px;"><ul>
{/if}
{if $item._selected}
			<li><b>{$item.brand_title|escape}</b></li>
{else}
			<li><a href="{$item.brand_url}" rel="{$item.brand_title|escape}">{$item.brand_title|escape}</a></li>
{/if}
{if ($smarty.foreach.brand_list.iteration-1) % $brand_col_count == $brand_col_count-1 || ($smarty.foreach.brand_list.iteration-1) == $brand_count-1}
		</ul></td>
{/if}
{/foreach}
	</tr></table>
</div><!--/noindex--->
{/if}

<table class="product_list">
{foreach from=$product_table item=product_list name=product_table}
	<tr>

{foreach from=$product_list item=item}
		<td style="padding-top:10px;width: {$table_cell_width}%"{if $smarty.foreach.product_table.last} class="last"{/if}>
{if $item}
	
			<div class="kat2box">
			<a href="{$item.product_url}" class="kat1img"><img style="max-height: 170px;max-width:130px;" src="{$item.product_picture_small}"  alt="{$item.product_title|escape}"></a>
			<div class="kat2link"{if $item.product_price_old} style="margin-bottom: 20px"{/if}><a href="{$item.product_url}">{$item.product_title|escape}</a></div>
{if $item.product_price_old}
				<div class="discountblock">
					<s>{$item.product_price_old} р.</s>
				</div>
{/if}
				<div class="pricebox">
						<div class="priceblock">
							{$item.product_price} р.
						</div>
						<div class="vkorzinu">
						{if $item.cart_url}
							<a href="{$item.cart_url}" title="В корзину">В корзину</a>
							{else}
							<a href="" title="В корзине">В корзине</a>
							
							{/if}
						</div>					
				<div class="clear"></div>
				</div>
			</div>			
{else}
			&nbsp;
{/if}
		</td>
{/foreach}
	</tr>
{/foreach}
</table><!--/noindex--->
{/if}
<table class="product_pages">
	<tr>
{if $pages}
		<td class="right">
			Страницы: {$pages}
		</td>
{/if}
	</tr>
</table>
{if !$selected_brand}
<div>
{if $catalogue_description_bottom}
<div style="margin-bottom: 10px">
	{$catalogue_description_bottom}
</div>
{/if}
{if $enable_desc==1}
	{$catalogue_description}
{/if}
</div>
{/if}