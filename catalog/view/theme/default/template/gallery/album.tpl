<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="container">
  <div class="row">
    <?php if ($categories) { ?>
      <div class="row">
        <div class="banner_navigation col-sm-12">
        <?php foreach ($categories as $category) { ?>
          <?php $class = $category['category_id'] == $gcat ? "active" : ""; ?>
          <a href="<?php echo $category['href']; ?>"><button class="<?php echo $class; ?>"><?php echo $category['name']; ?></button></a> &nbsp;
        <?php } ?>
        </div>  
      </div>
      <?php } ?>
  </div>
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
    <?php $class = 'col-sm-10 col-sm-offset-1'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
      <?php if ($gallalbums) { ?>
      <div class="row">
        <?php foreach ($gallalbums as $gallalbum) { ?>
        <div class="col-md-3">
          <div class="image text-center"><a href="<?php echo $gallalbum['href']; ?>"><img src="<?php echo $gallalbum['thumb']; ?>" alt="<?php echo $gallalbum['name']; ?>" title="<?php echo $gallalbum['name']; ?>" /></a></div>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if (!$categories && !$gallalbums) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?> 