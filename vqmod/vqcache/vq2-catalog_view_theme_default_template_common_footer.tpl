<footer>
  <div class="container">
    <div class="row">
      <div class="col-sm-12"><?php echo $content_footer; ?></div>
        <div class="col-sm-3 col-xs-6">
          <h5><?php echo strtoupper($text_product); ?></h5>
          <ul class="list-unstyled">
            <li><?php echo $text_all_products; ?></li>
            <li><?php echo $text_news; ?></li>
          </ul>
        </div>
      <?php if ($informations) { ?>
      <div class="col-sm-3 col-xs-6">
        <h5><?php echo strtoupper($text_information); ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-3 col-xs-6">
        <h5><?php echo strtoupper($text_account); ?></h5>
        <div class="col-sm-6 col-xs-6" style="padding-left: 0px;">
          <ul class="list-unstyled">
            <li><a href="<?php echo $account; ?>"><?php echo $text_myaccount; ?></a></li>
            <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          </ul>
        </div>
        <div class="col-sm-6 col-xs-12" style="padding-left: 0px;">
            <ul class="list-unstyled">
              <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
            </ul>
        </div>
      </div>
      <div class="col-sm-3 col-xs-6">
        <h5><?php echo strtoupper($text_follow_us); ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $url_fb; ?>"><?php echo $text_fb; ?></a>&nbsp;<a href="<?php echo $url_ig; ?>"><?php echo $text_ig; ?></a>&nbsp;<a href="<?php echo $url_tw; ?>"><?php echo $text_tw; ?></a></li>
        </ul>
      </div>
    </div>
    <hr>
    <div class="clearfix">
      <p class="pull-left"><?php echo $text_firstcom; ?></p>
      <p class="pull-right"><?php echo $powered; ?></p>
    </div>
  </div>
</footer>
<?php echo $mailchimp_integration; ?>
</body></html>