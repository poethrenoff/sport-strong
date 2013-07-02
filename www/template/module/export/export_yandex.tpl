<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="{$smarty.now|date_format:"%Y-%m-%d %H:%M"}">
	<shop>
		<name>Sport-Strong.RU</name>
		<company>Sport-Strong.RU</company>
		<url>http://sport-strong.ru/</url>
		<currencies>
			<currency id="RUR" rate="1"/>
		</currencies>
		<categories>
{foreach from=$catalogue_list item=catalogue_item}
			<category id="{$catalogue_item.catalogue_id}" parentId="{$catalogue_item.catalogue_parent}">{$catalogue_item.catalogue_title|escape}</category>
{/foreach}
		</categories>
		<offers>
{foreach from=$product_list item=product_item}
			<offer id="{$product_item.product_id}" available="{if $product_item.product_available}true{else}false{/if}">
				<url>http://sport-strong.ru/product.php?product_id={$product_item.product_id}</url>
				<price>{$product_item.product_price}</price>
				<currencyId>RUR</currencyId>
				<categoryId>{$product_item.product_catalogue}</categoryId>
				<picture>http://sport-strong.ru{$product_item.product_picture_small}</picture>
				<name>{$product_item.product_title|escape}</name>
				<vendor>{$product_item.brand_title|escape}</vendor>
				<description><![CDATA[{$product_item.product_preview}]]></description>
			</offer>
{/foreach}
		</offers>
	</shop>
</yml_catalog>
