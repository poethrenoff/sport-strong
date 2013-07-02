<?php /* Smarty version 2.6.22, created on 2009-09-16 10:03:06
         compiled from class/export/export.tpl */ ?>
<table class="title">
	<tr>
		<td class="title">
			<b><?php echo $this->_tpl_vars['title']; ?>
</b>
		</td>
	</tr>
</table>	
<br/>
<form action="index.php" method="get">
	<table class="filter" style="width: 500px">
		<tr>
			<td class="title">
				Раздел:
			</td>
			<td class="field">
				<select name="product_catalogue" class="list">
					<option value=""/>
<?php $_from = $this->_tpl_vars['catalogue_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['catalogue_item']):
?>
					<option value="<?php echo $this->_tpl_vars['catalogue_item']['value']; ?>
"><?php unset($this->_sections['offset']);
$this->_sections['offset']['name'] = 'offset';
$this->_sections['offset']['start'] = (int)0;
$this->_sections['offset']['loop'] = is_array($_loop=$this->_tpl_vars['catalogue_item']['_depth']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['offset']['show'] = true;
$this->_sections['offset']['max'] = $this->_sections['offset']['loop'];
$this->_sections['offset']['step'] = 1;
if ($this->_sections['offset']['start'] < 0)
    $this->_sections['offset']['start'] = max($this->_sections['offset']['step'] > 0 ? 0 : -1, $this->_sections['offset']['loop'] + $this->_sections['offset']['start']);
else
    $this->_sections['offset']['start'] = min($this->_sections['offset']['start'], $this->_sections['offset']['step'] > 0 ? $this->_sections['offset']['loop'] : $this->_sections['offset']['loop']-1);
if ($this->_sections['offset']['show']) {
    $this->_sections['offset']['total'] = min(ceil(($this->_sections['offset']['step'] > 0 ? $this->_sections['offset']['loop'] - $this->_sections['offset']['start'] : $this->_sections['offset']['start']+1)/abs($this->_sections['offset']['step'])), $this->_sections['offset']['max']);
    if ($this->_sections['offset']['total'] == 0)
        $this->_sections['offset']['show'] = false;
} else
    $this->_sections['offset']['total'] = 0;
if ($this->_sections['offset']['show']):

            for ($this->_sections['offset']['index'] = $this->_sections['offset']['start'], $this->_sections['offset']['iteration'] = 1;
                 $this->_sections['offset']['iteration'] <= $this->_sections['offset']['total'];
                 $this->_sections['offset']['index'] += $this->_sections['offset']['step'], $this->_sections['offset']['iteration']++):
$this->_sections['offset']['rownum'] = $this->_sections['offset']['iteration'];
$this->_sections['offset']['index_prev'] = $this->_sections['offset']['index'] - $this->_sections['offset']['step'];
$this->_sections['offset']['index_next'] = $this->_sections['offset']['index'] + $this->_sections['offset']['step'];
$this->_sections['offset']['first']      = ($this->_sections['offset']['iteration'] == 1);
$this->_sections['offset']['last']       = ($this->_sections['offset']['iteration'] == $this->_sections['offset']['total']);
?>&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php echo $this->_tpl_vars['catalogue_item']['title']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="title">
				Производитель:
			</td>
			<td class="field">
				<select name="product_brand" class="list">
					<option value=""/>
<?php $_from = $this->_tpl_vars['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['brand_item']):
?>
					<option value="<?php echo $this->_tpl_vars['brand_item']['value']; ?>
"><?php echo $this->_tpl_vars['brand_item']['title']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
				</select>

			</td>
		</tr>
		<tr>
			<td class="title">
				Название:
			</td>
			<td class="field">
				<input type="text" name="product_title" value="" class="text"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Видимость:
			</td>
			<td class="field">
				<select name="product_active" class="check">
					<option value=""/>
					<option value="1">да</option>
					<option value="0">нет</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="object" value="export"/>
				<input type="hidden" name="action" value="export"/>
				<input type="submit" value="Начать экспорт" class="button" style="width: 150px"/>
			</td>
		</tr>
	</table>
</form>