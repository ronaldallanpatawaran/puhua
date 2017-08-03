<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php foreach($extra_tags as $extra_tag) {?>
<meta <?php echo ($extra_tag['name']) ? 'name="' . $extra_tag['name'] . '" ' : ''; ?><?php echo (!in_array($extra_tag['property'], array("noprop", "noprop1", "noprop2", "noprop3", "noprop4"))) ? 'property="' . $extra_tag['property'] . '" ' : ''; ?> content="<?php echo addslashes($extra_tag['content']); ?>" />
<?php } ?>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="catalog/view/theme/default/stylesheet/bootstrap-text.css" rel="stylesheet" media="screen" />
<link href="catalog/view/theme/default/stylesheet/bootstrap-equal-height.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bootstrap/js/bootstrap-dialog.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
<nav id="top">
  <div class="container">
    <?php echo $currency; ?>
    <?php echo $language; ?>
    <div id="top-links" class="nav pull-right">
      <ul class="list-inline">
        <li><a href="<?php echo $contact; ?>"><i class="fa fa-phone"></i></a> <span class="hidden-xs hidden-sm hidden-md"><?php echo $telephone; ?></span></li>
        <li>
          <a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_wishlist; ?></span></a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<header>
<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <div id="logo">
        <?php if ($logo) { ?>
        <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
        <?php } else { ?>
        <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
        <?php } ?>
      </div>
    </div>
    <div class="col-sm-8">
      <nav id="menu" class="navbar">
        <div class="navbar-header"><span id="category" class="visible-xs"><?php echo $text_menu; ?></span>
          <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo $home; ?>" <?php echo (isset($route) && $route=="common/home") ? 'class="active"' : '' ; ?>><?php echo $text_home; ?></a></li>
            <li><a href="<?php echo $aboutus; ?>" <?php echo (isset($route) && $route=="information/information") ? 'class="active"' : '' ; ?>><?php echo $text_aboutus; ?></a></li>
            <li><a href="<?php echo $services; ?>" <?php echo (isset($route) && $route=="#") ? 'class="active"' : '' ; ?>><?php echo $text_services; ?></a></li>
            <li><a href="<?php echo $gallery; ?>" <?php echo (isset($route) && $route=="gallery/album") ? 'class="active"' : '' ; ?>><?php echo $text_gallery; ?></a></li>
            <li><a href="<?php echo $news; ?>" <?php echo (isset($route) && $route=="news/ncategory") ? 'class="active"' : '' ; ?>><?php echo $text_news; ?></a></li>
            <li><a href="<?php echo $shop; ?>" <?php echo (isset($route) && $route=="product/category") ? 'class="active"' : '' ; ?>><?php echo $text_shop; ?></a></li>

            <?php if ($categories) { ?>
            <?php foreach ($categories as $category) { ?>
            <?php if ($category['children']) { ?>
            <li class="dropdown">
              <?php if ($top_category_id == $category['category_id']) { ?>
              <a href="<?php echo $category['href']; ?>" class="dropdown-toggle active" data-toggle="dropdown"><?php echo $category['name']; ?></a>
              <?php } else { ?>
              <a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?></a>
              <?php } ?>
              <div class="dropdown-menu">
                <div class="dropdown-inner">
                  <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
                  <ul class="list-unstyled">
                    <?php foreach ($children as $child) { ?>
                    <?php if ($top_child_id == $child['category_id']) { ?>
                    <li><a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a></li>
                    <?php } else { ?>
                    <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
                    <?php } ?>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                </div>
                <a href="<?php echo $category['href']; ?>" class="see-all"><?php echo $text_all; ?> <?php echo $category['name']; ?></a> </div>
            </li>
            <?php } else { ?>
            <?php if ($top_category_id == $category['category_id']) { ?>
            <li><a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <li><a href="<?php echo $contact; ?>" <?php echo (isset($route) && $route=="information/contact") ? 'class="active"' : '' ; ?>><?php echo $text_contact; ?></a></li>
          </ul>
            <div class="search_cart_div"><a href="<?php echo $search; ?>"><span><i title="Search" class="search"></i></span></a>
              &nbsp;
              <a href="<?php echo $checkout; ?>"><span><i title="View Cart" class="cart"></i></span></a>
            </div>
        </div>
      </nav>

    </div>
  </div>

</div>
</header>
<?php if ($content_header) { ?>
<div class="container">
  <div class="row">
    <div class="col-sm-12"><?php echo $content_header; ?></div>
  </div>
</div>
<?php } ?>