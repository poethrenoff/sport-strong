<?php /* Smarty version 2.6.22, created on 2009-08-31 15:02:10
         compiled from filter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'filter.tpl', 19, false),)), $this); ?>
<form action="index.php" method="get">
	<table class="filter">
<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['field']):
?>
		<tr>
			<td class="title">
				<?php echo $this->_tpl_vars['field']['title']; ?>
:
			</td>
			<td class="field">
<?php if ($this->_tpl_vars['field']['type'] === 'boolean' || $this->_tpl_vars['field']['type'] === 'active'): ?>
				<select name="<?php echo $this->_tpl_vars['name']; ?>
" class="check">
					<option value=""/>
					<option value="1"<?php if ($this->_tpl_vars['field']['value'] === '1'): ?> selected="selected"<?php endif; ?>>да</option>
					<option value="0"<?php if ($this->_tpl_vars['field']['value'] === '0'): ?> selected="selected"<?php endif; ?>>нет</option>
				</select>
<?php elseif ($this->_tpl_vars['field']['type'] === 'select' || $this->_tpl_vars['field']['type'] === 'table'): ?>
				<select name="<?php echo $this->_tpl_vars['name']; ?>
" class="list">
					<option value=""/>
<?php $_from = $this->_tpl_vars['field']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['option']):
?>
					<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['option']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php if ($this->_tpl_vars['option']['value'] === $this->_tpl_vars['field']['value']): ?> selected="selected"<?php endif; ?>><?php unset($this->_sections['offset']);
$this->_sections['offset']['name'] = 'offset';
$this->_sections['offset']['start'] = (int)0;
$this->_sections['offset']['loop'] = is_array($_loop=$this->_tpl_vars['option']['_depth']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?>&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['option']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</option>
<?php endforeach; endif; unset($_from); ?>
				</select>
<?php else: ?>
				<input type="text" name="<?php echo $this->_tpl_vars['name']; ?>
" value="<?php echo $this->_tpl_vars['field']['value']; ?>
" class="text"/>
<?php endif; ?>
			</td>
		</tr>
<?php endforeach; endif; unset($_from); ?>
		<tr>
			<td>
				&nbsp;
			</td>
			<td colspan="2">
				<input type="submit" value="Искать" class="button"/>
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