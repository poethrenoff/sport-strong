<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>{$meta.title|escape}</title>
		<meta name="keywords" content="{$meta.keywords|escape}" />
		<meta name="description" content="{$meta.description|escape}" />
		<meta name='yandex-verification' content='7f30c80fcdbbb5f2' />

<link href="/style/index.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="/favicon.ico" />
<script type="text/javascript" src="/js/jquery-1.8.0.min.js"></script>    
{literal}
<!--[if IE 6]>
<script src="js/png.js"></script>
<script>DD_belatedPNG.fix('img');</script>
<![endif]-->
<!--[if lt IE 7]>
<style media="screen" type="text/css">#container {height:100%;}</style>
<![endif]-->
<!--[if IE]>
  <link rel="stylesheet" type="text/css" href="styles/ie.css" />
<![endif]-->

<!-- slides -->

<link href="/style/slide.css" rel="stylesheet" type="text/css" />
	<script src="/js/jquery.easing.1.3.js"></script>
	<script src="/js/slides.min.jquery.js"></script>
	<script src="/js/jquery.form.min.js"></script>
	<script src="/js/jquery.simplemodal.1.4.4.min.js"></script>
	<script>
		jQuery(function(){
			jQuery('#slides').slides({
				preload: true,
				preloadImage: 'image/loading.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true
			});
		});
	</script>
    
<!-- tabs -->   
<link href="/style/tabs.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" href="/style/collapse.css">
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function(){
	jQuery("#tabs li").click(function() {
		//	First remove class "active" from currently active tab
		jQuery("#tabs li").removeClass('active');

		//	Now add class "active" to the selected/clicked tab
		jQuery(this).addClass("active");

		//	Hide all tab content
		jQuery(".tab_content").hide();

		//	Here we get the href value of the selected tab
		var selected_tab = jQuery(this).find("a").attr("href");

		//	Show the selected tab content
		jQuery(selected_tab).fadeIn();
		jQuery(selected_tab).fadeIn();

		//	At the end, we add return false so that the click on the link is not executed
		return false;
	});
	
	$('.action_marker img').mouseover(function(){
		$('.action_marker .action_text').show('slow');
	}).mouseout(function(){
		$('.action_marker .action_text').hide('slow');
	});
	
	function blickSkidki() {
		$('.skidki').animate({opacity: 0.50}, 750).animate({opacity: 1}, 750);
	}
	setInterval(blickSkidki, 1500); blickSkidki();
});

// Обратный звонок
function callback_window() {
	var ajax_callback_form = function(){
		$('#callback_form').ajaxForm({
			target: '#popup_content', success: ajax_callback_form, beforeSubmit: check_callback_form
		});
	};

	var check_callback_form = function(){
		return CheckForm.validate( document.getElementById('callback_form') );
	};

	$.post('/callback.php', {}, function(data){
		$('#popup_content').html(data); ajax_callback_form();
		$('#popup').modal({
			opacity:30, overlayCss:{backgroundColor:'#000'}, overlayClose:true
		});
	}, 'html');

	return false;
}
/* ]]> */
</script>
{/literal}

</head>
<body>
<div id="container" >
<div class="wrap">

	<!-- header-->
	<div id="header">
	
		<div class="topmenu">
		<ul>
			<li><a href="/">Главная</a></li>
			<li><a href="/about.php">О компании</a></li>
			<li><a href="/delivery.php">Доставка и оплата</a></li>
			<!--<li><a href="/price.php">Прайс-лист</a></li>-->
			<!--<li><a href="#">Новости</a></li>-->
			{$brand}
			<li><a href="/question.php">Вопросы</a></li>
			<li><a href="/contact.php">Контактная информация</a></li>
			<li><a href="/article.php">Статьи</a></li>
        </ul>
		
		<noindex><nofollow>
		<div id="social">
			<a href="http://vk.com/sportstrongru" id="vk">В контакте</a>
			<a href="http://facebook.com/sportstrong.ru" id="fb">Facebook</a>
		</div>
		</nofollow></noindex>
		
        </div>
        
        <div class="logobox">
        	
            <div class="logo">
            <a href="/"><img src="/image/logo.png" width="266" alt=""></a>
            </div>
            
            <div class="phones">
