<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
  <?php  global $registry; $muser = $registry->get('user'); ?>
    <?php if ($muser->hasPermission('access','common/newspanel'))  {?>
    <?php echo $newspanel; ?>
							<br />
							<?php } ?>
    <?php if ($error_install) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="row">
      	
            <?php if ($muser->hasPermission('access','dashboard/order'))  {?>
            <div class="col-lg-3 col-md-3 col-sm-6"><?php echo $order; ?></div>
            <?php } ?>
			
      	
            <?php if ($muser->hasPermission('access','dashboard/sale'))  {?>
            <div class="col-lg-3 col-md-3 col-sm-6"><?php echo $sale; ?></div>
            <?php } ?>
			
      	
            <?php if ($muser->hasPermission('access','dashboard/customer'))  {?>
            <div class="col-lg-3 col-md-3 col-sm-6"><?php echo $customer; ?></div>
            <?php } ?>
			
      	
            <?php if ($muser->hasPermission('access','dashboard/online'))  {?>
            <div class="col-lg-3 col-md-3 col-sm-6"><?php echo $online; ?></div>
            <?php } ?>
			
    </div>
    <div class="row">
      	
            <?php if ($muser->hasPermission('access','dashboard/map'))  {?>
            <div class="col-lg-6 col-md-12 col-sx-12 col-sm-12"><?php echo $map; ?></div>
            <?php } ?>
			
      	
            <?php if ($muser->hasPermission('access','dashboard/chart'))  {?>
            <div class="col-lg-6 col-md-12 col-sx-12 col-sm-12"><?php echo $chart; ?></div>
            <?php } ?>
			
    </div>
    <div class="row">
      	
            <?php if ($muser->hasPermission('access','dashboard/activity'))  {?>
            <div class="col-lg-4 col-md-12 col-sm-12 col-sx-12"><?php echo $activity; ?></div>
            <?php } ?>
			
      	
            <?php if ($muser->hasPermission('access','dashboard/recent'))  {?>
            <div class="col-lg-8 col-md-12 col-sm-12 col-sx-12"> <?php echo $recent; ?> </div>
            <?php } ?>
			
    </div>
  </div>
</div>
<?php echo $footer; ?>