<?php /* Smarty version 2.6.22, created on 2009-08-31 15:01:44
         compiled from table.tpl */ ?>
<script src="/admin/script/table.js" type="text/javascript"></script>

<table class="title">
	<tr>
		<td class="title">
			<b><?php echo $this->_tpl_vars['title']; ?>
</b>
		</td>
		<td class="filter">
<?php if ($this->_tpl_vars['filter']): ?>
<?php echo $this->_tpl_vars['filter']; ?>

<?php else: ?>
			&nbsp;
<?php endif; ?>
		</td>
	</tr>
</table>	
<br/>
<?php if ($this->_tpl_vars['mode'] == 'form'): ?>
<form id="table" action="index.php" method="post" enctype="multipart/form-data">
<?php endif; ?>
<table class="service">
	<tr>
		<td class="action">
<?php $_from = $this->_tpl_vars['actions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['action']):
?>
			<a href="<?php echo $this->_tpl_vars['action']['url']; ?>
" title="<?php echo $this->_tpl_vars['action']['title']; ?>
"<?php if ($this->_tpl_vars['action']['event']): ?> <?php echo $this->_tpl_vars['action']['event']['method']; ?>
="<?php echo $this->_tpl_vars['action']['event']['value']; ?>
"<?php endif; ?>><img src="/admin/image/action/<?php echo $this->_tpl_vars['name']; ?>
.gif" alt="<?php echo $this->_tpl_vars['action']['title']; ?>
"/></a>
<?php endforeach; endif; unset($_from); ?>
<?php if ($this->_tpl_vars['mode'] == 'form'): ?>
			<input type="button" value="Вернуться" class="button" onclick="location.href = '<?php echo $this->_tpl_vars['back_url']; ?>
'"/>
<?php endif; ?>
		</td>
		<td class="pages">
<?php if ($this->_tpl_vars['mode'] == 'form'): ?>
			<input type="submit" value="Применить" class="button"/>
<?php $_from = $this->_tpl_vars['hidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['value']):
?>
			<input type="hidden" name="<?php echo $this->_tpl_vars['name']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
"/>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
		</td>
	</tr>
</table>
<br/>
<table class="table">
	<tr class="header">
<?php $_from = $this->_tpl_vars['header']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['header'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['header']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['field'] => $this->_tpl_vars['column']):
        $this->_foreach['header']['iteration']++;
?>
		<td<?php if ($this->_tpl_vars['column']['main']): ?> class="main"<?php endif; ?><?php if ($this->_tpl_vars['field'] === '_index'): ?> class="index"<?php endif; ?>>
<?php if ($this->_tpl_vars['field'] === '_index'): ?>
			<div style="width: 40px">
				<?php echo $this->_tpl_vars['column']['title']; ?>

			</div>
<?php elseif ($this->_tpl_vars['field'] === '_checkbox'): ?>
			<div style="text-align: center; width: 40px">
				<input type="checkbox" name="check_all" value="" class="check" onclick="checkAllBoxes( this.checked )"/>
			<div>
<?php else: ?>
<?php if ($this->_tpl_vars['column']['sort_url']): ?>
			<a href="<?php echo $this->_tpl_vars['column']['sort_url']; ?>
"><?php echo $this->_tpl_vars['column']['title']; ?>
</a>
			<?php if ($this->_tpl_vars['column']['sort_sign']): ?><img src="/admin/image/sort/<?php echo $this->_tpl_vars['column']['sort_sign']; ?>
.gif" alt=""/><?php endif; ?> 
<?php else: ?>
			<?php echo $this->_tpl_vars['column']['title']; ?>

<?php endif; ?>
<?php endif; ?>
		</td>
<?php endforeach; endif; unset($_from); ?>
	</tr>
<?php $_from = $this->_tpl_vars['records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['records'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['records']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['record']):
        $this->_foreach['records']['iteration']++;
?>
	<tr class="record <?php if ((1 & $this->_foreach['records']['iteration'])): ?>odd<?php else: ?>even<?php endif; ?>" onmouseover="this.className = 'record select'" onmouseout="this.className = 'record <?php if ((1 & $this->_foreach['records']['iteration'])): ?>odd<?php else: ?>even<?php endif; ?>'">
<?php $_from = $this->_tpl_vars['header']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field'] => $this->_tpl_vars['column']):
?>
		<td<?php if ($this->_tpl_vars['column']['main']): ?> class="main<?php if ($this->_tpl_vars['record']['_hidden']): ?> hidden<?php endif; ?>"<?php endif; ?><?php if ($this->_tpl_vars['field'] === '_index'): ?> class="index"<?php endif; ?><?php if ($this->_tpl_vars['column']['type'] === '_link'): ?> class="link"<?php endif; ?><?php if ($this->_tpl_vars['field'] === '_action'): ?> class="action"<?php endif; ?>>
<?php if ($this->_tpl_vars['column']['main'] && $this->_tpl_vars['record']['_depth']): ?>
<?php unset($this->_sections['offset']);
$this->_sections['offset']['name'] = 'offset';
$this->_sections['offset']['start'] = (int)0;
$this->_sections['offset']['loop'] = is_array($_loop=$this->_tpl_vars['record']['_depth']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?><div class="tree_offset"><?php endfor; endif; ?> 
<?php endif; ?>
<?php if ($this->_tpl_vars['column']['type'] === '_link'): ?>
			<a href="<?php echo $this->_tpl_vars['record'][$this->_tpl_vars['field']]['url']; ?>
"><?php echo $this->_tpl_vars['record'][$this->_tpl_vars['field']]['title']; ?>
</a>
<?php elseif ($this->_tpl_vars['field'] === '_action'): ?>
<?php $_from = $this->_tpl_vars['record'][$this->_tpl_vars['field']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['actions'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['actions']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['action']):
        $this->_foreach['actions']['iteration']++;
?>
<?php if ($this->_tpl_vars['name'] == 'separator'): ?>
<?php if (! ($this->_foreach['actions']['iteration'] == $this->_foreach['actions']['total'])): ?>
			<img src="/admin/image/action/separator.gif" alt=""/>
<?php endif; ?>
<?php else: ?>
			<a href="<?php echo $this->_tpl_vars['action']['url']; ?>
" title="<?php echo $this->_tpl_vars['action']['title']; ?>
"<?php if ($this->_tpl_vars['action']['event']): ?> <?php echo $this->_tpl_vars['action']['event']['method']; ?>
="<?php echo $this->_tpl_vars['action']['event']['value']; ?>
"<?php endif; ?>><img src="/admin/image/action/<?php echo $this->_tpl_vars['name']; ?>
.gif" alt="<?php echo $this->_tpl_vars['action']['title']; ?>
"/></a>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php elseif ($this->_tpl_vars['field'] === '_checkbox'): ?>
			<div style="text-align: center">
				<input type="hidden" name="check[<?php echo $this->_tpl_vars['record'][$this->_tpl_vars['field']]['id']; ?>
]" value="0">
				<input type="checkbox" name="check[<?php echo $this->_tpl_vars['record'][$this->_tpl_vars['field']]['id']; ?>
]" value="1" class="check" <?php if ($this->_tpl_vars['record'][$this->_tpl_vars['field']]['checked']): ?> checked="checked"<?php endif; ?>/>
			<div>
<?php else: ?>
			<?php echo $this->_tpl_vars['record'][$this->_tpl_vars['field']]; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['column']['main'] && $this->_tpl_vars['record']['_depth']): ?>
<?php unset($this->_sections['offset']);
$this->_sections['offset']['name'] = 'offset';
$this->_sections['offset']['start'] = (int)0;
$this->_sections['offset']['loop'] = is_array($_loop=$this->_tpl_vars['record']['_depth']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?></div><?php endfor; endif; ?> 
<?php endif; ?>
		</td>
<?php endforeach; endif; unset($_from); ?>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<br/>
<table class="service">
	<tr>
		<td class="counter">
			Всего: <?php echo $this->_tpl_vars['counter']; ?>

		</td>
<?php if ($this->_tpl_vars['pages']): ?>
		<td class="pages">
			Страницы: <?php echo $this->_tpl_vars['pages']; ?>

		</td>
<?php endif; ?>
	</tr>
</table>
<?php if ($this->_tpl_vars['mode'] == 'form'): ?>
</form>
<?php endif; ?>