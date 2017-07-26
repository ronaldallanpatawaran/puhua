<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($thumb || $description) { ?>
      <div class="row">
        <?php if ($thumb) { ?>
        <div class="col-sm-2 gallery-images">
          <a class="thumbnail" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>">
          <img src="<?php echo $thumb; ?>" class="img-responsive" />
          </a>
        </div>
        <?php } ?>
        <?php if ($description) { ?>
        <div class="col-sm-10"><?php echo $description; ?></div>
        <?php } ?>
      </div>
      <hr>
      <?php } ?>
      <?php if ($gallimages) { ?>
      <div class="row gallery-images">
        <?php foreach ($gallimages as $gallimage) { ?>
        <div class="col-sm-3">
          <a class="thumbnail" href="<?php echo $gallimage['popup']; ?>" title="<?php echo $gallimage['title']; ?>"><img src="<?php echo $gallimage['thumb']; ?>" class="img-responsive" /></a>
        </div>
        <?php } ?>
      </div>  
      <?php } ?>  
    <?php echo $content_bottom; ?>    
    </div>
    <?php echo $column_right; ?>
  </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  $('.gallery-images').magnificPopup({
    type:'image',
    delegate: 'a',
    gallery: {
      enabled:true
    }
  });
});
//--></script> 
<?php echo $footer; ?> 