{foreach from=$marker_list item=product_list name=marker_list}
<br/><div class="glavn">{$product_list[0].marker_title|escape}</div><br/>
<!--noindex-->
<table class="product_list">
	<tr>
{foreach from=$product_list item=item}
		<td style="width: {$table_cell_width}%"{if $smarty.foreach.marker_list.last} class="last"{/if}>
{if $item}
			<table class="product_item">
				<tr>
					<td class="title" colspan="2">
						<a href="{$item.product_url}" class="title">{$item.product_title|escape}</a>
					</td>
				</tr>
				<tr>
					<td class="image">
						<a href="{$item.product_url}"><img src="{$item.product_picture_small}" alt="{$item.product_title|escape}" class="product"/></a>
					</td>
					<td class="price">
						<div class="marker">
{foreach from=$item.marker_list item=marker}
							<img src="{$marker.marker_picture}" alt="{$marker.marker_title}"/><br/>
{/foreach}
						</div>
						<div class="price_old">
{if $item.product_price != $item.product_price_old}
							{$item.product_price_old} р.
{/if}
						</div>
						<div class="price">
							{$item.product_price} р.
						</div>
						<div class="cart">
{if $item.cart_url}
							<a href="{$item.cart_url}" title="В корзину"><img src="/image/design/basket.gif" alt="В корзину"/></a>
{else}
							<img src="/image/design/in_basket.gif" alt="В корзине"/>
{/if}
						</div>
					</td>
				</tr>
			</table>
{else}
			&nbsp;
{/if}
		</td>
{/foreach}
	</tr>
</table><!--/noindex-->
{/foreach}
