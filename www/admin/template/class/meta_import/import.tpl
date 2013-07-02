<table class="title">
	<tr>
		<td class="title">
			<b>{$title}</b>
		</td>
	</tr>
</table>	
<br/>
{if $message}
<div class="error">
	{$message} 
</div>
<br/>
{/if}
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
				<input type="hidden" name="object" value="meta_import"/>
				<input type="hidden" name="action" value="import"/>
				<input type="submit" value="Начать импорт" class="button" style="width: 150px"/>
			</td>
		</tr>
	</table>
</form>
