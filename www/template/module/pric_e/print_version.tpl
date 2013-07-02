<div class="print_version">
	<table class="print_head">
		<tr>
			<td class="left">
				&nbsp;
			</td>
			<td class="center">
				<h1>Прайс-лист</h1>
			</td>
			<td class="right">
				<input type="button" class="button" value="Закрыть" onclick="window.close()"/>
				<input type="button" class="button" value="Печать" onclick="window.print()"/>
			</td>
		</tr>
	</table>

	<table class="price_list">
	{foreach from=$price_list item=price_item}
		<tr>
			<td colspan="3" class="catalogue">
				{$price_item.catalogue_title|escape} 
			</td>
		</tr>
	{foreach from=$price_item.products item=product_item name=products}
		<tr class="{if $smarty.foreach.products.iteration is odd}selected{/if}">
			<td>
				{$product_item.product_title|escape} 
			</td>
			<td>
				{$product_item.brand_title|escape} 
			</td>
			<td>
				{$product_item.product_price}
			</td>
		</tr>
	{/foreach}
	{/foreach}
	</table>
</div>