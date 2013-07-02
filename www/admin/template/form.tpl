<script src="/admin/script/richedit.js" type="text/javascript"></script>
<script src="/admin/script/bbcode.js" type="text/javascript"></script>
<script src="/admin/script/calendar.js" type="text/javascript"></script>
<script src="/admin/script/check_form.js" type="text/javascript"></script>

<form id="form" action="index.php" method="post" enctype="multipart/form-data" onsubmit="rtoStore(); return CheckForm.validate( this )">
	<table class="record">
		<tr>
			<td colspan="2" align="left">
				<b>{$record_title}</b><br/>{$action_title}
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="button" value="Вернуться" class="button" onclick="location.href = '{$back_url}'"/>
			</td>
		</tr>
{foreach from=$fields key=name item=field}
		<tr>
			<td class="title">
				{$field.title}{if $field.require}<span class="require">*</span>{/if}:
			</td>
			<td class="field">
{if $field.type === 'boolean' || $field.type === 'active' || $field.type === 'default'}
				<input type="checkbox" name="{$name}" value="1" class="check" errors="{$field.errors}"{if $field.value === "1"} checked="checked"{/if}/>
{elseif $field.type === 'select' || $field.type === 'table' || $field.type === 'parent'}
				<select name="{$name}" class="list" errors="{$field.errors}">
					<option value=""/>
{foreach from=$field.values item=option}
					<option value="{$option.value|escape}"{if $option.value === $field.value} selected="selected"{/if}>{section name=offset start=0 loop=$option._depth}&nbsp;&nbsp;&nbsp;{/section}{$option.title|escape}</option>
{/foreach}
				</select>
{elseif $field.type === 'date' || $field.type === 'datetime'}
				<table class="date">
					<tr>
						<td>
							<input type="text" name="{$name}" value="{$field.value}" class="date" errors="{$field.errors}"/>
						</td>
						<td>
							<a href="" onclick="Calendar.show( document.forms['form']['{$name}'], this, '{if $field.type === 'date'}short{else}long{/if}' ); return false">
								<img src="/admin/image/calendar/calendar.gif" alt=""/>
							</a>
						</td>
						<td>
							<a href="" onclick="Calendar.now( document.forms['form']['{$name}'], '{if $field.type === 'date'}short{else}long{/if}' ); return false">
								<img src="/admin/image/calendar/check.gif" alt=""/>
							</a>
						</td>
					</tr>
				</table>
{elseif $field.type === 'image' || $field.type === 'file'}
				<table class="file">
					<tr>
						<td>
							<input type="file" name="{$name}_file" class="file" size="70%"/>
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="{$name}" value="{$field.value}" class="link"/>
						</td>
					</tr>
				</table>
{elseif $field.type === 'text'}
{if $field.textarea === 'editor'}
{if $field.translate}
				<table class="translate">
{foreach from=$lang_list item=lang}
					<tr>
						<td>
							<div class="editor">{$lang.lang_dirname}</div>
							<textarea id="{$name}_content_{$lang.lang_id}" cols="" rows="" class="hidden" errors="{$field.errors}">{$field.value[$lang.lang_id]}</textarea>
							<script type="text/javascript">
								var {$name}_editor_{$lang.lang_id} = new Editor( '{$name}[{$lang.lang_id}]' ); {$name}_editor_{$lang.lang_id}.create( '{$name}_content_{$lang.lang_id}' );
							</script>
						</td>
					</tr>
{/foreach}
				</table>
{else}
				<textarea id="{$name}_content" cols="" rows="" class="hidden" errors="{$field.errors}">{$field.value}</textarea>
				<script type="text/javascript">
					var {$name}_editor = new Editor( '{$name}' ); {$name}_editor.create( '{$name}_content' );
				</script>
{/if}
{else}
{if $field.translate}
				<table class="translate">
{foreach from=$lang_list item=lang}
					<tr>
						<td>
							<div class="textarea">{$lang.lang_dirname}</div>
							<textarea style="padding-left: 20px; width: 97%" name="{$name}[{$lang.lang_id}]" cols="" rows="" class="simple" errors="{$field.errors}">{$field.value[$lang.lang_id]}</textarea>
						</td>
					</tr>
{/foreach}
				</table>
{else}
				<textarea name="{$name}" cols="" rows="" class="simple" errors="{$field.errors}">{$field.value}</textarea>
{/if}
{/if}
{else}
{if $field.translate}
				<table class="translate">
{foreach from=$lang_list item=lang}
					<tr>
						<td>
							<div class="input">{$lang.lang_dirname}</div>
							<input style="padding-left: 20px; width: 97%" type="text" name="{$name}[{$lang.lang_id}]" value="{$field.value[$lang.lang_id]}" class="text" errors="{$field.errors}"/>
						</td>
					</tr>
{/foreach}
				</table>
{else}
				<input type="text" name="{$name}" value="{$field.value}" class="text" errors="{$field.errors}"/>
{/if}
{/if}
			</td>
		</tr>
{/foreach}
		<tr>
			<td colspan="2">
				<input type="submit" value="Сохранить" class="button"/>
{foreach from=$hidden key=name item=value}
				<input type="hidden" name="{$name}" value="{$value}"/>
{/foreach}
			</td>
		</tr>
	</table>
</form>
