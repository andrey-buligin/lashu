<?php global $_CFG; if ($_CFG['Environment'] == 'live') :?>
	<script type="text/javascript" src="js/hanna.min.js"></script>
	<?php $this->loadGalleryRequiredJsFilesMin();?>
	<?php $this->loadRequiredJsFilesMin();?>
<?php else: ?>
	<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
	<?php $this->loadRequiredJsFiles();?>
	<?php $this->loadGalleryRequiredJsFiles();?>
	<script type="text/javascript" src="js/plugins/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<?php echo $this->getSkinJsUrl('common.js')?>"></script>
<?php endif; ?>

<script type="text/javascript">
	Modernizr.load({
      test: Modernizr.touch,
      yep : 'js/plugins/jquery.animate-enhanced.min.js'
    });
</script>

<?php global $_CFG; if ($_CFG['Environment'] == 'live') :?>
	<script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-36089727-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

      var addthis_config = {
         data_ga_property: 'UA-36089727-1',
         data_ga_social : true
      };
    </script>
<?php endif; ?>

<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5095a7cf6d2d8dc2&amp;async=1"></script>
