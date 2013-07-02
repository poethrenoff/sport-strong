<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog>
	<shop>
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
			<offer id="{$product_item.product_id}" type="vendor.model">
				<url>http://www.activsport.ru/product.php?product_id={$product_item.product_id}</url>
				<price>{$product_item.product_price}</price>
				<currencyId>RUR</currencyId>
				<categoryId>{$product_item.product_catalogue}</categoryId>
				<picture>http://www.activsport.ru{$product_item.product_picture_small}</picture>
				<vendor>{$product_item.brand_title|escape}</vendor>
				<model>{$product_item.product_title|escape}</model>
				<description><![CDATA[{$product_item.product_preview}]]></description>
			</offer>
{/foreach}
		</offers>
	</shop>
</yml_catalog>