(916) 810 09 02<br>(495) 778 66 59<br><a href="/callback.php" class="callback" onclick="return callback_window()">Заказать обратный звонок</a>
            </div>
            {literal}
			<form action="/search.php" id="search" name="search" method="get" onsubmit="return ( this.search_value.value.length > 0 )">
            <div class="searchbox">
			<div class="sb">
			<INPUT id="search_value" name="search_value" value="Поиск" onFocus="this.value=''" onBlur="if (this.value==''){this.value='Поиск'}">
			<a href="#" class="searchbut" onclick="document.forms['search'].submit();"><img src="/image/lupa.gif" width="13"></a>
			</div>
			</div>
            </form>
            <div class="cart" onclick="location.href = '../cart.php'">
			{/literal}
				{$cart}
			</div>
            
        <div class="clear"></div></div>
	

    <div class="clear"></div>
    </div>
    <!-- #header-->


    <!-- body-->
    <div id="body">
    <div style="position:absolute;top:150px;right:0px;">
    <div class="share42init" data-top2="0" data-top1="130"></div>
    <script type="text/javascript" src="http://sport-strong.ru/share42/share42.js"></script> 
    </div>
    	<div class="bodybox">
        
        <!-- left -->
        <div id="left">
        
        	<div class="ski"><a href="/skidki.php" class="skidki">Скидки</a></div>
            
            <div class="leftmenubox">
            <span class="lmtitle">Каталог</span>
            { $menu }
			</div><!-- # leftmenubox-->
            <!-- news box -->
            <!--noindex-->{ $news }<!--/noindex-->
            <!-- # news box -->
        
        </div>
        <!-- #left -->
        
        <!-- right -->
        <div id="right">
        
        	<!-- slide box -->
			{if $main_page_flag==1}
            <div class="slidebox">
            
                <div id="slides">
                    <div class="slides_container">
                        <a href=""><img src="../image/1pic.jpg" width="750" alt=""></a>
                        <a href=""><img src="../image/2pic.jpg" width="750" alt=""></a>
                        <a href=""><img src="../image/3pic.jpg" width="750" alt=""></a>
                    </div>
                </div>
                
            </div>
            <!-- #slide box -->
            
            <!-- catalog -->
			
            <div id="catalog">
            	<div class="cattitle"><span>Каталог продукции</span></div>
               <table class="cattab">
                <tbody>
                <tr>
                <td width="20%">
                    <div class="catimg"><a href="../begovye_dorozhki_dlya_doma/"><img src="../image/cat1.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../begovye_dorozhki_dlya_doma/">Беговые дорожки</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../velotrenazhery_dlya_doma/"><img src="../image/cat2.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../velotrenazhery_dlya_doma/">Велотренажеры</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../ellipticheskie_trenazhery_dlya_doma/"><img src="../image/cat3.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../ellipticheskie_trenazhery_dlya_doma/">Эллиптические тренажеры</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../steppery_dlya_doma/"><img src="../image/cat4.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../steppery_dlya_doma/">Степперы</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../catalogue.php?catalogue_id=59"><img src="../image/cat5.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../catalogue.php?catalogue_id=59">Министепперы</a></div></div>
                </td>
                </tr>
                <tr>
                <td width="20%">
                    <div class="catimg"><a href="../catalogue.php?catalogue_id=23"><img src="../image/cat6.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../catalogue.php?catalogue_id=23">Универсал.тренажеры, министадионы</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../grebnye_trenazhery_dlya_doma/"><img src="../image/cat7.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../grebnye_trenazhery_dlya_doma/">Гребные тренажеры</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg">
					<a href="../catalogue.php?catalogue_id=25"><img src="../image/cat8.jpg" width="146" alt="/catalogue.php?catalogue_id=25"></a></div>
                    <div class="catlink"><div class="cl"><a href="../catalogue.php?catalogue_id=25">Вибромассажеры, виброплатформы</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../silovye_trenazhery_dlya_doma/"><img src="../image/cat9.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../silovye_trenazhery_dlya_doma/">Силовые тренажеры, мультистанции</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../catalogue.php?catalogue_id=46"><img src="../image/cat10.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../catalogue.php?catalogue_id=46">Детские тренажеры</a></div></div>
                </td>
                </tr>
                <tr>
                <td width="20%">
                    <div class="catimg"><a href="../catalogue.php?catalogue_id=29"><img src="../image/cat11.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../catalogue.php?catalogue_id=29">Диски, блины, грифы для штанги</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../catalogue.php?catalogue_id=27"><img src="../image/cat12.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../catalogue.php?catalogue_id=27">Гантели</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../catalogue.php?catalogue_id=30"><img src="../image/cat13.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../catalogue.php?catalogue_id=30">Мячи, фитнес аксессуары</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../bokserskij_vodonalivnoj_meshok/"><img src="../image/cat14.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../bokserskij_vodonalivnoj_meshok/">Водоналивные боксерские мешки</a></div></div>
                </td>
                <td width="20%">
                	<div class="catimg"><a href="../detskiy_batut_dlya_dachi/"><img src="../image/cat15.jpg" width="146" alt=""></a></div>
                    <div class="catlink"><div class="cl"><a href="../detskiy_batut_dlya_dachi/">Батуты для дома и дачи</a></div></div>
                </td>
                </tr>
                </tbody>
                </table>
            </div>
            
			<!-- #catalog -->
            
            
            <!-- tabs -->
            <div class="tabsbox">
				{$output_marker_list}
			</div>
            <!-- #tabs -->

			{/if}
            
            <!-- text -->
{$path}
{if $main_page_flag==1}<div class="content_place">{else}<div>{/if}
{$content}
</div>
            <!-- #text -->
            
        
        </div>
        <!-- #right -->
        
        <div class="clear"></div></div>
    
    <div class="clear"></div>
    </div>
    <!-- #body-->
    
  <!-- footer-->
	<div id="footer">
	
    	<div class="f1">© 2013 Sport-Strong.ru <a href="/map.php">Карта сайта</a></div>
        
        <div class="f2">
