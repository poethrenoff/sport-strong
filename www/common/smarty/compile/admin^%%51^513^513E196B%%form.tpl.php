<?php /* Smarty version 2.6.22, created on 2009-08-31 15:01:49
         compiled from form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'form.tpl', 30, false),)), $this); ?>
<script src="/admin/script/richedit.js" type="text/javascript"></script>
<script src="/admin/script/bbcode.js" type="text/javascript"></script>
<script src="/admin/script/calendar.js" type="text/javascript"></script>
<script src="/admin/script/check_form.js" type="text/javascript"></script>

<form id="form" action="index.php" method="post" enctype="multipart/form-data" onsubmit="rtoStore(); return CheckForm.validate( this )">
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
<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['field']):
?>
		<tr>
			<td class="title">
				<?php echo $this->_tpl_vars['field']['title']; ?>
<?php if ($this->_tpl_vars['field']['require']): ?><span class="require">*</span><?php endif; ?>:
			</td>
			<td class="field">
<?php if ($this->_tpl_vars['field']['type'] === 'boolean' || $this->_tpl_vars['field']['type'] === 'active' || $this->_tpl_vars['field']['type'] === 'default'): ?>
				<input type="checkbox" name="<?php echo $this->_tpl_vars['name']; ?>
" value="1" class="check" errors="<?php echo $this->_tpl_vars['field']['errors']; ?>
"<?php if ($this->_tpl_vars['field']['value'] === '1'): ?> checked="checked"<?php endif; ?>/>
<?php elseif ($this->_tpl_vars['field']['type'] === 'select' || $this->_tpl_vars['field']['type'] === 'table' || $this->_tpl_vars['field']['type'] === 'parent'): ?>
				<select name="<?php echo $this->_tpl_vars['name']; ?>
" class="list" errors="<?php echo $this->_tpl_vars['field']['errors']; ?>
">
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
<?php elseif ($this->_tpl_vars['field']['type'] === 'date' || $this->_tpl_vars['field']['type'] === 'datetime'): ?>
				<table class="date">
					<tr>
						<td>
							<input type="text" name="<?php echo $this->_tpl_vars['name']; ?>
" value="<?php echo $this->_tpl_vars['field']['value']; ?>
" class="date" errors="<?php echo $this->_tpl_vars['field']['errors']; ?>
"/>
						</td>
						<td>
							<a href="" onclick="Calendar.show( document.forms['form']['<?php echo $this->_tpl_vars['name']; ?>
'], this, '<?php if ($this->_tpl_vars['field']['type'] === 'date'): ?>short<?php else: ?>long<?php endif; ?>' ); return false">
								<img src="/admin/image/calendar/calendar.gif" alt=""/>
							</a>
						</td>
						<td>
							<a href="" onclick="Calendar.now( document.forms['form']['<?php echo $this->_tpl_vars['name']; ?>
'], '<?php if ($this->_tpl_vars['field']['type'] === 'date'): ?>short<?php else: ?>long<?php endif; ?>' ); return false">
								<img src="/admin/image/calendar/check.gif" alt=""/>
							</a>
						</td>
					</tr>
				</table>
<?php elseif ($this->_tpl_vars['field']['type'] === 'image' || $this->_tpl_vars['field']['type'] === 'file'): ?>
				<table class="file">
					<tr>
						<td>
							<input type="file" name="<?php echo $this->_tpl_vars['name']; ?>
_file" class="file" size="70%"/>
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="<?php echo $this->_tpl_vars['name']; ?>
" value="<?php echo $this->_tpl_vars['field']['value']; ?>
" class="link"/>
						</td>
					</tr>
				</table>
<?php elseif ($this->_tpl_vars['field']['type'] === 'text'): ?>
<?php if ($this->_tpl_vars['field']['textarea'] === 'editor'): ?>
<?php if ($this->_tpl_vars['field']['translate']): ?>
				<table class="translate">
<?php $_from = $this->_tpl_vars['lang_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lang']):
?>
					<tr>
						<td>
							<div class="editor"><?php echo $this->_tpl_vars['lang']['lang_dirname']; ?>
</div>
							<textarea id="<?php echo $this->_tpl_vars['name']; ?>
_content_<?php echo $this->_tpl_vars['lang']['lang_id']; ?>
" cols="" rows="" class="hidden" errors="<?php echo $this->_tpl_vars['field']['errors']; ?>
"><?php echo $this->_tpl_vars['field']['value'][$this->_tpl_vars['lang']['lang_id']]; ?>
</textarea>
							<script type="text/javascript">
								var <?php echo $this->_tpl_vars['name']; ?>
_editor_<?php echo $this->_tpl_vars['lang']['lang_id']; ?>
 = new Editor( '<?php echo $this->_tpl_vars['name']; ?>
[<?php echo $this->_tpl_vars['lang']['lang_id']; ?>
]' ); <?php echo $this->_tpl_vars['name']; ?>
_editor_<?php echo $this->_tpl_vars['lang']['lang_id']; ?>
.create( '<?php echo $this->_tpl_vars['name']; ?>
_content_<?php echo $this->_tpl_vars['lang']['lang_id']; ?>
' );
							</script>
						</td>
					</tr>
<?php endforeach; endif; unset($_from); ?>
				</table>
<?php else: ?>
				<textarea id="<?php echo $this->_tpl_vars['name']; ?>
_content" cols="" rows="" class="hidden" errors="<?php echo $this->_tpl_vars['field']['errors']; ?>
"><?php echo $this->_tpl_vars['field']['value']; ?>
</textarea>
				<script type="text/javascript">
					var <?php echo $this->_tpl_vars['name']; ?>
_editor = new Editor( '<?php echo $this->_tpl_vars['name']; ?>
' ); <?php echo $this->_tpl_vars['name']; ?>
_editor.create( '<?php echo $this->_tpl_vars['name']; ?>
_content' );
				</script>
<?php endif; ?>
<?php else: ?>
<?php if ($this->_tpl_vars['field']['translate']): ?>
				<table class="translate">
<?php $_from = $this->_tpl_vars['lang_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lang']):
?>
					<tr>
						<td>
							<div class="textarea"><?php echo $this->_tpl_vars['lang']['lang_dirname']; ?>
</div>
							<textarea style="padding-left: 20px; width: 97%" name="<?php echo $this->_tpl_vars['name']; ?>
[<?php echo $this->_tpl_vars['lang']['lang_id']; ?>
]" cols="" rows="" class="simple" errors="<?php echo $this->_tpl_vars['field']['errors']; ?>
"><?php echo $this->_tpl_vars['field']['value'][$this->_tpl_vars['lang']['lang_id']]; ?>
</textarea>
						</td>
					</tr>
<?php endforeach; endif; unset($_from); ?>
				</table>
<?php else: ?>
				<textarea name="<?php echo $this->_tpl_vars['name']; ?>
" cols="" rows="" class="simple" errors="<?php echo $this->_tpl_vars['field']['errors']; ?>
"><?php echo $this->_tpl_vars['field']['value']; ?>
</textarea>
<?php endif; ?>
<?php endif; ?>
<?php else: ?>
<?php if ($this->_tpl_vars['field']['translate']): ?>
				<table class="translate">
<?php $_from = $this->_tpl_vars['lang_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lang']):
?>
					<tr>
						<td>
							<div class="input"><?php echo $this->_tpl_vars['lang']['lang_dirname']; ?>
</div>
							<input style="padding-left: 20px; width: 97%" type="text" name="<?php echo $this->_tpl_vars['name']; ?>
[<?php echo $this->_tpl_vars['lang']['lang_id']; ?>
]" value="<?php echo $this->_tpl_vars['field']['value'][$this->_tpl_vars['lang']['lang_id']]; ?>
" class="text" errors="<?php echo $this->_tpl_vars['field']['errors']; ?>
"/>
						</td>
					</tr>
<?php endforeach; endif; unset($_from); ?>
				</table>
<?php else: ?>
				<input type="text" name="<?php echo $this->_tpl_vars['name']; ?>
" value="<?php echo $this->_tpl_vars['field']['value']; ?>
" class="text" errors="<?php echo $this->_tpl_vars['field']['errors']; ?>
"/>
<?php endif; ?>
<?php endif; ?>
			</td>
		</tr>
<?php endforeach; endif; unset($_from); ?>
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