<?php /* Smarty version 2.6.22, created on 2013-05-17 07:48:15
         compiled from module/question/question_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'module/question/question_list.tpl', 5, false),)), $this); ?>
    <div id="text">
<h1>Вопросы</h1>
<?php if ($this->_tpl_vars['error']): ?>
<div class="error" style="color: red; font-weight: bold; text-align: center;">
	<?php echo ((is_array($_tmp=$this->_tpl_vars['error'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 
</div>
<?php endif; ?>

<!-- voprosy form -->

<div id="voprosy">
<span>Задать вопрос</span>
<form action="/question.php" method="post" enctype="multipart/form-data" onsubmit="return CheckForm.validate( this )">
<!--<input type="hidden" name="mode" value="form"/>-->
<input type="hidden" name="action" value="question_list"/>

<INPUT  name="question_author" value="Ваше Имя" errors="require" <?php echo 'onFocus="this.value=\'\'" onBlur="if (this.value==\'\'){this.value=\'Ваше Имя\'}"><br>'; ?>

<INPUT name="question_email" value="Ваш E-mail" errors="require|email"/ <?php echo ' onFocus="this.value=\'\'" onBlur="if (this.value==\'\'){this.value=\'Ваш E-mail\'}"><br>'; ?>

<textarea name="question_content" rows="6" cols="5" errors="require"<?php echo ' onFocus="this.value=\'\'" onBlur="if (this.value==\'\'){this.value=\'Ваш вопрос\'}" '; ?>
 >Ваш вопрос</textarea>
<div>
	<input type="hidden" name="captcha_id" value="<?php echo $this->_tpl_vars['captcha_id']; ?>
"/>
	<input style="width: 304px;" type="text" class="text" name="captcha_value" value="Введите число" errors="require|int" <?php echo 'onFocus="this.value=\'\'" onBlur="if (this.value==\'\'){this.value=\'Введите число\'}"'; ?>
/>
	<img style="width:80px;"  src="/image/captcha.php?captcha_id=<?php echo $this->_tpl_vars['captcha_id']; ?>
" alt="Контрольное число" align="top"/>
</div>
<?php echo '
<input type="submit" onClick="if($(\'input[name=question_author]\').val()==\'\' || $(\'input[name=question_author]\').val()==\'Ваше Имя\' || $(\'input[name=question_email]\').val()==\'\' || $(\'input[name=question_email]\').val()==\'Ваш E-mail\' || $(\'textarea[name=question_content]\').val()==\'\' || $(\'input[name=question_content]\').val()==\'Ваш вопрос\' || $(\'input[name=captcha_value]\').val()==\'\' || $(\'input[name=captcha_value]\').val()==\'Введите число\'){return false}" style="cursor:pointer;" class="otprbut" value="Отправить"/>
'; ?>

</form>
</div>
<div class="shadow"></div>
<!-- # voprosy form -->

<!-- voprosy -->
<div class="collapsebox">

<!-- BEGIN Custom show and hide -->
      <div id="collapse">
      <?php $_from = $this->_tpl_vars['question_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['question_item']):
?>
		<span><?php echo ((is_array($_tmp=$this->_tpl_vars['question_item']['question_author'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 : <?php echo $this->_tpl_vars['question_item']['question_content']; ?>
 </span>
	<!--	<div class="author">
			<?php echo ((is_array($_tmp=$this->_tpl_vars['question_item']['question_author'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
:
		</div>
		<div class="question">
			<?php echo $this->_tpl_vars['question_item']['question_content']; ?>
 
		</div>-->
		<div class="otvet">
		
		<?php if ($this->_tpl_vars['question_item']['question_answer']): ?>
		<i>Ответ:</i><br>
			<?php echo $this->_tpl_vars['question_item']['question_answer']; ?>
 
		<?php else: ?>
			Ответ на данный вопрос еще не получен
		<?php endif; ?>
		</div>
		<?php endforeach; endif; unset($_from); ?>
      </div>
	  
	  <?php echo '
	<link rel="stylesheet" href="css/collapse.css">
    <script>document.documentElement.className = "js";</script>
    <script src="js/json2.js"></script>
    <script src="js/jquery.collapse.js"></script>
    <script src="js/jquery.collapse_storage.js"></script>
    <script src="js/jquery.collapse_cookie_storage.js"></script>	  
      <script>
        new jQueryCollapse($("#collapse"), 
		{
          show: function() {
            this.slideDown(150);
          },
          hide: function() {
            this.slideUp(150);
          },
        });
      </script>
	  '; ?>

      <!-- END Custom show and hide -->

</div>
<!-- voprosy -->



<!-- pagination -->
<?php if ($this->_tpl_vars['pages']): ?>
<div class="paginav">
	Страницы: <?php echo $this->_tpl_vars['pages']; ?>
 
</div>
<?php endif; ?>
           <!-- <div class="paginav">
            	<div class="navig">&larr; предыдущая &nbsp; &nbsp; <a href="">следующая</a> &rarr;</div>
                <div id="dk">
                <b class="dm">1</b>
                <a class="dl" href="#">2</a>
                <a class="dl" href="#">3</a>
                <a class="dl" href="#">4</a>
                <a class="dl" href="#">5</a>
                <a class="dl" href="#">6</a>
                <a class="dl" href="#">7</a>
                <a class="dl" href="#">8</a>
                <a class="dl" href="#">…</a>
                </div>
            </div>-->
            <!-- #pagination -->
            
            
            




<!--
<div class="ask">
<script src="/script/check_form.js" type="text/javascript"></script>
<form action="/question.php" method="post" enctype="multipart/form-data" onsubmit="return CheckForm.validate( this )">
	<table class="question_table">
		<tr>
			<td class="title">
				Имя<span class="require">*</span>:
			</td>
			<td>
				<input type="hidden" name="mode" value="form"/>
				<input type="hidden" name="action" value="question"/>
				<input type="text" class="text" name="question_author" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['question_author'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Email<span class="require">*</span>:
			</td>
			<td>
				<input type="text" class="text" name="question_email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['question_email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" errors="require|email"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Вопрос<span class="require">*</span>:
			</td>
			<td>
				<textarea name="question_content" rows="5" cols="5" errors="require"><?php echo ((is_array($_tmp=$this->_tpl_vars['question_content'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
			</td>
		</tr>
		<tr>
			<td class="title">
				Введите число<span class="require">*</span>:
			</td>
			<td>
				<input type="hidden" name="captcha_id" value="<?php echo $this->_tpl_vars['captcha_id']; ?>
"/>
				<input type="text" class="text" name="captcha_value" value="" errors="require|int"/>
				<img src="/image/captcha.php?captcha_id=<?php echo $this->_tpl_vars['captcha_id']; ?>
" alt="Контрольное число" align="absbottom"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" class="button" value="Отправить"/>
			</td>
		</tr>
	</table>
</form>

</div>-->