<form action="<?php echo $action; ?>" method="post" id="payment-form">
  <input type="hidden" name="amount" value="<?php echo $amount ?>" />
  <input type="hidden" name="txnRef" value="<?php echo $reference_no; ?>" />
  <input type="hidden" name="mid" value="<?php echo $merchant_id; ?>" />
  <input type="hidden" name="umapiType" value="<?php echo $umapi_type; ?>" />
  <div class="buttons">
    <div class="pull-right">
      <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
    </div>
  </div>
</form>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$('#payment-form').submit();
});
//--></script>
