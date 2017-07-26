<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
          <div class="col-sm-10">
            <select name="enhancepickup_status" id="input-status" class="form-control">
              <?php if ($enhancepickup_status) { ?>
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
          <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
          <div class="col-sm-10">
            <input type="text" name="enhancepickup_sort_order" value="<?php echo $enhancepickup_sort_order; ?>" size="1" id="input-sort-order" class="form-control" />
          </div>
        </div>
        <table class="table table-hovered form">
          <tr>
            <td colspan="2" id="button_add_store">
              <table id="loc" class="table table-bordered table-hovered form">
                <thead>
                  <tr>
                    <td><?php echo $entry_title; ?></td>
                    <td style="width: 30%;"><?php echo $entry_desc; ?></td>
                    <td style="width: 20%;"><?php echo $entry_total; ?></td>
                    <td style="width: 10%;"><?php echo $entry_cost; ?></td>
                    <td><?php echo $entry_geo_zone; ?></td>
                    <td>Delete</td>
                  </tr>
                </thead>
                <tbody>
                  <?php for ($i = 0; $i < count($enhancepickup_title); $i++) { ?>
                  <tr>
                    <td>
                      <input type="text" name="enhancepickup_title[]" value="<?php echo $enhancepickup_title[$i]; ?>" id="enhancepickup-title-<?php echo $i; ?>" class="form-control" />
                      <?php if ($locations) { ?>
                      <br/>
                      Store Locations:<br/>
                      <div class="well well-sm" style="height: 150px; overflow: auto;">
                        <?php foreach ($locations as $location) { ?>
                        <div class="radio">
                          <label>
                            <?php if ($location['name'] == $enhancepickup_title[$i]) { ?>
                            <input type="radio" name="<?php echo $i; ?>" value="<?php echo $location['name']; ?>" onclick="$('#enhancepickup-title-<?php echo $i; ?>').val(this.value);" checked="checked" />
                            <?php } else { ?>
                            <input type="radio" name="<?php echo $i; ?>" value="<?php echo $location['name']; ?>" onclick="$('#enhancepickup-title-<?php echo $i; ?>').val(this.value);" />
                            <?php } ?>
                            <?php echo $location['name']; ?>
                          </label>
                        </div>
                        <?php } ?>
                      </div>
                      <?php } ?>
                    </td>
                    <td><textarea name="enhancepickup_desc[]" rows="5" cols="30" class="form-control"><?php echo $enhancepickup_desc[$i]; ?></textarea></td>
                    <td><input type="text" name="enhancepickup_total[]" value="<?php echo $enhancepickup_total[$i]; ?>"  class="form-control" /></td>
                    <td><input type="text" name="enhancepickup_cost[]" value="<?php echo $enhancepickup_cost[$i]; ?>"  class="form-control"/></td>
                    <td><select name="enhancepickup_geo_zone_id[]"  class="form-control">
                          <option value="0"><?php echo $text_all_zones; ?></option>
                          <?php foreach ($geo_zones as $geo_zone) { ?>
                          <?php if ($geo_zone['geo_zone_id'] == $enhancepickup_geo_zone_id[$i]) { ?>
                          <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    <td><a onclick="removeloc(this)" class="btn btn-default"><i class="fa fa-trash-o"></i></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5">&nbsp;</td>
                    <td><a onclick="addModule();" class="btn btn-default"><i class="fa fa-plus"></i></a></td>
                  </tr>
                </tfoot>
              </table>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $i; ?>;

function addModule() {  
  html = '';

  html += '<tr>';
  html += '<td>';
  html += '    <input type="text" name="enhancepickup_title[]" id="enhancepickup-title-' + module_row + '" class="form-control" />';
  <?php if ($locations) { ?>
  html += '    <br/>';
  html += '    Store Locations:<br/>';
  html += '    <div class="well well-sm" style="height: 150px; overflow: auto;">';
  html += '      <?php foreach ($locations as $location) { ?>';
  html += '      <div class="radio">';
  html += '        <label>';
  html += '          <input type="radio" name="' + module_row + '" value="<?php echo $location["name"]; ?>" onclick="$(\'#enhancepickup-title-' + module_row + '\').val(this.value);" />';
  html += '          <?php echo $location["name"]; ?>';
  html += '        </label>';
  html += '      </div>';
  html += '      <?php } ?>';
  html += '    </div>';
  <?php } ?>
  html += '  </td>';
  html += '  <td><textarea name="enhancepickup_desc[]" rows="5" cols="30" class="form-control"></textarea></td>';
  html += '  <td><input type="text" name="enhancepickup_total[]" value="0" class="form-control" /></td>';
  html += '  <td><input type="text" name="enhancepickup_cost[]" value="0" class="form-control" /></td>';
  html += '  <td><select name="enhancepickup_geo_zone_id[]" class="form-control">';
  html += '        <option value="0"><?php echo $text_all_zones; ?></option>';
  html += '        <?php foreach ($geo_zones as $geo_zone) { ?>';
  html += '        <option value="<?php echo $geo_zone["geo_zone_id"]; ?>"><?php echo $geo_zone["name"]; ?></option>';
  html += '        <?php } ?>';
  html += '      </select></td>';
  html += '  <td><a onclick="removeloc(this)" class="btn btn-default"><i class="fa fa-trash-o"></i></a></td>';
  html += '</tr>';

  $('#loc > tbody').append(html);
  module_row++;
}

function removeloc(obj){
  $(obj).parent().parent().remove();
}
//--></script>
<style>
td { 
  padding: 5px;
}
</style>
<?php echo $footer; ?>