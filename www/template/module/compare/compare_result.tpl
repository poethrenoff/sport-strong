<h1>Результаты сравнения</h1>

{if $properties}
{foreach from=$properties key=product_type_id item=property_list name=properties}
<h2>{$property_list.title}</h2>
			
<table class="compare">
	<tr>
		<td class="property header">
			Характериcтики
		</td>
{foreach from=$products[$product_type_id] item=product_item}
		<td class="product header">
			<a href="{$product_item.product_url}">{$product_item.product_title}</a>
			<a href="{$product_item.delete_url}" onclick="return confirm( 'Вы уверены, что хотите удалить товар из сравнения?' )"><img src="/image/design/delete.gif" alt="Удалить"/></a>
		</td>
{/foreach}
	</tr>
{foreach from=$properties[$product_type_id].properties key=property_id item=property_item}
	<tr>
		<td class="property">
			{$property_item.property_title}{if $property_item.property_unit} ({$property_item.property_unit}){/if} 
		</td>
{foreach from=$products[$product_type_id] item=product_item}
{assign var=property_value value=$product_item.properties[$property_id]}
		<td class="product{if $property_item.property_equal} equal{/if}">
{if $property_item.property_kind == 'select'}
			{$property_item.values[$property_value]} 
{elseif $property_item.property_kind == 'boolean'}
			{if $property_value}есть{else}нет{/if} 
{else}
			{$property_value} 
{/if}
		</td>
{/foreach}
	</tr>
{/foreach}
	<tr>
		<td class="property">
			Купить
		</td>
{foreach from=$products[$product_type_id] item=product_item}
		<td class="product">
			<div class="cart">
{if $product_item.cart_url}
				<a href="{$product_item.cart_url}" title="В корзину"><img src="/image/design/basket.gif" alt="В корзину"/></a>
{else}
				<img src="/image/design/in_basket.gif" alt="В корзине"/>
{/if}
			</div>
		</td>
{/foreach}
	</tr>
</table>
{/foreach}
<div class="compare_clear">
	<a href="{$clear_url}" onclick="return confirm( 'Вы уверены, что хотите очистить результаты сравнения?' )">Очистить результаты сравнения</a>
</div>
{else}
<div class="error">
	Нет товаров для сравнения!
</div>
{/if}
