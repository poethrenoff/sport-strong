<?php /* Smarty version 2.6.22, created on 2013-01-14 22:16:55
         compiled from class/fm/upload.tpl */ ?>
<script src="/admin/script/check_form.js" type="text/javascript"></script>

<form id="form" action="index.php" method="post" enctype="multipart/form-data" onsubmit="return CheckForm.validate( this )">
	<table class="record">
		<tr>
			<td colspan="2" align="left">
				<b><?php echo $this->_tpl_vars['record_title']; ?>
</b><br/><?php echo $this->_tpl_vars['action_title']; ?>

			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="button" value="Вернуться" class="button" onclick="location.href = '<?php echo $this->_tpl_vars['back_url']; ?>
'"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Файл<span class="require">*</span>:
			</td>
			<td class="field">
				<table class="file">
					<tr>
						<td>
							<input type="file" name="file_file" class="file" size="70%" errors="require"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Сохранить" class="button"/>
<?php $_from = $this->_tpl_vars['hidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
				<input type="hidden" name="<?php echo $this->_tpl_vars['name']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
"/>
<?php endforeach; endif; unset($_from); ?>
			</td>
		</tr>
	</table>
</form>