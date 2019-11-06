<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->

<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->

<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php if(isset($title)) { echo $title; } else { ?>FavSub Viewer<?php } ?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/lruf.css">
    <?php if(isset($follow_noindex)): ?>
    <meta name="robots" content="noindex, follow">
    <?php endif; ?>

	<style>

	body {

	  padding-top: 60px;

	  padding-bottom: 40px;

	}

	</style>

	<link rel="stylesheet" href="/css/bootstrap-responsive.css">

	<link rel="stylesheet" href="/css/style.css">

<?php

if(isset($css_files))
{
	if(is_array($css_files))
	{
		foreach($css_files as $css_file)
		{
			echo HTML::style($css_file);
		}
	}
}

?>

	<script src="/js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script>
<!-- 	<link rel="manifest" href="/manifest.json">	
	<script>
	    var OneSignal = window.OneSignal || [];
	    OneSignal.push(["init", {
	      appId: "326c5f1c-6ed8-4387-9ceb-1e4542b224d4",
	      autoRegister: true,
	      notifyButton: {
	        enable: true /* Set to false to hide */
	      }
	    }]);
	</script>
  	<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script> -->

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-6457690957209905",
          enable_page_level_ads: true
     });
</script>

</head>
<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->



    <div class="navbar navbar-fixed-top">

      <div class="navbar-inner">

        <div class="container-fluid">

          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

          </a>

          <a class="brand" href="/bookmarks">FavSub</a>

          <div class="nav-collapse">

            <ul class="nav">

            </ul>

		    <form class="navbar-search pull-left" method="GET" action="/bookmarks">
			    <input type="text" class="search-query span6" placeholder="Search" name="q" value="<?php if(isset($_GET['q'])) { echo UTF8::clean($_GET['q']); } ?>">
	    	</form>
    
          </div><!--/.nav-collapse -->

        </div>

      </div>

    </div>



    <div class="container-fluid">

		<div class="row-fluid">
			<div class="span3">

<?php if(FALSE): ?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6457690957209905";
/* FavSub-WideSky120x600 */
google_ad_slot = "9919759715";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<?php endif; ?>
			<!--
				<form class="well">
					<input type="text" class="input-small" placeholder="Email">
					<input type="password" class="input-small" placeholder="Password">
					<button type="submit" class="btn">Login</button>
				</form>
			-->
				<?php if(isset($tags)): ?>
				<h3>Tags</h3>
				<ul class="unstyled">
				<?php foreach($tags as $tag): ?>
					<?php if($tag['name'] == 'NSFW') continue; ?>
					<?php echo '<li>' . HTML::anchor('bookmarks/tag/'.$tag['name'], $tag['name']) . ' (' . number_format($tag['cnt']) . ')</li>'.PHP_EOL; ?>
				<?php endforeach; ?>
					<?php echo '<li>' . HTML::anchor('bookmarks/tagless/', '[Tagless]') . '</li>'.PHP_EOL; ?>
				</ul>
				<?php endif; ?>
			</div>
			
			<div class="span9">
				<?php if(isset($body)) { echo $body; } ?>
			</div>
		</div>
      <hr>



      <footer>

        <p>&copy; Company 2012</p><?php if($logged_in): ?> - <a href="javascript:q=location.href;if(document.getSelection){d=document.getSelection();}else{d='';};p=document.title;r=document.referrer;wn='favsub_'+Math.random();void(open('http://favsub.com/bookmarks/add?url='+encodeURIComponent(q)+'&description='+encodeURIComponent(d)+'&title='+encodeURIComponent(p)+'&ref='+encodeURIComponent(r),wn,'toolbar=no,width=700,height=350'));">FS!</a> <?php endif; ?>

      </footer>



    </div> <!-- /container -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>



<script src="/js/libs/bootstrap/transition.js"></script>

<script src="/js/libs/bootstrap/collapse.js"></script>



<script src="/js/script.js"></script>
<?php

if(isset($js_files))
{
	if(is_array($js_files))
	{
		foreach($js_files as $js_file)
		{
			echo HTML::script($js_file);
		}
	}
}

?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  
  ga('create', 'UA-244970-24', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>

<!-- Piwik --> 
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["setCookieDomain", "*.stats.lruf.com"]);
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://stats.lruf.com/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "1"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->

<?php
    /**
<script type="text/javascript">
  var vglnk = { api_url: '//api.viglink.com/api',
                key: 'c48c1a0d91b5662f28afb8827ad4a770' };

  (function(d, t) {
    var s = d.createElement(t); s.type = 'text/javascript'; s.async = true;
    s.src = ('https:' == document.location.protocol ? vglnk.api_url :
             '//cdn.viglink.com/api') + '/vglnk.js';
    var r = d.getElementsByTagName(t)[0]; r.parentNode.insertBefore(s, r);
  }(document, 'script'));
</script>
**/
    ?>
</body>
</html>
