<?php /* Smarty version 2.6.22, created on 2012-09-16 14:33:58
         compiled from module/article/article_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/article/article_list.tpl', 7, false),)), $this); ?>
<?php echo $this->_tpl_vars['path']; ?>


<h1>Статьи</h1>

<?php $_from = $this->_tpl_vars['article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['article_item']):
?>
<div class="article_title">
	<a href="<?php echo $this->_tpl_vars['article_item']['article_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['article_item']['article_title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
</div>
<div class="article_announce">
	<?php echo $this->_tpl_vars['article_item']['article_announce']; ?>
 
</div>
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['pages']): ?>
<div class="pages">
	Страницы: <?php echo $this->_tpl_vars['pages']; ?>

</div>
<?php endif; ?>