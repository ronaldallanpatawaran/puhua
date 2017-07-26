<?php
/**
 * @total-module	Admin Menu Module Hide
 * @author-name 	◘ Dotbox Creative
 * @copyright		Copyright (C) 2014 ◘ Dotbox Creative www.dotboxcreative.com
 * @license			GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-menuhide" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-menuhide" class="form-horizontal">
          <div class="form-group">   
            <label class="col-sm-2 control-label" for="input-template"><?php echo $entry_module; ?></label>
            <div class="col-sm-10">
              <select name="menuhide_module" id="input-template" class="form-control">
                <?php if ($menuhide_module) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>   
            </div>
          </div>
          <div class="form-group"> 
            <label class="col-sm-2 control-label" for="input-template"><?php echo $entry_menu; ?></label>
            <div class="col-sm-10">
              <select name="menuhide_menu" id="input-template" class="form-control">
                <?php if ($menuhide_menu) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>   
            </div>
          </div>
          
          <div class="form-group"> 
            <label class="col-sm-2 control-label" for="input-template"><?php echo $entry_help; ?></label>
            <div class="col-sm-10">
              <select name="menuhide_help" id="input-template" class="form-control">
                <?php if ($menuhide_help) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>   
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-template"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="menuhide_status" id="input-template" class="form-control">
     			<?php if ($menuhide_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>   
            </div>
          </div>
        </form>   
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>