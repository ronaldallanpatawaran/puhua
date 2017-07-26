<footer>
  <div class="container">
    <div class="row">
      <div class="col-sm-12"><?php echo $content_footer; ?></div>
      <?php if ($informations) { ?>
      <div class="col-sm-3">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-3">
        <h5><?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_extra; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>
    </div>
    <hr>
    <div class="clearfix">
      <p class="pull-left"><?php echo $powered; ?></p>
      <?php if ($url_fb || $url_tw || $url_ig) { ?>
      <ul class="list-inline pull-right socials">
        <?php if($url_fb) { ?>
        <li><a href="<?php echo $url_fb; ?>" target="_blank"><?php echo $text_fb; ?></a></li>
        <?php } ?>
        <?php if($url_tw) { ?>
        <li><a href="<?php echo $url_tw; ?>" target="_blank"><?php echo $text_tw; ?></a></li>
        <?php } ?>
        <?php if($url_ig) { ?>
        <li><a href="<?php echo $url_ig; ?>" target="_blank"><?php echo $text_ig; ?></a></li>
        <?php } ?>
      </ul>
      <?php } ?>
    </div>
  </div>
</footer>
</body></html>