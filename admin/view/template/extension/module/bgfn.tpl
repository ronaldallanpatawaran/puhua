<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <script type="text/javascript"><!--
function loadajaxprocatmanu(row) { 
$('input[name=\'bgfn_setting['+row+'][product]\']').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	select: function(item) {
		$('input[name=\'bgfn_setting['+row+'][product]\']').val('');
		
		$('#bgfn-product'+row + item['value']).remove();
		
		$('#bgfn-product'+row).append('<div id="bgfn-product'+row+'-' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="bgfn_setting['+row+'][product][]" value="' + item['value'] + '" /></div>');	
	}
});
	
$('#bgfn-product'+row).delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
}); 

$('input[name=\'bgfn_setting['+row+'][manufacturer]\']').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['manufacturer_id']
					}
				}));
			}
		});
	},
	select: function(item) {
		$('input[name=\'bgfn_setting['+row+'][manufacturer]\']').val('');
		
		$('#bgfn-manufacturer'+row + item['value']).remove();
		
		$('#bgfn-manufacturer'+row).append('<div id="bgfn-manufacturer'+row+'-' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="bgfn_setting['+row+'][manufacturer][]" value="' + item['value'] + '" /></div>');	
	}
});
	
$('#bgfn-manufacturer'+row).delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
 
$('input[name=\'bgfn_setting['+row+'][category]\']').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	select: function(item) {
		$('input[name=\'bgfn_setting['+row+'][category]\']').val('');
		
		$('#bgfn-category'+row+ item['value']).remove();
		
		$('#bgfn-category'+row).append('<div id="bgfn-category'+row+'-' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="bgfn_setting['+row+'][category][]" value="' + item['value'] + '" /></div>');	
	}
});
	
$('#bgfn-category'+row).delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
}
</script>
  <style>
