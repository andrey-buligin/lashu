<?php global $_CFG; if ($_CFG['Environment'] == 'live') :?>
	<script type="text/javascript" src="js/hanna.min.js"></script>
	<?php $this->loadGalleryRequiredJsFilesMin();?>
	<?php $this->loadRequiredJsFilesMin();?>
<?php else: ?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> <!-- jQuery Core -->
  <script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script> <!-- Google Map API -->
  <script type="text/javascript" src="<?php echo $this->getSkinJsUrl('bootstrap.min.js')?>"></script>
  <script type="text/javascript" src="<?php echo $this->getSkinJsUrl('supersized.3.2.7.min.js')?>"></script>
  <script type="text/javascript" src="<?php echo $this->getSkinJsUrl('waypoints.js')?>"></script>
  <script type="text/javascript" src="<?php echo $this->getSkinJsUrl('waypoints-sticky.js')?>"></script>
  <script type="text/javascript" src="<?php echo $this->getSkinJsUrl('jquery.isotope.js')?>"></script>
  <script type="text/javascript" src="<?php echo $this->getSkinJsUrl('jquery.fancybox.pack.js')?>"></script>
  <script type="text/javascript" src="<?php echo $this->getSkinJsUrl('jquery.fancybox-media.js')?>"></script>
	<script type="text/javascript" src="<?php echo $this->getSkinJsUrl('plugins.js')?>"></script>
	<?php $this->loadRequiredJsFiles();?>
	<?php $this->loadGalleryRequiredJsFiles();?>
	<script type="text/javascript" src="<?php echo $this->getSkinJsUrl('common.js')?>"></script>
<?php endif; ?>



<?php global $_CFG; if ($_CFG['Environment'] == 'live') :?>
	<script type="text/javascript">
      // var _gaq = _gaq || [];
      // _gaq.push(['_setAccount', 'UA-36089727-1']);
      // _gaq.push(['_trackPageview']);

      // (function() {
      //   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      //   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      //   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      // })();

      // var addthis_config = {
      //    data_ga_property: 'UA-36089727-1',
      //    data_ga_social : true
      // };
    </script>
<?php endif; ?>
