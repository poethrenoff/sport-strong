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
{if $like_list}
			<h2 style="font-size:1.1em; font-weight: bold; margin: 20px 0px 20px 30px;">Похожие товары</h2>
{foreach from=$like_list item=item}
			<div class="kat2box" style="margin-left: 30px;">
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
{/foreach}
{/if}
		</td>
		<td class="right" style="vertical-align:top;">
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
{else}
<p class="p">
	<b>По Вашему запросу ничего не найдено, обратитесь к менеджеру по телефону {$manager_phone} или e-mail: <a href="mailto:{$manager_email}">{$manager_email}</a>.</b>
</p>
{/if}
