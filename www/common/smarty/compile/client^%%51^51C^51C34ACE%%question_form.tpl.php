<?php /* Smarty version 2.6.22, created on 2012-09-22 20:58:30
         compiled from module/question/question_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/question/question_form.tpl', 4, false),)), $this); ?>
<h1>Консультации on-line</h1>
<?php if ($this->_tpl_vars['error']): ?>
<div class="error">
	<?php echo ((is_array($_tmp=$this->_tpl_vars['error'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 
</div>
<?php endif; ?>
<script src="/script/check_form.js" type="text/javascript"></script>
<form action="/question.php" method="post" enctype="multipart/form-data" onsubmit="return CheckForm.validate( this )">
	<table class="question_table">
		<tr>
			<td class="title">
				Имя<span class="require">*</span>:
			</td>
			<td>
				<input type="hidden" name="mode" value="form"/>
				<input type="hidden" name="action" value="question"/>
				<input type="text" class="text" name="question_author" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['question_author'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Email<span class="require">*</span>:
			</td>
			<td>
				<input type="text" class="text" name="question_email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['question_email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" errors="require|email"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Вопрос<span class="require">*</span>:
			</td>
			<td>
				<textarea name="question_content" rows="5" cols="5" errors="require"><?php echo ((is_array($_tmp=$this->_tpl_vars['question_content'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
			</td>
		</tr>
		<tr>
			<td class="title">
				Введите число<span class="require">*</span>:
			</td>
			<td>
				<input type="hidden" name="captcha_id" value="<?php echo $this->_tpl_vars['captcha_id']; ?>
"/>
				<input type="text" class="text" name="captcha_value" value="" errors="require|int"/>
				<img src="/image/captcha.php?captcha_id=<?php echo $this->_tpl_vars['captcha_id']; ?>
" alt="Контрольное число" align="absbottom"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" class="button" value="Отправить"/>
			</td>
		</tr>
	</table>
</form>