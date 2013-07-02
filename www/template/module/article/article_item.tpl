{$path}

<h2>{$article_title|escape}</h2>

<div id="text">
{$article_content}
</div>

{if $product_table}
<hr/>
<h1>Купить {$catalogue_title} в нашем магазине:</h1>
<!--noindex--->
<table class="product_list">
{foreach from=$product_table item=product_list name=product_table}
	<tr>

{foreach from=$product_list item=item}
		<td style="padding-top:10px;width: {$product_cell_width}%"{if $smarty.foreach.product_table.last} class="last"{/if}>
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
</table>
<!--/noindex--->
{/if}
