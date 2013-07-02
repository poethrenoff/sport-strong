<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
	<head>
		<title>{$title}</title>
		<link rel="stylesheet" href="/admin/style/index.css" type="text/css"/>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body>
		<table class="main">
			<tr>
				<td class="menu">
					<div class="logo">
						<a href="/admin/" title="Admin&amp;K&deg;"><img src="/admin/image/logo.jpg" alt="Admin&amp;K&deg;"/></a>
					</div>
{foreach from=$system_map item=item}
{if $item._depth}
{section name=offset start=0 loop=$item._depth}<div class="tree_offset">{/section} 
{/if}
{if $item.system_map_object}
	<a href="index.php?object={$item.system_map_object}"{if $item._selected} class="selected"{/if}>{$item.system_map_title}</a><br/>
{else}
	<b>{$item.system_map_title}</b><br/>
{/if}
{if $item._depth}
{section name=offset start=0 loop=$item._depth}</div>{/section} 
{/if}
{foreachelse}
					&nbsp;
{/foreach}
<!--a href="index.php?object=q">Вопросы с сайта</a-->
				</td>
				<td class="content">
{if $error}
					<div class="error">{$error}</div>
{elseif $content}
{$content}
{else}
&nbsp;
{/if}
				</td>
			</tr>
		</table>
	</body>
</html>
