<?php /* Smarty version 2.6.22, created on 2012-09-16 14:53:10
         compiled from module/news/news_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/news/news_list.tpl', 6, false),)), $this); ?>
<h1>Новости</h1>
<?php $_from = $this->_tpl_vars['news_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['news_item']):
?>
		 	<div class="news_block">
				<p class="news">
					<b><?php echo $this->_tpl_vars['news_item']['news_date']; ?>
</b><br />
					<a href="<?php echo $this->_tpl_vars['news_item']['news_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['news_item']['news_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
				</p>
				<?php echo $this->_tpl_vars['news_item']['news_announce']; ?>
<br/>
			</div>
<?php endforeach; endif; unset($_from); ?>

<?php echo $this->_tpl_vars['pages']; ?>
