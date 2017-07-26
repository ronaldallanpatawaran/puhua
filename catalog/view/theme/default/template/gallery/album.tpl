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
      <?php if ($categories) { ?>
      <h3><?php echo $text_category; ?></h3>
      <div class="row">
        <?php foreach ($categories as $category) { ?>
        <div class="col-sm-4">
          <div class="image text-center"><a href="<?php echo $category['href']; ?>"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" class="img-responsive" /></a></div>
          <div class="name text-center"><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></div>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if ($gallalbums) { ?>
      <h3><?php echo $text_album; ?></h3>
      <div class="row">
        <?php foreach ($gallalbums as $gallalbum) { ?>
        <div class="col-sm-4">
          <div class="image text-center"><a href="<?php echo $gallalbum['href']; ?>"><img src="<?php echo $gallalbum['thumb']; ?>" alt="<?php echo $gallalbum['name']; ?>" title="<?php echo $gallalbum['name']; ?>" /></a></div>
          <div class="name text-center"><a href="<?php echo $gallalbum['href']; ?>"><?php echo $gallalbum['name']; ?></a></div>
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