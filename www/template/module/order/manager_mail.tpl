В интернет-магазин {$site_name} поступил новый заказ.

{foreach from=$cart item=item name=cart}
{$smarty.foreach.cart.iteration}. {$item.product_title}		{$item.product_count} x {$item.product_price} ( {$item.product_cost} р. )
{/foreach}

Общая стоимость заказа: {$order_sum} р.

ФИО         : {$order_client_name}
Email       : {$order_client_email}
Телефоны    : {$order_client_phone}
Город		: {$order_client_city}
Адрес       :
{$order_client_address}
Комментарий :
{$order_client_comment}
