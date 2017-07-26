<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-banner" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
        </div>
        <div class="panel-body">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-banner" class="form-horizontal">
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
              <div class="col-sm-10">
                <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                <?php if ($error_name) { ?>
                <div class="text-danger"><?php echo $error_name; ?></div>
                <?php } ?>
              </div>
            </div>
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
            <table id="images" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $entry_title." / ".$column_make_description; ?></td>
                  <td class="text-left"><?php echo $entry_link; ?></td>
                  <td class="text-left"><?php echo $entry_image; ?></td>
                  <td class="text-right"><?php echo $entry_sort_order; ?></td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php $image_row = 0; ?>
                <?php  foreach ($banner_images as $banner_image) { ?>
                <tr id="image-row<?php echo $image_row; ?>">
                  <td class="text-left">
                  <?php foreach ($languages as $language) { ?>
                    <div class="input-group pull-left">
                      <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                      <input type="text" 
                      name="banner_image[<?php echo $image_row; ?>][banner_image_description][<?php echo $language['language_id']; ?>][title]" 
                      value="<?php echo isset($banner_image['banner_image_description'][$language['language_id']]) ? $banner_image['banner_image_description'][$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" class="form-control" />
                      <label style = "width:100%;">
                      <input type = "checkbox" onclick = "unique_identifyer<?php echo $language['language_id']; ?>(this)" data-row = "<?php echo $image_row; ?>" 
                      id = "banner_image[<?php echo $image_row; ?>][banner_image_description][<?php echo $language['language_id']; ?>][set_description]" 
                      name = "banner_image[<?php echo $image_row; ?>][banner_image_description][<?php echo $language['language_id']; ?>][set_description]" 
                      value = "1" <?php if(isset($banner_image['banner_image_description'][$language['language_id']]['set_description']) && $banner_image['banner_image_description'][$language['language_id']]['set_description']){ echo "checked"; } ?> /><?php echo $column_make_description; ?></label>
                      <textarea type="text" 
                        id = "banner_image[<?php echo $image_row; ?>][banner_image_description][<?php echo $language['language_id']; ?>][description]" 
                        name="banner_image[<?php echo $image_row; ?>][banner_image_description][<?php echo $language['language_id']; ?>][description]" 
                        placeholder="<?php echo $entry_link; ?>" class="form-control hidden" /><?php echo $banner_image['banner_image_description'][$language['language_id']]['description']; ?></textarea>

                    <?php if (isset($error_banner_image[$image_row][$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_banner_image[$image_row][$language['language_id']]; ?></div>
                    <?php } ?>
                    </div>
                    <?php } ?>
                    
                    </td>
                    <td class="text-left" style="width: 30%;">
                      <input type="text" name="banner_image[<?php echo $image_row; ?>][link]" placeholder="<?php echo $entry_link; ?>" class="form-control" value="<?php echo $banner_image['link']; ?>" /></td>
                      <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $banner_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                        <input type="hidden" name="banner_image[<?php echo $image_row; ?>][image]" value="<?php echo $banner_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                        <td class="text-right"><input type="text" name="banner_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $banner_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                        <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                      </tr>
                      <?php $image_row++; ?>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4"></td>
                        <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_banner_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                      </tr>
                    </tfoot>
                  </table>
                </form>
              </div>
            </div>
          </div>
          <script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
          <script type="text/javascript"><!--
            var image_row = <?php echo $image_row; ?>;


            $(window).load(function(){

            <?php foreach ($languages as $language) { ?>
              var lg<?php echo $language['language_id']; ?> = <?php echo $language['language_id']; ?>;
              for(var k = 0 ; k < image_row ; k++){
                var checker = document.getElementById("banner_image["+k+"][banner_image_description][<?php echo $language['language_id']; ?>][set_description]");
                if(checker){
                  checked_q = checker.checked;
                  if( checked_q == true){                    
                    ckeditor_function(k,lg<?php echo $language['language_id']; ?>);
                  }else{
                   clear_textarea(k,lg<?php echo $language['language_id']; ?>);
                  }
                }

              }
            <?php } ?>

            });
            <?php foreach ($languages as $language) { ?>
              var lg<?php echo $language['language_id']; ?> = <?php echo $language['language_id']; ?>;
              function unique_identifyer<?php echo $language['language_id']; ?>(obj){

                var tt = $(obj).attr("data-row");
                if($(obj).context.checked){
                  ckeditor_function(tt,lg<?php echo $language['language_id']; ?>);
                }else{
                  CKEDITOR.instances["banner_image["+tt+"][banner_image_description][<?php echo $language['language_id']; ?>][description]"].destroy();
                  clear_textarea(tt,lg<?php echo $language['language_id']; ?>);
                }
              }
            
            <?php } ?>
            function clear_textarea(target_k,language_id){
               var get_textarea = document.getElementById('banner_image['+target_k+'][banner_image_description]['+language_id+'][description]');
                    //console.log(get_textarea);
                    if(get_textarea){
                      //console.log(get_textarea);
                      get_textarea.value = "";
                    }
            }

            function ckeditor_function(target_k,language_id){
              CKEDITOR.replace('banner_image['+target_k+'][banner_image_description]['+language_id+'][description]', {
                height: 150,
                customConfig: CKEDITOR.basePath+"config_banner.js"
              });

              CKEDITOR.on('dialogDefinition', function (event){
                var editor = event.editor;
                var dialogDefinition = event.data.definition;
                var dialogName = event.data.name;

                var tabCount = dialogDefinition.contents.length;
                for (var i = 0; i < tabCount; i++) {
                  var browseButton = dialogDefinition.contents[i].get('browse');

                  if (browseButton !== null) {
                    browseButton.hidden = false;
                    browseButton.onClick = function() {
                      $('#modal-image').remove();
                      var element = this;
                      var target = $("#"+element.domId).parents('.cke_dialog_ui_vbox').find('input').attr("id");
                      var fm = $('<div/>').dialogelfinder({
                        url : 'index.php?route=common/filemanager/connector&token=' + getURLVar('token'),
                        lang : 'en',
                        destroyOnClose : true,
                        getFileCallback : function(files, fm) {
                          console.log(files);
                          $('#'+target).val(files.url);
                        },
                        commandsOptions : {
                          getfile : {
                            oncomplete : 'close',
                            folders : false
                          }
                        }
                      }).dialogelfinder('instance'); 
                      $('.dialogelfinder').css({'z-index':'99999999'}); 
                    }
                  }
                }
              }); 
            }

            function addImage() {
             html  = '<tr id="image-row' + image_row + '">';
             html += '  <td class="text-left">';
             <?php foreach ($languages as $language) { ?>
               html += '    <div class="input-group">';
               html += '      <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="banner_image[' + image_row + '][banner_image_description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="<?php echo $entry_title; ?>" class="form-control" /> <label style = "width:100%;"><input type = "checkbox"  onclick = "unique_identifyer<?php echo $language['language_id']; ?>(this)" data-row = "' + image_row + '" id = "banner_image[' + image_row + '][banner_image_description][<?php echo $language['language_id']; ?>][set_description]" name = "banner_image[' + image_row + '][banner_image_description][<?php echo $language['language_id']; ?>][set_description]" value = "1" /><?php echo $column_make_description; ?></label><textarea type="text" id = "banner_image[' + image_row + '][banner_image_description][<?php echo $language['language_id']; ?>][description]" name="banner_image[' + image_row + '][banner_image_description][<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_link; ?>" class="form-control hidden" /></textarea>';
               html += '    </div>';
               <?php } ?>
               html += '  </td>'; 
               html += '  <td class="text-left"><input type="text" id = "banner_image[' + image_row + '][link]" name="banner_image[' + image_row + '][link]" value="" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>'; 
               html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="banner_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
               html += '  <td class="text-right"><input type="text" name="banner_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
               html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
               html += '</tr>';

               $('#images tbody').append(html);

               image_row++;
             }
//--></script></div>
<?php echo $footer; ?>