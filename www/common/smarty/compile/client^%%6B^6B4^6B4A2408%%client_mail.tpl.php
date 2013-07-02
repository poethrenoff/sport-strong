<?php /* Smarty version 2.6.22, created on 2013-02-06 15:20:21
         compiled from module/order/client_mail.tpl */ ?>
Вас приветствует спортивный интернет-магазин <?php echo $this->_tpl_vars['site_name']; ?>
!

Благодарим за Ваш заказ. Мы получили следующую информацию:

<?php $_from = $this->_tpl_vars['cart']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cart'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cart']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['cart']['iteration']++;
?>
<?php echo $this->_foreach['cart']['iteration']; ?>
. <?php echo $this->_tpl_vars['item']['product_title']; ?>
		<?php echo $this->_tpl_vars['item']['product_count']; ?>
 x <?php echo $this->_tpl_vars['item']['product_price']; ?>
 ( <?php echo $this->_tpl_vars['item']['product_cost']; ?>
 р. )
<?php endforeach; endif; unset($_from); ?>

Общая стоимость заказа: <?php echo $this->_tpl_vars['order_sum']; ?>
 р.

ФИО         : <?php echo $this->_tpl_vars['order_client_name']; ?>

Email       : <?php echo $this->_tpl_vars['order_client_email']; ?>

Телефоны    : <?php echo $this->_tpl_vars['order_client_phone']; ?>

Город		: <?php echo $this->_tpl_vars['order_client_city']; ?>

Адрес       :
<?php echo $this->_tpl_vars['order_client_address']; ?>

Комментарий :
<?php echo $this->_tpl_vars['order_client_comment']; ?>


В ближайшее время с Вами свяжется менеджер нашего магазина, чтобы уточнить время доставки и сборки товара. Если Вы обнаружили неточности в оставленных Вами контактных данных, пожалуйста, позвоните нам по телефону <?php echo $this->_tpl_vars['manager_phone']; ?>
.

С уважением,
Интернет-магазин <?php echo $this->_tpl_vars['site_name']; ?>

Тел.: <?php echo $this->_tpl_vars['manager_phone']; ?>


P.S. Если заказ был оставлен не Вами и это письмо попало не по адресу, пожалуйста, сообщите об этом по адресу <?php echo $this->_tpl_vars['manager_email']; ?>
. Просим прощения за беспокойство.