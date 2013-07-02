<div>
{foreach from=$catalogue_tree item=item}
{if $item._depth}
	<div class="menu_category">
		<a href="{$item.catalogue_url}">{$item.catalogue_short_title|escape}</a>
	</div>
{else}
	</div>
	<div class="menu_group">
		<a href="{$item.catalogue_url}">{$item.catalogue_short_title|escape}</a>
	
{/if}
{/foreach}
</div>