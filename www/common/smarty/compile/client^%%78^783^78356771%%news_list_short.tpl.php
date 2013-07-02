<?php /* Smarty version 2.6.22, created on 2012-11-22 17:40:08
         compiled from module/news/news_list_short.tpl */ ?>
<?php if ($this->_tpl_vars['news_list']): ?>
<div class="newsbox" style="margin-top: 20px">
	<span class="newstitle">Новости</span>
<?php $_from = $this->_tpl_vars['news_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['news'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['news']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['news_item']):
        $this->_foreach['news']['iteration']++;
?>
	<p><span class="newsdate"><?php echo $this->_tpl_vars['news_item']['news_date']; ?>
</span><br><a href="<?php echo $this->_tpl_vars['news_item']['news_url']; ?>
"><?php echo $this->_tpl_vars['news_item']['news_title']; ?>
</a></p>
<?php endforeach; endif; unset($_from); ?>
	<a href="/news.php"><b>Все новости</b></a>
</div>
<?php endif; ?>