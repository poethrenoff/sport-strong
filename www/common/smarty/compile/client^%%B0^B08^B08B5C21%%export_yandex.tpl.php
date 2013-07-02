<?php /* Smarty version 2.6.22, created on 2012-09-04 13:11:44
         compiled from module/export/export_yandex.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'module/export/export_yandex.tpl', 5, false),array('modifier', 'escape', 'module/export/export_yandex.tpl', 15, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="UTF-8"<?php echo '?>'; ?>

<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
">
	<shop>
		<name>Sport-Strong.RU</name>
		<company>Sport-Strong.RU</company>
		<url>http://sport-strong.ru/</url>
		<currencies>
			<currency id="RUR" rate="1"/>
		</currencies>
		<categories>
<?php $_from = $this->_tpl_vars['catalogue_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['catalogue_item']):
?>
			<category id="<?php echo $this->_tpl_vars['catalogue_item']['catalogue_id']; ?>
" parentId="<?php echo $this->_tpl_vars['catalogue_item']['catalogue_parent']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['catalogue_item']['catalogue_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</category>
<?php endforeach; endif; unset($_from); ?>
		</categories>
		<offers>
<?php $_from = $this->_tpl_vars['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product_item']):
?>
			<offer id="<?php echo $this->_tpl_vars['product_item']['product_id']; ?>
" available="<?php if ($this->_tpl_vars['product_item']['product_available']): ?>true<?php else: ?>false<?php endif; ?>">
				<url>http://sport-strong.ru/product.php?product_id=<?php echo $this->_tpl_vars['product_item']['product_id']; ?>
</url>
				<price><?php echo $this->_tpl_vars['product_item']['product_price']; ?>
</price>
				<currencyId>RUR</currencyId>
				<categoryId><?php echo $this->_tpl_vars['product_item']['product_catalogue']; ?>
</categoryId>
				<picture>http://sport-strong.ru<?php echo $this->_tpl_vars['product_item']['product_picture_small']; ?>
</picture>
				<name><?php echo ((is_array($_tmp=$this->_tpl_vars['product_item']['product_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</name>
				<vendor><?php echo ((is_array($_tmp=$this->_tpl_vars['product_item']['brand_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</vendor>
				<description><![CDATA[<?php echo $this->_tpl_vars['product_item']['product_preview']; ?>
]]></description>
			</offer>
<?php endforeach; endif; unset($_from); ?>
		</offers>
	</shop>
</yml_catalog>