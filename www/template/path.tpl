<!--noindex--><div class="crumbs">
{foreach from=$path item=item name=path}
{if $item.url}<a href="{$item.url}">{$item.title|escape}</a>{else}<span>{$item.title|escape}</span>{/if}{if !$smarty.foreach.path.last} / {/if}
{/foreach}
</div><!--/noindex-->
