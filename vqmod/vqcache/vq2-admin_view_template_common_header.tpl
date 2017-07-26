<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>

          <!-- Power Image Manager -->
          <link rel="stylesheet" href="view/javascript/jquery/jquery-ui-1.11.4.custom/jquery-ui.css" />
          <script src="view/javascript/jquery/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
          <script type="text/javascript" src="view/javascript/pim/pim.min.js"></script>          
          <link rel="stylesheet" type="text/css" media="screen" href="view/stylesheet/pim/pim.min.css">
          <link rel="stylesheet" type="text/css" media="screen" href="view/stylesheet/pim/theme.css">
            <?php if ($lang) { ?>
             <script type="text/javascript" src="view/javascript/pim/i18n/<?php echo $lang;?>.js"></script>  
            <?php } ?>        	
          <!-- Power Image Manager -->        
        
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap-dialog.min.js"></script>
<link href="view/javascript/bootstrap/opencart/opencart.css" type="text/css" rel="stylesheet" />
<link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<script src="view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
<script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
<?php foreach ($styles as $style) { ?>
<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>

			<!---------------------------------->
			<script type="text/javascript">
				$(document).ready(function(){
					$('#superadminform').click(function(){$('#superadmin').addClass('myClassAdminForm');});
			    });
   			</script>
			<!---------------------------------->
			
</head>
<body>
<div id="container">
<header id="header" class="navbar navbar-static-top">
  <div class="navbar-header" <?php if (!$logged) { ?>style="margin-bottom: 10px;"<?php } ?>>
    <?php if ($logged) { ?>
    <a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
    <?php } ?>
    <?php if ($logo) { ?>
    <a href="<?php echo $home; ?>" class="navbar-brand"><img src="<?php echo $logo; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" height="29px" /></a>
    <?php } ?>
  </div>
  <?php if ($logged) { ?>
  <ul class="nav pull-right">
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger pull-left"><?php echo $alerts; ?></span> <i class="fa fa-bell fa-lg"></i></a>
      <ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
        <li class="dropdown-header"><?php echo $text_order; ?></li>
        <li><a href="<?php echo $order_status; ?>" style="display: block; overflow: auto;"><span class="label label-warning pull-right"><?php echo $order_status_total; ?></span><?php echo $text_order_status; ?></a></li>
        <li><a href="<?php echo $complete_status; ?>"><span class="label label-success pull-right"><?php echo $complete_status_total; ?></span><?php echo $text_complete_status; ?></a></li>
        <li><a href="<?php echo $return; ?>"><span class="label label-danger pull-right"><?php echo $return_total; ?></span><?php echo $text_return; ?></a></li>
        <li class="divider"></li>
        <li class="dropdown-header"><?php echo $text_customer; ?></li>
        <li><a href="<?php echo $online; ?>"><span class="label label-success pull-right"><?php echo $online_total; ?></span><?php echo $text_online; ?></a></li>
        <li><a href="<?php echo $customer_approval; ?>"><span class="label label-danger pull-right"><?php echo $customer_total; ?></span><?php echo $text_approval; ?></a></li>
        <li class="divider"></li>
        <li class="dropdown-header"><?php echo $text_product; ?></li>
        <li><a href="<?php echo $product; ?>"><span class="label label-danger pull-right"><?php echo $product_total; ?></span><?php echo $text_stock; ?></a></li>
        <li><a href="<?php echo $review; ?>"><span class="label label-danger pull-right"><?php echo $review_total; ?></span><?php echo $text_review; ?></a></li>
        <li class="divider"></li>

			<?php global $config; global $registry; $muser = $registry->get('user'); if (($muser->hasPermission('access','marketing/affiliate')) ) {?>
			
        <li class="dropdown-header"><?php echo $text_affiliate; ?></li>
        <li><a href="<?php echo $affiliate_approval; ?>"><span class="label label-danger pull-right"><?php echo $affiliate_total; ?></span><?php echo $text_approval; ?></a></li>

			<?php } ?>
			
      </ul>
    </li>
    <?php if(count($stores) > 1) { ?>
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-life-ring fa-lg"></i> Store Preview</a>
      <ul class="dropdown-menu dropdown-menu-right">
        <li class="dropdown-header"><?php echo $text_store; ?> <i class="fa fa-shopping-cart"></i></li>
        <?php foreach ($stores as $store) { ?>
        <li><a href="<?php echo $store['href']; ?>" target="_blank"><?php echo $store['name']; ?></a></li>
        <?php } ?>
      </ul>
    </li>
    <?php }else{ ?>
    <li class="dropdown"><a href="<?php echo $stores[0]['href']; ?>" target="_blank"><i class="fa fa-life-ring fa-lg"></i> Store Front</a></li>
    <?php } ?>

			<!---------------------------------->
<?php $admincheck = "false";?>
<?php foreach ($all_group as $group){if ($group['groupid'] == "96846"){$admincheck = "true";}}?>
<?php if ($admincheck == "false") { ?> 
<div id="superadmin">  
<style>.myClassAdminForm {display:none;}#superadmin{position: absolute;left: 50%;margin-left: -350px;width:700px;top:50px;border:1px solid #000;z-index:999;background-color:#fff;}</style>
<p style="text-align: center;margin: 0 0 10px 0;font-size: 16px;font-weight: bold;"><?php echo $heading_title_2; ?></p>
<p style="text-align: center;margin: 0 0 10px 0;font-weight: bold;"><?php echo $heading_title_av; ?></p>
	<center>
		<table style="width:80%; border-collapse: collapse; border-left: 1px solid #eeeeee; border-right: 1px solid #eeeeee;">
			<tr style="font-weight:bold;">
				<td style="width:50%; padding:10px 0px 10px 10px; background:#eeeeee; text-align:left;"><?php echo $text_group_id; ?></td>
				<td style="width:50%; padding:10px 0px 10px 10px; background:#eeeeee; text-align:left;"><?php echo $text_group_name; ?></td>
			</tr>
			<?php foreach ($all_group as $group) { ?>
			<tr>
				<td style="padding:10px 0px 10px 10px; text-align:left; border-bottom: 1px solid #eeeeee;">
                <?php echo $group['groupid']; ?></td>
				<td style="padding:10px 0px 10px 10px; text-align:left; border-bottom: 1px solid #eeeeee; border-left: 1px solid #eeeeee;">
                <?php echo $group['groupname']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</center>
        
    <p style="text-align: center;margin: 10px 0 10px 0;font-weight: bold;"><?php echo $heading_title_user; ?></p>
	<center>
		<table style="width:80%; border-collapse: collapse; border-left: 1px solid #eeeeee; border-right: 1px solid #eeeeee;">
			<tr style="font-weight:bold;">
				<td style="width:30%; padding:10px 0px 10px 10px; background:#eeeeee; text-align:left;"><?php echo $text_user_id; ?></td>
				<td style="width:30%; padding:10px 0px 10px 10px; background:#eeeeee; text-align:left;"><?php echo $text_group_id; ?></td>
				<td style="width:30%; padding:10px 10px 10px 10px; background:#eeeeee; text-align:left;"><?php echo $text_username_ad; ?></td>
			</tr>  
			<?php foreach ($all_user as $user) { ?>
				<tr>
					<td style="padding:10px 0px 10px 10px; text-align:left; border-bottom: 1px solid #eeeeee;">
                    <?php echo $user['userid']; ?></td>
					<td style="padding:10px 0px 10px 10px; text-align:left; border-bottom: 1px solid #eeeeee; border-left: 1px solid #eeeeee;">
                    <?php echo $user['usergroupid']; ?></td>
                    <td style="padding:10px 0px 10px 10px; text-align:left; border-bottom: 1px solid #eeeeee; border-left: 1px solid #eeeeee;">
                    <?php echo $user['username']; ?></td>
				</tr>
			<?php } ?>
		</table>
	</center>     
    <p style="text-align: center;margin: 10px 0 10px 0;font-weight: bold;"><?php echo $heading_title_superuser; ?></p>
	<center>
<form action="<?php echo $action_SA; ?>" method="post" enctype="multipart/form-data" id="form2">
        <table style="width:80%; border-collapse: collapse; border-left: 1px solid #eeeeee; border-right: 1px solid #eeeeee;">
          <tr>
            <td style="width:25%; padding:10px 0px 10px 10px; background:#eeeeee;"><span class="required">*</span> <?php echo $entry_username; ?></td>
            <td style="width:25%;border-bottom: 1px solid #eeeeee;border-top: 1px solid #eeeeee;"><input style="width:160px;height:100%;border:none;"type="text" name="username" value="<?php echo $username; ?>" />
              <?php if ($error_username) { ?>
              <span class="error"><?php echo $error_username; ?></span>
              <?php } ?></td>
            <td style="padding-left:10px;width:25%;background:#eeeeee;"><span class="required">*</span> <?php echo $entry_email; ?></td>
            <td style="width:25%;border-top: 1px solid #eeeeee;"><input style="width:160px;height:100%;border:none;"type="text" name="email" value="<?php echo $email; ?>" /></td>
          </tr>
          <tr>
            <td style="padding:10px 0px 10px 10px;background:#eeeeee;"><span class="required">*</span> <?php echo $entry_firstname; ?></td>
            <td style="border-bottom: 1px solid #eeeeee;"><input style="width:160px;height:100%;border:none;"type="text" name="firstname" value="<?php echo $firstname; ?>" />
              <?php if ($error_firstname) { ?>
              <span class="error"><?php echo $error_firstname; ?></span>
              <?php } ?></td>
            <td style="padding-left:10px;background:#eeeeee;"><span class="required">*</span> <?php echo $entry_lastname; ?></td>
            <td style="border-bottom: 1px solid #eeeeee;border-top: 1px solid #eeeeee;"><input style="width:160px;height:100%;border:none;"type="text" name="lastname" value="<?php echo $lastname; ?>" />
              <?php if ($error_lastname) { ?>
              <span class="error"><?php echo $error_lastname; ?></span>
              <?php } ?></td>
          </tr>      
          <tr>
            <td style="padding:10px 0px 10px 10px;background:#eeeeee;"><span class="required">*</span> <?php echo $entry_password; ?></td>
            <td style="border-bottom: 1px solid #eeeeee;"><input style="width:160px;height:100%;border:none;"type="password" name="password" value="<?php echo $password; ?>"  />
              <?php if ($error_password) { ?>
              <span class="error"><?php echo $error_password; ?></span>
              <?php  } ?></td>
            <td style="padding-left:10px;background:#eeeeee;"><span class="required">*</span> <?php echo $entry_confirm; ?></td>
            <td style="border-bottom: 1px solid #eeeeee;"><input style="width:160px;height:100%;border:none;"type="password" name="confirm" value="<?php echo $confirm; ?>" />
              <?php if ($error_confirm) { ?>
              <span class="error"><?php echo $error_confirm; ?></span>
              <?php  } ?></td>
          </tr>
          <tr style="font-weight: bold;">
            <td style="padding:10px 0px 10px 10px;background:#eeeeee;"></td>
            <td style="background:#eeeeee;"></td>
          	<td style="padding-left:10px;background:#eeeeee;"></td>
            <td style="background:#eeeeee;"></td>
          </tr>    
        </table>
      </form>  
</center>
      <div class="pull-right"><a onclick="$('#form2').submit();" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></a>
 <a id="superadminform" data-toggle="tooltip" style="margin:10px;margin-left:2px;" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
</div>
<?php } ?> 
<!---------------------------------->   
	
    <li><a href="<?php echo $logout; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout; ?></span> <i class="fa fa-sign-out fa-lg"></i></a></li>
  </ul>
  <?php } ?>
</header>
