<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->

<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->

<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>FavSub Viewer</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/lruf.css">

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

</head>
<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

    <div class="container-fluid">

		<div class="row-fluid">
			
			<div>
				<?php if(isset($body)) { echo $body; } ?>
			</div>
			
		</div>

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
<!--
<script>

	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];

	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];

	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';

	s.parentNode.insertBefore(g,s)}(document,'script'));

</script>
-->


</body>
</html>