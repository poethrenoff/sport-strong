Вас приветствует спортивный интернет-магазин {$site_name}!

Благодарим за Ваш заказ. Мы получили следующую информацию:

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

В ближайшее время с Вами свяжется менеджер нашего магазина, чтобы уточнить время доставки и сборки товара. Если Вы обнаружили неточности в оставленных Вами контактных данных, пожалуйста, позвоните нам по телефону {$manager_phone}.

С уважением,
Интернет-магазин {$site_name}
Тел.: {$manager_phone}

P.S. Если заказ был оставлен не Вами и это письмо попало не по адресу, пожалуйста, сообщите об этом по адресу {$manager_email}. Просим прощения за беспокойство.
