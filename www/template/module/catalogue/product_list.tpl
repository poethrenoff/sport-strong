<script type="text/javascript" src="http://yandex.st/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript">{literal}
	jQuery(function(){
		jQuery('div.brands a').click(function(){
			jQuery('#filter_form').find('input[name="product_brand"]').val($(this).attr('value'));
			
			jQuery('#filter_form').submit();
			return false;
		});
	});
	
	{/literal}
</script>
{if $no_item_catalog}
<div style="margin:20px;">
<span >В данном разделе товар отсутствует.</span>
</div>
{else}
<h1>{$catalogue_title|escape}</h1>
{if $catalogue_description_top}
<div style="margin-bottom: 10px">
	{$catalogue_description_top}
</div>
{/if}

<!--noindex---><div class="brands">
	<table><tr>
{foreach from=$brand_list item=item name=brand_list}
{if ($smarty.foreach.brand_list.iteration-1) % $brand_col_count == 0}
		<td style="padding-left:10px;"><ul>
{/if}
{if $item._selected}
			<li><b>{$item.brand_title|escape}</b></li>
{else}
			<li><a href="" value="{$item.brand_id}">{$item.brand_title|escape}</a></li>
{/if}
{if ($smarty.foreach.brand_list.iteration-1) % $brand_col_count == $brand_col_count-1 || ($smarty.foreach.brand_list.iteration-1) == $brand_count-1}
		</ul></td>
{/if}
{/foreach}
	</tr></table>
</div><!--/noindex--->

<form id="filter_form" action="" method="get" style="display:none;" >
	<table class="product_filter">
		<tr>
			<td class="sort">
				Сортировка:
{foreach from=$sort_list item=item}
				<a href="{$item.sort_url}">{$item.sort_title}</a> {if $item.sort_sign} <img  src="/image/design/{$item.sort_sign}.gif" alt=""/>{/if} 
{/foreach}
			</td>
			<td class="price_from">
				Цена от
			</td>
			<td class="price_from_input">
				<input name="product_price_from" class="text" value="{$product_price_from|escape}"/>
			</td>
			<td class="price_to">
				до
			</td>
			<td class="price_to_input">
				<input name="product_price_to" class="text" value="{$product_price_to|escape}"/>
			</td>
			<td class="price_rub">
				руб.
			</td>
			<td class="search">
{foreach from=$hidden key=name item=value}
				<input type="hidden" name="{$name}" value="{$value}"/>
{/foreach}
				<input type="hidden" name="product_brand" value="{$product_brand|escape}"/>
				<input type="submit" class="button" value="Искать"/>
			</td>
		</tr>
		<tr>
			<td class="pages">
{if $pages}
				Страницы: {$pages}
{/if}
			</td>
			<td class="price_list" colspan="5">
				<a href="{$price_list_url}">Прайс-лист по разделу</a>
			</td>
			<td class="count">
				Показать по:
				<select name="count" onchange="$('#filter_form').submit()">
					<option value="15"{if $smarty.get.count == 15} selected="selected"{/if}>15</option>
					<option value="30"{if $smarty.get.count == 30 || !$smarty.get.count} selected="selected"{/if}>30</option>
					<option value="all"{if $smarty.get.count == 'all'} selected="selected"{/if}>Все</option>
				</select>
			</td>
		</tr>
	</table>
</form>
<!--noindex--->


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

<div>

{if $enable_desc==1}
	{$catalogue_description}
{/if}
</div>