    <div id="text">
<h1>Вопросы</h1>
{if $error}
<div class="error" style="color: red; font-weight: bold; text-align: center;">
	{$error|escape} 
</div>
{/if}

<!-- voprosy form -->

<div id="voprosy">
<span>Задать вопрос</span>
<form action="/question.php" method="post" enctype="multipart/form-data" onsubmit="return CheckForm.validate( this )">
<!--<input type="hidden" name="mode" value="form"/>-->
<input type="hidden" name="action" value="question_list"/>

<INPUT  name="question_author" value="Ваше Имя" errors="require" {literal}onFocus="this.value=''" onBlur="if (this.value==''){this.value='Ваше Имя'}"><br>{/literal}
<INPUT name="question_email" value="Ваш E-mail" errors="require|email"/ {literal} onFocus="this.value=''" onBlur="if (this.value==''){this.value='Ваш E-mail'}"><br>{/literal}
<textarea name="question_content" rows="6" cols="5" errors="require"{literal} onFocus="this.value=''" onBlur="if (this.value==''){this.value='Ваш вопрос'}" {/literal} >Ваш вопрос</textarea>
<div>
	<input type="hidden" name="captcha_id" value="{$captcha_id}"/>
	<input style="width: 304px;" type="text" class="text" name="captcha_value" value="Введите число" errors="require|int" {literal}onFocus="this.value=''" onBlur="if (this.value==''){this.value='Введите число'}"{/literal}/>
	<img style="width:80px;"  src="/image/captcha.php?captcha_id={$captcha_id}" alt="Контрольное число" align="top"/>
</div>
{literal}
<input type="submit" onClick="if($('input[name=question_author]').val()=='' || $('input[name=question_author]').val()=='Ваше Имя' || $('input[name=question_email]').val()=='' || $('input[name=question_email]').val()=='Ваш E-mail' || $('textarea[name=question_content]').val()=='' || $('input[name=question_content]').val()=='Ваш вопрос' || $('input[name=captcha_value]').val()=='' || $('input[name=captcha_value]').val()=='Введите число'){return false}" style="cursor:pointer;" class="otprbut" value="Отправить"/>
{/literal}
</form>
</div>
<div class="shadow"></div>
<!-- # voprosy form -->

<!-- voprosy -->
<div class="collapsebox">

<!-- BEGIN Custom show and hide -->
      <div id="collapse">
      {foreach item=question_item from=$question_list}
		<span>{$question_item.question_author|escape} : {$question_item.question_content} </span>
	<!--	<div class="author">
			{$question_item.question_author|escape}:
		</div>
		<div class="question">
			{$question_item.question_content} 
		</div>-->
		<div class="otvet">
		
		{if $question_item.question_answer}
		<i>Ответ:</i><br>
			{$question_item.question_answer} 
		{else}
			Ответ на данный вопрос еще не получен
		{/if}
		</div>
		{/foreach}
      </div>
	  
	  {literal}
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
	  {/literal}
      <!-- END Custom show and hide -->

</div>
<!-- voprosy -->



<!-- pagination -->
{if $pages}
<div class="paginav">
	Страницы: {$pages} 
</div>
{/if}
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
				<input type="text" class="text" name="question_author" value="{$question_author|escape}" errors="require"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Email<span class="require">*</span>:
			</td>
			<td>
				<input type="text" class="text" name="question_email" value="{$question_email|escape}" errors="require|email"/>
			</td>
		</tr>
		<tr>
			<td class="title">
				Вопрос<span class="require">*</span>:
			</td>
			<td>
				<textarea name="question_content" rows="5" cols="5" errors="require">{$question_content|escape}</textarea>
			</td>
		</tr>
		<tr>
			<td class="title">
				Введите число<span class="require">*</span>:
			</td>
			<td>
				<input type="hidden" name="captcha_id" value="{$captcha_id}"/>
				<input type="text" class="text" name="captcha_value" value="" errors="require|int"/>
				<img src="/image/captcha.php?captcha_id={$captcha_id}" alt="Контрольное число" align="absbottom"/>
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
