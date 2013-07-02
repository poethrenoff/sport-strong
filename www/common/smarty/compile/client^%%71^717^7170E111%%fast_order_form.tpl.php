<?php /* Smarty version 2.6.22, created on 2009-08-31 15:20:19
         compiled from module/order/fast_order_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/order/fast_order_form.tpl', 6, false),)), $this); ?>
<script src="/script/check_form.js" type="text/javascript"></script>
<form id="fast_order" action="/fast_order.php" method="post" onsubmit="return CheckForm.validate( this )">
	<table class="fast_order">
		<tr>
			<td class="left picture">
				<img src="<?php echo $this->_tpl_vars['product_picture_small']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="product"/>
			</td>
			<td class="right">
				<div class="product_title">
					<?php echo ((is_array($_tmp=$this->_tpl_vars['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

				</div>
				<div class="product_price">
					<?php echo $this->_tpl_vars['product_price']; ?>
 p.
				</div>
			</td>
		</tr>
<?php if ($this->_tpl_vars['error']): ?>
		<tr class="info">
			<td colspan="2">
				<div class="error">
					<?php echo $this->_tpl_vars['error']; ?>

				</div>
			</td>
		</tr>
<?php endif; ?>
		<tr>
			<td class="left">
				Ваше имя <span class="require">*</span>
			</td>
			<td class="right">
				<input type="text" class="text" name="order_client_name" value="" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="left">
				Ваш телефон <span class="require">*</span>
			</td>
			<td class="right">
				<input type="text" class="text" name="order_client_phone" value="" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="left">
				Комментарий к заказу
			</td>
			<td class="right">
				<textarea name="order_client_comment" cols="10" rows="5"></textarea>
			</td>
		</tr>
		<tr class="buttons">
			<td colspan="2">
				<input name="action" type="hidden" value="order_save"/>
				<input name="product_id" type="hidden" value="<?php echo $this->_tpl_vars['product_id']; ?>
"/>
				<input type="submit" value="Отправить" class="button"/>
			</td>
		</tr>
		<tr class="info">
			<td colspan="2">
				<p class="c"><b>Менеджер свяжется с Вами в течении часа.<br/>Время приема заказов с 10 до 20</b></p>
				<br/>
				<p><span class="require">*</span> поля, обязательные для заполнения</p>
			</td>
		</tr>
	</table>
</form>