<span>+7 (916) 810 09 02, +7 (495) 778 66 59</span><br>
e-mail:  sport-strong@yandex.ru <br>

        </div>
        {if $main_page_flag==1}
        <div class="f3">
		  
        </div>
		{/if}
    <div class="clear"></div>
  </div>
	<!-- #footer-->
	<div class="clear"></div>
	<div style="    bottom: 5px;
    position: absolute;">
	{literal}
<!--noindex-->

<div >
<!-- begin of Top100 code -->

<script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?2707295"></script>
<noscript>
<a href="http://top100.rambler.ru/navi/2707295/">
<img src="http://counter.rambler.ru/top100.cnt?2707295" alt="Rambler's Top100" border="0" />
</a>

</noscript>
<!-- end of Top100 code -->
</div>
<noindex><nofollow>
<!-- Yandex.Metrika informer -->
<a href="http://metrika.yandex.ru/stat/?id=22210366&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/22210366/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="??????.???????" title="??????.???????: ?????? ?? ??????? (?????????, ?????? ? ?????????? ??????????)" onclick="try{Ya.Metrika.informer({i:this,id:22210366,lang:'ru'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter22210366 = new Ya.Metrika({id:22210366,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/22210366" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t44.5;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet' "+
"border='0' width='31' height='31'><\/a>")
//--></script><!--/LiveInternet-->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25965858-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>﻿
									<!--Rating@.ru counter-->
									<script language="javascript" type="text/javascript">//<![CDATA[
									d=document;var a='';a+=';r='+escape(d.referrer);js=10;//]]></script>
									<script language="javascript1.1" type="text/javascript">//<![CDATA[
									a+=';j='+navigator.javaEnabled();js=11;//]]></script>
									<script language="javascript1.2" type="text/javascript">//<![CDATA[
									s=screen;a+=';s='+s.width+'*'+s.height;
									a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;//]]></script>
									<script language="javascript1.3" type="text/javascript">//<![CDATA[
									js=13;//]]></script><script language="javascript" type="text/javascript">//<![CDATA[
									d.write('<img src="http://d4.c1.ba.a1.top.mail.ru/counter?id=1709195;js='+js+
									a+';rand='+Math.random()+'" height="1" width="1" alt="top.mail.ru" border="0" />');
									if(11<js)d.write('<'+'!-- ');//]]></script>
									<noscript><img src="http://d4.c1.ba.a1.top.mail.ru/counter?js=na;id=1709195"
									height="1" width="1" alt="top.mail.ru" border="0" /></noscript>
									<script language="javascript" type="text/javascript">//<![CDATA[
									if(11<js)d.write('--'+'&#062');//]]></script>
									<!--// Rating@Mail.ru counter-->

									<!--Rating@Mail.ru logo-->
									<a target="_top" href="http://top.mail.ru/jump?from=1709195">
									<img src="http://d4.c1.ba.a1.top.mail.ru/counter?id=1709195;t=231;l=1"
									border="0" height="31" width="88" alt="Рейтинг@Mail.ru" /></a>
									<!--// Rating@Mail.ru logo-->
									
<!--/noindex-->
{/literal}
	</div>
</div>   
</div><!-- #container-->  
</nofollow></noindex>

	<!-- Popup -->  
	<div id="popup">
		<div id="window">
			<a class="close simplemodal-close" href="#" title="закрыть"></a>
			<div class="clear"></div>
			<div id="popup_content"></div>
			<div class="clear"></div>
		</div>
		<div id="window_bottom"></div>
	</div>

	<!-- BEGIN cloudim code {literal} -->
	<script type="text/javascript" charset="utf-8">document.write(unescape("%3Cdiv id='cloudim_widget'%3E%3Cscript src='http://static.cloudim.ru/js/chat.js' type='text/javascript'%3E%3C/script%3E%3C/div%3E"));</script> <div id="cloudim_cr" style="position:absolute; left:-9999px;">Cloudim - <a target="_blank" href="http://cloudim.ru/">онлайн консультант для сайта</a> бесплатно.</div>
	<script type="text/javascript" charset="utf-8">
	Cloudim.Chat.init({uid:11545});
	</script>
	<!-- {/literal} END cloudim code -->

</body>
</html>