<?php /* Smarty version 2.6.22, created on 2009-09-15 13:50:00
         compiled from class/import/import.tpl */ ?>
<table class="title">
	<tr>
		<td class="title">
			<b><?php echo $this->_tpl_vars['title']; ?>
</b>
		</td>
	</tr>
</table>	
<br/>
<?php if ($this->_tpl_vars['message']): ?>
<div class="error">
	<?php echo $this->_tpl_vars['message']; ?>
 
</div>
<br/>
<?php endif; ?>
<form action="index.php" method="post" enctype="multipart/form-data" >
	<table class="filter" style="width: 100%">
		<tr>
			<td class="title">
				Файл импорта
			</td>
			<td class="field">
				<input type="file" name="file" class="file" size="70%"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="object" value="import"/>
				<input type="hidden" name="action" value="import"/>
				<input type="submit" value="Начать импорт" class="button" style="width: 150px"/>
			</td>
		</tr>
	</table>
</form>