<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="container">
	<div id="content">
		<div id="search" class="input-group">
		  <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" class="form-control input-lg" />
		  <span class="input-group-btn">
		    <button type="button" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
		  </span>
		</div>
	</div>
</div>
<?php echo $footer; ?>