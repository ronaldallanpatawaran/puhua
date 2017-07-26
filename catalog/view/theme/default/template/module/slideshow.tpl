<div class="master-slider ms-skin-default" id="masterslider<?php echo $module; ?>">
  <?php $i = 1; foreach ($banners as $banner) { ?>
  <div class="ms-slide slide-<?php echo $i; ?>" data-delay="3">
    <img src="<?php echo $blank_gif; ?>" data-src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">
    <?php if ($banner['link'] || $banner['description'] || $banner['title']) { ?>
    <div class="ms-layer ms-caption" style="top:0px; left:0px; width:<?php echo $width; ?>px; text-align:center;">
      <?php if ($banner['title']) { ?> 
      <div class="ms-slide-title"><?php echo $banner['title']; ?></div>
      <?php } ?>
      <?php if ($banner['link']) { ?> 
      <a href="<?php echo $banner['link']; ?>"><?php echo $banner['title']; ?></a>
      <?php } ?>
      <?php if ($banner['description']) { ?>
      <div class="ms-slide-desc"><?php echo $banner['description']; ?></div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
  <?php $i++; } ?>
</div>
<script type="text/javascript">     
var slider = new MasterSlider();

slider.control('arrows' ,{insertTo:'#masterslider<?php echo $module; ?>'});  
slider.control('bullets'); 

slider.setup('masterslider<?php echo $module; ?>' , {
  // loop: true,
  autoplay: true,
  // shuffle: true,
  width: <?php echo $width; ?>,
  height: <?php echo $height; ?>,
  space: 0,
  view: '<?php echo $view; ?>',
  layout: '<?php echo $layout; ?>',
  fullscreenMargin: 57,
  speed: 20
});
</script>
<style type="text/css">
.ms-view {
  background: transparent;
}
</style>