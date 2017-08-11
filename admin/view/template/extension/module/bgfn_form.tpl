
<div class="panel panel-<?php echo ($row % 2 == 0) ? 'primary' : 'warning' ;?>" id="bgfn_modulerow<?php echo $row;?>">
  <div class="panel-heading" style="cursor:pointer" onclick="$( '#toggle<?php echo $row;?>' ).toggle();">
    <h3 class="panel-title"> <?php echo $entry_name.($row+1); ?></h3>
    <button type="button" onclick="$('#bgfn_modulerow<?php echo $row;?>').remove();"  class="btn btn-danger pull-right"><i class="fa fa-minus-circle"></i> REMOVE</button>
  </div>
  <div class="panel-body" id="toggle<?php echo $row;?>">
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-module_name"><?php echo $entry_name; ?></label>
      <div class="col-sm-10">
        <input type="text" name="bgfn_setting[<?php echo $row;?>][module_name]" value="" placeholder="<?php echo $entry_name; ?>" id="input-module_name<?php echo $row; ?>" class="form-control" />
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
          <input type="text" name="bgfn_setting[<?php echo $row;?>][ribbon_text<?php echo $language['language_id'];?>]" value="" placeholder="<?php echo $entry_ribbon_text; ?>" class="form-control" />
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
          <input type="text" name="bgfn_setting[<?php echo $row;?>][total_text<?php echo $language['language_id'];?>]" value="" placeholder="<?php echo $entry_total_text; ?>" class="form-control" />
        </div>
        <?php } ?>
      </div>
    </div>
    <div style="clear:both"></div>
    <div class="form-group col-sm-3">
      <label class="col-sm-12 control-label" for="input-disctype"><?php echo $entry_disctype; ?></label>
      <div class="col-sm-12">
        <select name="bgfn_setting[<?php echo $row;?>][disctype]" id="input-disctype<?php echo $row;?>" class="form-control" onchange="showdiscval(this.value, <?php echo $row;?>);">
          <option value="1">Percentage Discount</option>
          <option value="2">Fixed Amount Discount</option>
          <option value="0">FREE</option>
        </select>
      </div>
      <div id="discval<?php echo $row;?>">
        <label class="col-sm-12 control-label" for="input-discval"><?php echo $entry_discval; ?></label>
        <div class="col-sm-12">
          <input type="text" name="bgfn_setting[<?php echo $row;?>][discval]" value="" placeholder="<?php echo $entry_discval; ?>" id="input-discval" class="form-control" />
        </div>
      </div>
    </div>
    <div class="form-group col-sm-3">
      <label class="col-sm-12 control-label" for="input-buyqty"><?php echo $entry_buyqty; ?></label>
      <div class="col-sm-12">
        <input type="text" name="bgfn_setting[<?php echo $row;?>][buyqty]" value="" placeholder="<?php echo $entry_buyqty; ?>" id="input-buyqty" class="form-control" />
      </div>
      <div class="">
        <label class="col-sm-12 control-label" for="input-getqty"><?php echo $entry_getqty; ?></label>
        <div class="col-sm-12">
          <input type="text" name="bgfn_setting[<?php echo $row;?>][getqty]" value="" placeholder="<?php echo $entry_getqty; ?>" id="input-getqty" class="form-control" />
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
            <input type="checkbox" name="bgfn_setting[<?php echo $row; ?>][customer_group][]" value="<?php echo $cgrp['customer_group_id']; ?>" />
            <?php echo $cgrp['name']; ?> </label>
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
            <input type="checkbox" name="bgfn_setting[<?php echo $row; ?>][store][]" value="0" />
            <?php echo $text_default; ?> </label>
          </div>
          <?php foreach ($stores as $store) { ?>
          <div class="checkbox">
            <label>
            <input type="checkbox" name="bgfn_setting[<?php echo $row; ?>][store][]" value="<?php echo $store['store_id']; ?>" />
            <?php echo $store['name']; ?> </label>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div style="clear:both"></div>
    <p><?php echo $help_considerall;?></p>
    <div class="form-group col-sm-4">
      <label class="col-sm-12 control-label" for="input-product<?php echo $row; ?>"><?php echo $entry_product; ?></label>
      <div class="col-sm-12">
        <input type="text" name="bgfn_setting[<?php echo $row; ?>][product]" value="" placeholder="<?php echo $entry_product; ?>" id="input-product<?php echo $row; ?>" class="form-control" />
        <div id="bgfn-product<?php echo $row; ?>" class="well well-sm" style="height: 150px; overflow: auto;"></div>
      </div>
    </div>
    <div class="form-group col-sm-4">
      <label class="col-sm-12 control-label" for="input-category<?php echo $row; ?>"><?php echo $entry_category; ?></label>
      <div class="col-sm-12">
        <input type="text" name="bgfn_setting[<?php echo $row; ?>][category]" value="" placeholder="<?php echo $entry_category; ?>" id="input-category<?php echo $row; ?>" class="form-control" />
        <div id="bgfn-category<?php echo $row; ?>" class="well well-sm" style="height: 150px; overflow: auto;"></div>
      </div>
    </div>
    <div class="form-group col-sm-4">
      <label class="col-sm-12 control-label" for="input-manufacturer<?php echo $row; ?>"><?php echo $entry_manufacturer; ?></label>
      <div class="col-sm-12">
        <input type="text" name="bgfn_setting[<?php echo $row; ?>][manufacturer]" value="" placeholder="<?php echo $entry_manufacturer; ?>" id="input-manufacturer<?php echo $row; ?>" class="form-control" />
        <div id="bgfn-manufacturer<?php echo $row; ?>" class="well well-sm" style="height: 150px; overflow: auto;"></div>
      </div>
    </div>
    <script language="javascript"> loadajaxprocatmanu(<?php echo $row; ?>) ; </script>
  </div>
</div>
