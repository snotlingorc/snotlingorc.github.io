<?php

/*
 * True WYSIWYG
 * 	This theme is configured to use True WYSIWYG editing in gpEasy
 * 	If you modify the HTML or CSS for this theme, you may need to
 *  look at how the $GP_STYLES variable below affects editing
 * 	See: http://docs.gpeasy.org/index.php/Main/True_WYSIWYG
 *
 */
$GP_STYLES = array();
$GP_STYLES[] = '#content';
$GP_STYLES[] = '#footer';
$GP_STYLES[] = '#header';
$GP_STYLES[] = '#sidebar';


gpOutput::Area('link_label','<h2 class="links">%s</h2>');


?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<?php gpOutput::GetHead(); ?>
</head>
<body>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42538873-1', 'snotling.org');
  ga('send', 'pageview');

</script>

<div id="wrapper">
<div id="header">
	<div id="logo">
		<?php gpOutput::GetExtra('Header'); ?>
	</div>
	<!-- end #logo -->
	<div id="menu">
		<?php gpOutput::GetMenu(); ?>
	</div>
	<!-- end #menu -->
</div>
<!-- end #header -->
<div id="page">
	<div id="content">

	<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_google_plusone" g:plusone:count="false"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51d5977820c0cabd"></script>
<!-- AddThis Button END -->

			<?php $page->GetContent(); ?>

	</div>

	<!-- end #content -->
	<div id="sidebar">
		<div id="sidebar-bgtop"></div>
		<div id="sidebar-content">
			<?php gpOutput::GetArea('link_label','Links'); ?>
			<?php gpOutput::GetFullMenu(); ?>
			<?php gpOutput::GetExtra('Side_Menu'); ?>
			<?php gpOutput::GetAllGadgets() ?>
		</div>
		<div id="sidebar-bgbtm">
		</div>
	</div>
	<!-- end #sidebar -->
</div>
<!-- end #page -->
<div id="footer">
	<?php gpOutput::GetExtra('Footer'); ?>
	<?php gpOutput::GetAdminLink(); ?>

	<p>Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
</div>
<!-- end #footer -->

</div>
</body>
</html>
