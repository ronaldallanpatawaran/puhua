<?php if($redirect){?>
<form id="xpayment_form" action="<?php echo $redirect; ?>" method="<?php echo $redirect_type;?>">
  <?php
    foreach($form_data as $name=>$value){
  ?>
    <input type="hidden" name="<?php echo $name?>" value="<?php echo $value?>" />
  <?php } ?>
</form>
<?php } ?>

<h2><?php echo $xpayment_name; ?></h2>
<div class="well well-sm">
  <p><?php echo $xpayment_instruction; ?></p>
</div>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
  </div>
</div>
 
<script type="text/javascript"><!--
<?php if($redirect){ ?>
$('#button-confirm').bind('click', function() {
	 $("#xpayment_form").submit();
});
<?php } else { ?>
  
  $('#button-confirm').bind('click', function() {
	$.ajax({ 
		type: 'get',
		url: 'index.php?route=payment/xpayment/confirm',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},		
		success: function() {
			location = '<?php echo $continue; ?>';
		}		
	});
  });
  
<?php
 }
?>
//--></script> 

<style style="text/css">
.xpayment-instruction {
    padding: 5px 0;
}
</style>