.togglebody{display:none} .control-label{text-align:left !important;}
</style>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-<?php echo $modname;?>" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <button type="submit" form="form-<?php echo $modname;?>" data-toggle="tooltip" onclick="$('#svsty').val(1);" title="Save & Stay" class="btn btn-primary">Save & Stay</button>
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
    <div class="alert alert-info"><strong>SUPPORT : <?php echo $modemail; ?></strong></div>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-bgfn" class="form-horizontal">
          <input type="hidden" name="svsty" id="svsty" />
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-bgfn_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="<?php echo $modname;?>_status" id="input-status" class="form-control">
                <?php if ($bgfn_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php $row = 0; ?>
          <?php if($bgfn_setting) { ?>
          <?php foreach($bgfn_setting as $stng) { ?>
          <div class="panel panel-<?php echo ($row % 2 == 0) ? 'primary' : 'warning' ;?>" id="bgfn_modulerow<?php echo $row;?>">
            <div class="panel-heading" style="cursor:pointer" onclick="$( '#toggle<?php echo $row;?>' ).toggle();">
              <h3 class="panel-title"> <?php echo ($stng['module_name']) ? $stng['module_name'] : $entry_name.$row; ?></h3>
              <button type="button" onclick="$('#bgfn_modulerow<?php echo $row;?>').remove();"  class="btn btn-danger pull-right"><i class="fa fa-minus-circle"></i> REMOVE</button>
            </div>
            <div class="panel-body togglebody" id="toggle<?php echo $row;?>">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-module_name"><?php echo $entry_name; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="bgfn_setting[<?php echo $row;?>][module_name]" value="<?php echo $stng['module_name']; ?>" placeholder="<?php echo $entry_name; ?>" id="input-module_name<?php echo $row; ?>" class="form-control" />
                </div>
              </div>
              <div style="clear:both"></div>
              <div class="form-group col-sm-6">
                <label class="col-sm-12 control-label" for="input-ribbon_text<?php echo $row; ?>"><?php echo $entry_ribbon_text; ?></label>
                <div class="col-sm-12">
                  <?php foreach ($languages as $language) { 
								  if(substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') {
									$imgsrc = "language/".$language['code']."/".$language['code'].".png";
								  } else {
									$imgsrc = "view/image/flags/".$language['image'];
								  }
								  ?>
                  <div class="input-group pull-left"><span class="input-group-addon"><img src="<?php echo $imgsrc;?>" /> </span>
                    <input type="text" name="bgfn_setting[<?php echo $row;?>][ribbon_text<?php echo $language['language_id'];?>]" value="<?php echo $stng['ribbon_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_ribbon_text; ?>" class="form-control" />
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group col-sm-6">
                <label class="col-sm-12 control-label" for="input-total_text<?php echo $row; ?>"><?php echo $entry_total_text; ?></label>
                <div class="col-sm-12">
                  <?php foreach ($languages as $language) { 
								  if(substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') {
									$imgsrc = "language/".$language['code']."/".$language['code'].".png";
								  } else {
									$imgsrc = "view/image/flags/".$language['image'];
								  }
								  ?>
                  <div class="input-group pull-left"><span class="input-group-addon"><img src="<?php echo $imgsrc;?>" /> </span>
                    <input type="text" name="bgfn_setting[<?php echo $row;?>][total_text<?php echo $language['language_id'];?>]" value="<?php echo $stng['total_text'][$language['language_id']]; ?>" placeholder="<?php echo $entry_total_text; ?>" class="form-control" />
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div style="clear:both"></div>
              <div class="form-group col-sm-3">
                <label class="col-sm-12 control-label" for="input-disctype"><?php echo $entry_disctype; ?></label>
                <div class="col-sm-12">
                  <select name="bgfn_setting[<?php echo $row;?>][disctype]" id="input-disctype<?php echo $row;?>" class="form-control" onchange="showdiscval(this.value, <?php echo $row;?>);">
                    <option value="1" <?php echo ($stng['disctype'] == 1) ? 'selected' : '';?> >Percentage Discount</option>
                    <option value="2" <?php echo ($stng['disctype'] == 2) ? 'selected' : '';?> >Fixed Amount Discount</option>
                    <option value="0" <?php echo ($stng['disctype'] == 0) ? 'selected' : '';?> >FREE</option>
                  </select>
                </div>
                <div id="discval<?php echo $row;?>" <?php if($stng['disctype'] < 1) { ?> style="display:none" <?php } ?>>
                  <label class="col-sm-12 control-label" for="input-discval"><?php echo $entry_discval; ?></label>
                  <div class="col-sm-12">
                    <input type="text" name="bgfn_setting[<?php echo $row;?>][discval]" value="<?php echo $stng['discval']; ?>" placeholder="<?php echo $entry_discval; ?>" id="input-discval" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-3">
                <label class="col-sm-12 control-label" for="input-buyqty"><?php echo $entry_buyqty; ?></label>
                <div class="col-sm-12">
                  <input type="text" name="bgfn_setting[<?php echo $row;?>][buyqty]" value="<?php echo $stng['buyqty']; ?>" placeholder="<?php echo $entry_buyqty; ?>" id="input-buyqty" class="form-control" />
                </div>
                <div class="">
                  <label class="col-sm-12 control-label" for="input-getqty"><?php echo $entry_getqty; ?></label>
                  <div class="col-sm-12">
                    <input type="text" name="bgfn_setting[<?php echo $row;?>][getqty]" value="<?php echo $stng['getqty']; ?>" placeholder="<?php echo $entry_getqty; ?>" id="input-getqty" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-3">
                <label class="col-sm-12 control-label"><?php echo $entry_customer_group; ?></label>
                <div class="col-sm-12">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($customer_group as $cgrp) { ?>
                    <div class="checkbox">
                      <label>
                      <?php if (isset($stng['customer_group']) && in_array($cgrp['customer_group_id'], $stng['customer_group'])) { ?>
                      <input type="checkbox" name="bgfn_setting[<?php echo $row; ?>][customer_group][]" value="<?php echo $cgrp['customer_group_id']; ?>" checked="checked" />
                      <?php echo $cgrp['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="bgfn_setting[<?php echo $row; ?>][customer_group][]" value="<?php echo $cgrp['customer_group_id']; ?>" />
                      <?php echo $cgrp['name']; ?>
                      <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-3">
                <label class="col-sm-12 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-12">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                      <?php if (in_array(0, $stng['store'])) { ?>
                      <input type="checkbox" name="bgfn_setting[<?php echo $row; ?>][store][]" value="0" checked="checked" />
                      <?php echo $text_default; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="bgfn_setting[<?php echo $row; ?>][store][]" value="0" />
                      <?php echo $text_default; ?>
                      <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                      <?php if (isset($stng['store']) && in_array($store['store_id'], $stng['store'])) { ?>
                      <input type="checkbox" name="bgfn_setting[<?php echo $row; ?>][store][]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                      <?php echo $store['name']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="bgfn_setting[<?php echo $row; ?>][store][]" value="<?php echo $store['store_id']; ?>" />
                      <?php echo $store['name']; ?>
                      <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div style="clear:both"></div>
              <p><?php echo $help_considerall;?></p>
              <!-- product -->
              <div class="form-group col-sm-4">
                <label class="col-sm-12 control-label" for="input-product"><?php echo $entry_product; ?></label>
                <div class="col-sm-12">
                  <input type="text" name="bgfn_setting[<?php echo $row;?>][product]" value="" placeholder="<?php echo $entry_product; ?>" id="input-product-<?php echo $row;?>" class="form-control" />
                  <div id="bgfn-product<?php echo $row;?>" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($stng['product'] as $product) { ?>
                    <div id="bgfn-product<?php echo $row;?>-<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
                      <input type="hidden" name="bgfn_setting[<?php echo $row;?>][product][]" value="<?php echo $product['product_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <!-- category -->
              <div class="form-group col-sm-4">
                <label class="col-sm-12 control-label" for="input-category"><?php echo $entry_category; ?></label>
                <div class="col-sm-12">
                  <input type="text" name="bgfn_setting[<?php echo $row;?>][category]" value="" placeholder="<?php echo $entry_category; ?>" id="input-category-<?php echo $row;?>" class="form-control" />
                  <div id="bgfn-category<?php echo $row;?>" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($stng['category'] as $category) { ?>
                    <div id="bgfn-category<?php echo $row;?>-<?php echo $category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category['name']; ?>
                      <input type="hidden" name="bgfn_setting[<?php echo $row;?>][category][]" value="<?php echo $category['category_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <!-- manufacturer -->
              <div class="form-group col-sm-4">
                <label class="col-sm-12 control-label" for="input-manufacturer"><?php echo $entry_manufacturer; ?></label>
                <div class="col-sm-12">
                  <input type="text" name="bgfn_setting[<?php echo $row;?>][manufacturer]" value="" placeholder="<?php echo $entry_manufacturer; ?>" id="input-manufacturer-<?php echo $row;?>" class="form-control" />
                  <div id="bgfn-manufacturer<?php echo $row;?>" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($stng['manufacturer'] as $manufacturer) { ?>
                    <div id="bgfn-manufacturer<?php echo $row;?>-<?php echo $manufacturer['manufacturer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $manufacturer['name']; ?>
                      <input type="hidden" name="bgfn_setting[<?php echo $row;?>][manufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <script language="javascript"> loadajaxprocatmanu(<?php echo $row; ?>) ; </script>
            </div>
          </div>
          <?php $row++; } ?>
          <?php } ?>
          <div class="append"></div>
          <button type="button" onclick="addmodulebgfn();"  id="buttonadd" data-loading-text="Loading..."   class="btn btn-primary pull-right">ADD MODULE</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var row = <?php echo $row; ?>;
function addmodulebgfn() {
 	url = '<?php echo html_entity_decode($appendmodule);?>' + '&row='+row;
	
	$.ajax({
	  url: url,
	  beforeSend: function( xhr ) {
		$('#buttonadd').button('loading');
	  }
	})
	  .done(function( data ) {
		$('.append').append(data);
		$('#buttonadd').button('reset');
	  });
	   
 	row++;

} 
//--></script>
<script language="javascript">
function showdiscval(disctype , row) {
	if(disctype == 0) {
		$('#discval'+row).hide();
	} else {
		$('#discval'+row).show();
	}
}
</script>
<?php echo $footer; ?>