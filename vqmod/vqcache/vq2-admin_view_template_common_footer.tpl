
<script type="text/javascript"><!--
// Power Image Manager
$(document).ready(function() {
  $(document).undelegate('a[data-toggle=\'image\']', 'click');
	// Power Image Manager
	$(document).delegate('a[data-toggle=\'image\']', 'click', function(e) {
		e.preventDefault();

		var element = this;
	
		$(element).popover({
			html: true,
			placement: 'right',
			trigger: 'manual',
			content: function() {
				return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
			}
		});
	
		$(element).popover('toggle');		
	
		$('#button-image').on('click', function() {
      $(element).popover('hide');
      var target = $(element).parent().find('input').attr('id');
      var thumb = $(element).attr('id');
      var name_field = $(element).parents('tr').children('td:first').find('input[type ="text"]');
				var fm = $('<div/>').dialogelfinder({
				url : 'index.php?route=common/filemanager/connector&token=' + getURLVar('token'),
				lang : '<?php echo $lang;?>',
				width : <?php echo $width;?>,
				height: <?php echo $height;?>,
				destroyOnClose : true,
      uiOptions : {toolbar : [['home', 'back', 'forward'],['reload'],['mkdir', 'upload'],['open', 'download', 'getfile'],['info'],['quicklook'],['copy', 'cut', 'paste'],['rm'],['duplicate', 'rename', 'edit', 'resize'],['extract', 'archive','multiupload', 'sort'],['search'],['view'],['help']]},		
     
      contextmenu: {navbar: ["open", "|", "copy", "cut", "paste", "duplicate", "|", "rm", "|", "info"],cwd: ["reload", "back", "|", "upload", "mkdir", "mkfile", "paste", "|", "sort", "|", "info"],files: ["getfile", "|", "open", "quicklook", "|", "download", "|", "copy", "cut", "paste", "duplicate", "|", "rm", "|", "edit", "rename", "resize", "|", "archive","multiupload", "extract", "|", "info"]},				
				getFileCallback : function(files, fm) {
          console.log(files);
          $('#'+thumb).find('img').attr('src', files.tmb);
        	// $('#'+target).val(files.path);
          $('#'+target).val(files.path.replace(/\\/g, "/"));
          var filename = files.name.substring(0,63);
          name_field.val(filename);
        	$('#radio-'+target).removeAttr('disabled');  
        	$('#radio-'+target).val(files.path);
				},
				commandsOptions : {
					getfile : {
						oncomplete : 'close',
						folders : false
					}
				}
			}).dialogelfinder('instance');      
      return;
		}); 
	
		$('#button-clear').on('click', function() {
			$(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));
			
			$(element).parent().find('input').attr('value', '');
	
			$(element).popover('hide');
		});
	});  
	
	$(document).delegate('a[data-toggle=\'manager\']', 'click', function(e) {
		e.preventDefault();
				var fm = $('<div/>').dialogelfinder({
				url : 'index.php?route=common/filemanager/connector&token=' + getURLVar('token'),
				lang : '<?php echo $lang;?>',
				width : <?php echo $width;?>,
				height: <?php echo $height;?>,
				destroyOnClose : true,
        uiOptions : {toolbar : [['home', 'back', 'forward'],['reload'],['mkdir', 'upload'],['open', 'download', 'getfile'],['info'],['quicklook'],['copy', 'cut', 'paste'],['rm'],['duplicate', 'rename', 'edit', 'resize'],['extract', 'archive','multiupload'],['search'],['view'],['help']]},		
              contextmenu: {navbar: ["open", "|", "copy", "cut", "paste", "duplicate", "|", "rm", "|", "info"],cwd: ["reload", "back", "|", "upload", "mkdir", "mkfile", "paste", "|", "sort", "|", "info"],files: ["getfile", "|", "open", "quicklook", "|", "download", "|", "copy", "cut", "paste", "duplicate", "|", "rm", "|", "edit", "rename", "resize", "|", "archive","multiupload", "extract", "|", "info"]},						
				getFileCallback : function(files, fm) {
								console.log(files);
         addMultiImage(files.path);
				},
				commandsOptions : {
					getfile : {
						oncomplete : 'close',
						folders : false
					}
				}
			}).dialogelfinder('instance');      
	});  
	
 $(document).undelegate('button[data-toggle=\'image\']', 'click');

	$(document).delegate('button[data-toggle=\'image\']', 'click', function() {

				var fm = $('<div/>').dialogelfinder({
				url : 'index.php?route=common/filemanager/connector&token=' + getURLVar('token'),
				lang : '<?php echo $lang;?>',
				width : <?php echo $width;?>,
				height: <?php echo $height;?>,
				destroyOnClose : true,
				getFileCallback : function(files, fm) {
          					console.log(files);
          	var range, sel = window.getSelection(); 
          	
          	if (sel.rangeCount) { 
          		var img = document.createElement('img');
          		img.src = files.url;
          	
          		range = sel.getRangeAt(0); 
          		range.insertNode(img); 
          	}
          	

				},
				commandsOptions : {
					getfile : {
						oncomplete : 'close',
						folders : false
					}
				}
			}).dialogelfinder('instance');   		
    }); 
	
  
});        

// Power Image Manager
//--></script>
        
        
        
<footer id="footer"><?php echo $text_footer; ?><br /><?php echo $text_version; ?></footer></div>
</body></html>