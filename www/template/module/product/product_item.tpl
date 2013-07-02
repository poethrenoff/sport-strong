{if $product_title}
<div class="hkat" style="padding-left:13px;">
	<h1>{$product_title|escape}</h1>
</div>
<table class="product">
	<tr>
		<td class="left" style="width: 320px; vertical-align:top;">
{if $product_picture_big}
			<a href="{$product_picture_big}" title="{$product_title|escape}" target="_blank"><img src="{$product_picture_middle}" alt="{$product_title|escape}" title="{$product_title|escape}" class="product"/></a>
{else}
			<img src="{$product_picture_middle}" alt="{$product_title|escape}" title="{$product_title|escape}" class="product"/>
{/if}
{if $picture_table}
			<table class="picture_table">
{foreach from=$picture_table item=picture_row}
				<tr>
{foreach from=$picture_row item=picture}
					<td style="width: {$picture_cell_width}%; vertical-align: top;">
{if $picture}
{if $picture.picture_name_big}
						<a href="{$picture.picture_name_big}" target="_blank"><img src="{$picture.picture_name_small}" alt="{$picture.picture_title|escape}" title="{$picture.picture_title|escape}" class="product"/></a>
{else}
						<img src="{$picture.picture_name_small}" alt="{$picture.picture_titl|escape}" title="{$picture.picture_title|escape}" class="product"/>
{/if}
						<p>{$picture.picture_title}</p>
{else}
						&nbsp;
{/if}
					</td>
{/foreach}
				</tr>
{/foreach}
			</table>
{/if}
		</td>
		<td class="right">
			<div class="marker">
{foreach from=$marker_list item=marker}
				<img src="{$marker.marker_picture}" alt="$marker.marker_title"/><br/>
{/foreach}
			</div>
			<div class="pricebut">
{if $product_price_old}
				<s>{$product_price_old} р.</s>
{/if}
				<span>{$product_price} р.</span>
				
				<a href="{$cart_url}">В корзину</a>
				<div class="clear"></div>
			</div>
			<div class="description">
{if $product_description_short}
				{$product_description_short}<br/>
{/if}
				{$product_description}
			</div>
{if $file_list}
			<div class="file_list">
				<b>Дополнительные материалы:</b><br/>
{foreach from=$file_list item=item}
				<a href="{$item.file_name}">{$item.file_title|escape}</a><br/>
{/foreach}
			</div>
{/if}
		</td>
	</tr>
</table>

{if $like_table}
<br/><h2>Похожие товары:</h2><br/>
<table class="product_list">
{foreach from=$like_table item=product_list name=product_table}
	<tr>
{foreach from=$product_list item=item}
		<td style="width: {$like_cell_width}%"{if $smarty.foreach.product_table.last} class="last"{/if}>
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
							<img src="{$marker.marker_picture}" alt="$marker.marker_title"/><br/>
{/foreach}
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
{/foreach}
</table>
{/if}

{else}
<p class="p">
	<b>По Вашему запросу ничего не найдено, обратитесь к менеджеру по телефону {$manager_phone} или e-mail: <a href="mailto:{$manager_email}">{$manager_email}</a>.</b>
</p>
{/if}
