<div id="banner<?php echo $module; ?>" class="banners <?php if (count($banners) > 1) { ?>owl-carousel<?php } ?>">
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <?php if ($banner['link']) { ?>
    <h1><?php echo $banner['description']; ?></h1>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <center><h1 class="banner_description"><?php echo $banner['description']; ?></h1></center>
    <?php } ?>
  </div>
  <?php } ?>
</div>
<?php if (count($banners) > 1) { ?>
<script type="text/javascript"><!--
$('#banner<?php echo $module; ?>').owlCarousel({
  items: 6,
  autoPlay: 3000,
  singleItem: true,
  navigation: false,
  pagination: false,
  transitionStyle: 'fade'
});
--></script>
<?php } ?>