<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-gallalbum" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-gallalbum" class="form-horizontal"> 
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_showimg; ?></label>
            <div class="col-sm-10">
              <select name="showimg" class="form-control">
                <?php if ($showimg) { ?>
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
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
            <div class="col-sm-10">
              <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
              <?php if ($error_width) { ?>
              <div class="text-danger"><?php echo $error_width; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
            <div class="col-sm-10">
              <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
              <?php if ($error_height) { ?>
              <div class="text-danger"><?php echo $error_height; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php foreach ($languages as $language) { ?>  
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-headtitle"><?php echo $entry_headtitle; ?>&nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></label>
            <div class="col-sm-10">
              <input type="text" name="headtitle_<?php echo $language['language_id']; ?>" value="<?php echo isset(${'headtitle_' . $language['language_id']}) ? ${'headtitle_' . $language['language_id']} : ''; ?>" placeholder="<?php echo $entry_headtitle; ?>" id="input-headtitle" class="form-control" />
            </div>
          </div>
          <?php } ?>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-descstat"><?php echo $entry_descstat; ?></label>
            <div class="col-sm-10">
              <select name="descstat" class="form-control">
                <?php if ($descstat) { ?>
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
            <label class="col-sm-2 control-label" for="input-chardesc"><?php echo $entry_chardesc; ?></label>
            <div class="col-sm-10">
            <?php if(empty($chardesc)) { $chardesc = "200"; } ?>
              <input type="text" name="chardesc" value="<?php echo $chardesc; ?>" placeholder="<?php echo $entry_chardesc; ?>" id="input-chardesc" class="form-control" />
            </div>
          </div> 
          <!--
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-popupstyle"><?php echo $entry_popupstyle; ?></label>
            <div class="col-sm-10">
              <select name="gallery_popupstyle" class="form-control">
          <?php if (isset($gallery_popupstyle)) { $selected = "selected"; ?>
          <option value="popup1" <?php if($gallery_popupstyle=='popup1'){echo $selected;} ?>>Style 1</option>
          <option value="popup2" <?php if($gallery_popupstyle=='popup2'){echo $selected;} ?>>Style 2</option>
          <option value="popup3" <?php if($gallery_popupstyle=='popup3'){echo $selected;} ?>>Style 3</option>
          <option value="popup4" <?php if($gallery_popupstyle=='popup4'){echo $selected;} ?>>Style 4</option>
          <option value="popup5" <?php if($gallery_popupstyle=='popup5'){echo $selected;} ?>>Style 5</option>
          <?php } else { ?>
          <option value="popup1" selected="selected">Style 1</option>
          <option value="popup2">Style 2</option>
          <option value="popup3">Style 3</option>
          <option value="popup4">Style 4</option>
          <option value="popup5">Style 5</option>
          <?php } ?>
      </select>
            </div>
          </div>  
          -->         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
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