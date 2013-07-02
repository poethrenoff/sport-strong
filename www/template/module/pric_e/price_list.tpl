<h1>Прайс-лист</h1><br/><br/>

<script type="text/javascript">
	function fnOpenWindow( sUrl )
	{ldelim}
		iWidth = screen.width * 0.8, iHeight = screen.height * 0.6, iPosX = screen.width / 2 - iWidth / 2, iPosY = screen.height / 2 - iHeight / 2;
		oWin = window.open( sUrl, 'oWindow', 'left=' + iPosX + ', top=' + iPosY + ', width=' + iWidth + ', height=' + iHeight + ', toolbar=0, status=0, menubar=0, resizable=1, scrollbars=1' );
		oWin.focus();
	{rdelim}
</script>

<a name="top"></a>

<form action="/price.php" method="get">
	<table class="price_filter">
		<tr>
			<td class="catalogue">
				Каталог:
			</td>
			<td class="catalogue_select">
				<select name="catalogue_id">
					<option value=""/>
{foreach from=$catalogue_list item=catalogue_item}
					<option value="{$catalogue_item.catalogue_id}"{if $catalogue_item._selected} selected="selected"{/if}>{section name=offset start=0 loop=$catalogue_item._depth}&nbsp;&nbsp;&nbsp;{/section}{$catalogue_item.catalogue_title|escape}</option>
{/foreach}
				</select>
			</td>
			<td class="show">
{foreach from=$hidden key=name item=value}
				<input type="hidden" name="{$name}" value="{$value}"/>
{/foreach}
				<input type="submit" class="button show" value="Показать"/>
				<input type="button" class="button print" value="Версия для печати" onclick="fnOpenWindow( '{$print_url}' )"/>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="sort">
				<noindex>
					Сортировка:
{foreach from=$sort_list item=item}
					<a href="{$item.sort_url}">{$item.sort_title}</a>{if $item.sort_sign} <img src="/image/design/{$item.sort_sign}.gif" alt=""/>{/if} 
{/foreach}
				</noindex>
			</td>
		</tr>
	</table>
</form>

<table class="price_list">
{foreach from=$price_list item=price_item}
	<tr>
		<td colspan="3" class="catalogue">
			<a href="{$price_item.catalogue_url}">{$price_item.catalogue_title|escape}</a>
		</td>
	</tr>
{foreach from=$price_item.products item=product_item name=products}
	<tr class="{if $smarty.foreach.products.iteration is odd}selected{/if}">
		<td class="title">
			<a href="{$product_item.product_url}">{$product_item.product_title|escape}</a>
		</td>
		<td class="brand">
			{$product_item.brand_title|escape} 
		</td>
		<td class="price">
			{$product_item.product_price} 
		</td>
	</tr>
{/foreach}
{/foreach}
</table>

<table class="price_nav">
	<tr>
		<td class="up">
			<a href="#top">Наверх</a>
		</td>
		<td class="print">
			<input type="button" class="button" value="Версия для печати" onclick="fnOpenWindow( '{$print_url}' )"/>
		</td>
	</tr>
</table>
