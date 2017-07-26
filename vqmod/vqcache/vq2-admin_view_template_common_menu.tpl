
			<?php global $config; global $registry; $muser = $registry->get('user');if (($config->get('menuhide_menu')) && ($config->get('menuhide_status'))){$menucheck = 1;} else {$menucheck = 0;}?>
			
<ul id="menu">
  
		    <?php if ($menucheck){if ( $muser->hasPermission('access','dashboard/order') || 
				 $muser->hasPermission('access','dashboard/sale') ||
				 $muser->hasPermission('access','dashboard/customer') ||
				 $muser->hasPermission('access','dashboard/online') ||
				 $muser->hasPermission('access','dashboard/map') ||
				 $muser->hasPermission('access','dashboard/chart') ||
				 $muser->hasPermission('access','dashboard/activity') ||
				 $muser->hasPermission('access','dashboard/recent')
				 )  {?><li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li><?php }
				}else{ ?><li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li><?php } ?>
			
  <li id="catalog"><a class="parent"><i class="fa fa-tags fa-fw"></i> <span><?php echo $text_catalog; ?></span></a>
    <ul>
      
		    <?php if ($menucheck){
				if (($muser->hasPermission('access','catalog/category'))) {?>
				  <li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>			
				<?php }}else{ ?>
			<li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/product')) ) {?>
			  <li><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></li>
			<?php }}else{ ?>
			 <li><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/recurring')) ) {?>
			  <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
			<?php }}else{ ?>
			 <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/filter')) ) {?>
			  <li><a href="<?php echo $filter; ?>"><?php echo $text_filter; ?></a></li>
			<?php }}else{ ?>
			 <li><a href="<?php echo $filter; ?>"><?php echo $text_filter; ?></a></li>
			<?php } ?>
			
      <li><a class="parent"><?php echo $text_attribute; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/attribute')) ) {?>
         	  <li><a href="<?php echo $attribute; ?>"><?php echo $text_attribute; ?></a></li>
        	<?php }}else{ ?>
			<li><a href="<?php echo $attribute; ?>"><?php echo $text_attribute; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/attribute_group')) ) {?>
              <li><a href="<?php echo $attribute_group; ?>"><?php echo $text_attribute_group; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $attribute_group; ?>"><?php echo $text_attribute_group; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/option')) ) {?>
              <li><a href="<?php echo $option; ?>"><?php echo $text_option; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $option; ?>"><?php echo $text_option; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/manufacturer')) ) {?>
              <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/download')) ) {?>
              <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/review')) ) {?>
              <li><a href="<?php echo $review; ?>"><?php echo $text_review; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $review; ?>"><?php echo $text_review; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/information')) ) {?>
              <li><a href="<?php echo $information; ?>"><?php echo $text_information; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $information; ?>"><?php echo $text_information; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/oca_testimonial_pro')) ) {?>
              <li><a href="<?php echo $testimonial; ?>"><?php echo $text_testimonial; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $testimonial; ?>"><?php echo $text_testimonial; ?></a></li>
			<?php } ?>
			
      <li><a class="parent"><?php echo $text_gallimage; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/gallimage_category')) ) {?>
              <li><a href="<?php echo $gallimage_category; ?>"><?php echo $text_gallimage_category; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $gallimage_category; ?>"><?php echo $text_gallimage_category; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/gallimage')) ) {?>
              <li><a href="<?php echo $gallimage; ?>"><?php echo $text_gallimage_list; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $gallimage; ?>"><?php echo $text_gallimage_list; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
    </ul>
  </li>
  <li id="blog"><a class="parent"><i class="fa fa-book fa-fw"></i> <span>News/Blog</span></a>
    <ul>
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/news')) ) {?>
              <li><a href="<?php echo $npages; ?>"><?php echo $entry_npages; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $npages; ?>"><?php echo $entry_npages; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/ncategory')) ) {?>
              <li><a href="<?php echo $ncategory; ?>"><?php echo $entry_ncategory; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $ncategory; ?>"><?php echo $entry_ncategory; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/ncomments')) ) {?>
              <li><a href="<?php echo $tocomments; ?>"><?php echo $text_commod; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $tocomments; ?>"><?php echo $text_commod; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','catalog/nauthor')) ) {?>
              <li><a href="<?php echo $nauthor; ?>"><?php echo $text_nauthor; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $nauthor; ?>"><?php echo $text_nauthor; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','module/news')) ) {?>
              <li><a href="<?php echo $nmod; ?>"><?php echo $entry_nmod; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $nmod; ?>"><?php echo $entry_nmod; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','module/ncategory')) ) {?>
              <li><a href="<?php echo $ncmod; ?>"><?php echo $entry_ncmod; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $ncmod; ?>"><?php echo $entry_ncmod; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','module/news_archive')) ) {?>
              <li><a href="<?php echo $namod; ?>"><?php echo $entry_namod; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $namod; ?>"><?php echo $entry_namod; ?></a></li>
			<?php } ?>
			
    </ul>
  </li>
  <li id="extension"><a class="parent"><i class="fa fa-puzzle-piece fa-fw"></i> <span><?php echo $text_extension; ?></span></a>
    <ul>
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','extension/module')) ) {?>
              <li><a href="<?php echo $module; ?>"><?php echo $text_module; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $module; ?>"><?php echo $text_module; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','extension/shipping')) ) {?>
              <li><a href="<?php echo $shipping; ?>"><?php echo $text_shipping; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $shipping; ?>"><?php echo $text_shipping; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','extension/payment')) ) {?>
              <li><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','extension/total')) ) {?>
              <li><a href="<?php echo $total; ?>"><?php echo $text_total; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $total; ?>"><?php echo $text_total; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','extension/feed')) ) {?>
              <li><a href="<?php echo $feed; ?>"><?php echo $text_feed; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $feed; ?>"><?php echo $text_feed; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','extension/fraud')) ) {?>
              <li><a href="<?php echo $fraud; ?>"><?php echo $text_fraud; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $fraud; ?>"><?php echo $text_fraud; ?></a></li>
			<?php } ?>
			
      <?php if ($openbay_show_menu == 1) { ?>
      <li><a class="parent"><?php echo $text_openbay_extension; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','extension/openbay')) ) {?>
              <li><a href="<?php echo $openbay_link_extension; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_extension; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','extension/openbay')) ) {?>
              <li><a href="<?php echo $openbay_link_orders; ?>"><?php echo $text_openbay_orders; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_orders; ?>"><?php echo $text_openbay_orders; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','extension/openbay')) ) {?>
              <li><a href="<?php echo $openbay_link_items; ?>"><?php echo $text_openbay_items; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_items; ?>"><?php echo $text_openbay_items; ?></a></li>
			<?php } ?>
			
          <?php if ($openbay_markets['ebay'] == 1) { ?>
          <li><a class="parent"><?php echo $text_openbay_ebay; ?></a>
            <ul>
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/ebay')) ) {?>
              <li><a href="<?php echo $openbay_link_ebay; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_ebay; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/ebay')) ) {?>
              <li><a href="<?php echo $openbay_link_ebay_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
         	<?php }}else{ ?>
			 <li><a href="<?php echo $openbay_link_ebay_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/ebay')) ) {?>
              <li><a href="<?php echo $openbay_link_ebay_links; ?>"><?php echo $text_openbay_links; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_ebay_links; ?>"><?php echo $text_openbay_links; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/ebay')) ) {?>
              <li><a href="<?php echo $openbay_link_ebay_orderimport; ?>"><?php echo $text_openbay_order_import; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_ebay_orderimport; ?>"><?php echo $text_openbay_order_import; ?></a></li>
			<?php } ?>
			
            </ul>
          </li>
          <?php } ?>
          <?php if ($openbay_markets['amazon'] == 1) { ?>
          <li><a class="parent"><?php echo $text_openbay_amazon; ?></a>
            <ul>
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/amazon')) ) {?>
              <li><a href="<?php echo $openbay_link_amazon; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_amazon; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/amazon')) ) {?>
              <li><a href="<?php echo $openbay_link_amazon_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_amazon_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/amazon')) ) {?>
              <li><a href="<?php echo $openbay_link_amazon_links; ?>"><?php echo $text_openbay_links; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_amazon_links; ?>"><?php echo $text_openbay_links; ?></a></li>
			<?php } ?>
			
            </ul>
          </li>
          <?php } ?>
          <?php if ($openbay_markets['amazonus'] == 1) { ?>
          <li><a class="parent"><?php echo $text_openbay_amazonus; ?></a>
            <ul>
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/amazonus')) ) {?>
              <li><a href="<?php echo $openbay_link_amazonus; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
         	<?php }}else{ ?>
			 <li><a href="<?php echo $openbay_link_amazonus; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/amazonus')) ) {?>
              <li><a href="<?php echo $openbay_link_amazonus_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_amazonus_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','openbay/amazonus')) ) {?>
              <li><a href="<?php echo $openbay_link_amazonus_links; ?>"><?php echo $text_openbay_links; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $openbay_link_amazonus_links; ?>"><?php echo $text_openbay_links; ?></a></li>
			<?php } ?>
			
            </ul>
          </li>
          <?php } ?>
          <?php if ($openbay_markets['etsy'] == 1) { ?>
          <li><a class="parent"><?php echo $text_openbay_etsy; ?></a>
            <ul>
              <li><a href="<?php echo $openbay_link_etsy; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
              <li><a href="<?php echo $openbay_link_etsy_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
              <li><a href="<?php echo $openbay_link_etsy_links; ?>"><?php echo $text_openbay_links; ?></a></li>
            </ul>
          </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </li>
  <li id="sale"><a class="parent"><i class="fa fa-shopping-cart fa-fw"></i> <span><?php echo $text_sale; ?></span></a>
    <ul>
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','sale/order')) ) {?>
              <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','sale/recurring')) ) {?>
              <li><a href="<?php echo $order_recurring; ?>"><?php echo $text_order_recurring; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $order_recurring; ?>"><?php echo $text_order_recurring; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','sale/return')) ) {?>
              <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
			<?php } ?>
			
      <li><a class="parent"><?php echo $text_customer; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','sale/customer')) ) {?>
              <li><a href="<?php echo $customer; ?>"><?php echo $text_customer; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $customer; ?>"><?php echo $text_customer; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','sale/customer_group')) ) {?>
              <li><a href="<?php echo $customer_group; ?>"><?php echo $text_customer_group; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $customer_group; ?>"><?php echo $text_customer_group; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','sale/custom_field')) ) {?>
              <li><a href="<?php echo $custom_field; ?>"><?php echo $text_custom_field; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $custom_field; ?>"><?php echo $text_custom_field; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','sale/customer_ban_ip')) ) {?>
              <li><a href="<?php echo $customer_ban_ip; ?>"><?php echo $text_customer_ban_ip; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $customer_ban_ip; ?>"><?php echo $text_customer_ban_ip; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_voucher; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','sale/voucher')) ) {?>
              <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','sale/voucher_theme')) ) {?>
              <li><a href="<?php echo $voucher_theme; ?>"><?php echo $text_voucher_theme; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $voucher_theme; ?>"><?php echo $text_voucher_theme; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_paypal ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','payment/pp_express')) ) {?>
              <li><a href="<?php echo $paypal_search ?>"><?php echo $text_paypal_search ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $paypal_search ?>"><?php echo $text_paypal_search ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
    </ul>
  </li>
  <li><a class="parent"><i class="fa fa-share-alt fa-fw"></i> <span><?php echo $text_marketing; ?></span></a>
    <ul>
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','marketing/marketing')) ) {?>
              <li><a href="<?php echo $marketing; ?>"><?php echo $text_marketing; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $marketing; ?>"><?php echo $text_marketing; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','marketing/affiliate')) ) {?>
              <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','marketing/coupon')) ) {?>
              <li><a href="<?php echo $coupon; ?>"><?php echo $text_coupon; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $coupon; ?>"><?php echo $text_coupon; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','marketing/contact')) ) {?>
              <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
			<?php } ?>
			
    </ul>
  </li>
  <li id="system"><a class="parent"><i class="fa fa-cog fa-fw"></i> <span><?php echo $text_system; ?></span></a>
    <ul>
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','setting/store')) ) {?>
              <li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li>
         	<?php }}else{ ?>
			 <li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li>
			<?php } ?>
			
      <li><a class="parent"><?php echo $text_design; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','design/layout')) ) {?>
              <li><a href="<?php echo $layout; ?>"><?php echo $text_layout; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $layout; ?>"><?php echo $text_layout; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','design/banner')) ) {?>
              <li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_users; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','user/user')) ) {?>
              <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
         	<?php }}else{ ?>
			 <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','user/user_permission')) ) {?>
              <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','user/api')) ) {?>
              <li><a href="<?php echo $api; ?>"><?php echo $text_api; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $api; ?>"><?php echo $text_api; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
      
             <?php if ($menucheck){ if (
			(($muser->hasPermission('access','localisation/return_reason')) || 
			($muser->hasPermission('access','localisation/return_status')) ||
			($muser->hasPermission('access','localisation/return_action')) ||
			($muser->hasPermission('access','localisation/location')) ||
			($muser->hasPermission('access','localisation/language')) ||
			($muser->hasPermission('access','localisation/currency')) ||
			($muser->hasPermission('access','localisation/stock_status')) ||
			($muser->hasPermission('access','localisation/order_status')) ||
			($muser->hasPermission('access','localisation/country')) ||
			($muser->hasPermission('access','localisation/zone')) ||
			($muser->hasPermission('access','localisation/geo_zone')) ||
			($muser->hasPermission('access','localisation/tax_class')) ||
			($muser->hasPermission('access','localisation/tax_rate')) ||
			($muser->hasPermission('access','localisation/length_class')) ||
			($muser->hasPermission('access','localisation/weight_class'))) 
			) {?>
            <li><a class="parent"><?php echo $text_localisation; ?></a>
         	<?php }else{ ?>
			<li><a class="parent" style="display:none!important;"><?php echo $text_localisation; ?></a>	
			<?php }}else{ ?>
            <li><a class="parent"><?php echo $text_localisation; ?></a>
			<?php } ?>
			
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/location')) ) {?>
              <li><a href="<?php echo $location; ?>"><?php echo $text_location; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $location; ?>"><?php echo $text_location; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/language')) ) {?>
              <li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/currency')) ) {?>
              <li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/stock_status')) ) {?>
              <li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
         	<?php }}else{ ?>
			<li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/order_status')) ) {?>
              <li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
			<?php } ?>
			
          <li><a class="parent"><?php echo $text_return; ?></a>
            <ul>
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/return_status')) ) {?>
              <li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/return_action')) ) {?>
              <li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/return_reason')) ) {?>
              <li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
			<?php } ?>
			
            </ul>
          </li>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/country')) ) {?>
              <li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/zone')) ) {?>
              <li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/geo_zone')) ) {?>
              <li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
			<?php } ?>
			
          <li><a class="parent"><?php echo $text_tax; ?></a>
            <ul>
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/tax_class')) ) {?>
              <li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
			<?php } ?>
			
              
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/tax_rate')) ) {?>
              <li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li>
			<?php } ?>
			
            </ul>
          </li>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/length_class')) ) {?>
              <li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','localisation/weight_class')) ) {?>
              <li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
    </ul>
  </li>
  <li id="tools"><a class="parent"><i class="fa fa-wrench fa-fw"></i> <span><?php echo $text_tools; ?></span></a>
    <ul>
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','tool/upload')) ) {?>
              <li><a href="<?php echo $upload; ?>"><?php echo $text_upload; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $upload; ?>"><?php echo $text_upload; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','tool/backup')) ) {?>
              <li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>
			<?php } ?>
			
      
             <?php if ($menucheck){ if (($muser->hasPermission('access','tool/error_log')) ) {?>
              <li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
			<?php } ?>
			
    </ul>
  </li>
  <li id="reports"><a class="parent"><i class="fa fa-bar-chart-o fa-fw"></i> <span><?php echo $text_reports; ?></span></a>
    <ul>
      <li><a class="parent"><?php echo $text_sale; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/sale_order')) ) {?>
              <li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/sale_tax')) ) {?>
              <li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/sale_shipping')) ) {?>
              <li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/sale_return')) ) {?>
              <li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/sale_coupon')) ) {?>
              <li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_product; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/product_viewed')) ) {?>
              <li><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/product_purchased')) ) {?>
              <li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_customer; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/customer_online')) ) {?>
              <li><a href="<?php echo $report_customer_online; ?>"><?php echo $text_report_customer_online; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_customer_online; ?>"><?php echo $text_report_customer_online; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/customer_activity')) ) {?>
              <li><a href="<?php echo $report_customer_activity; ?>"><?php echo $text_report_customer_activity; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_customer_activity; ?>"><?php echo $text_report_customer_activity; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/customer_order')) ) {?>
              <li><a href="<?php echo $report_customer_order; ?>"><?php echo $text_report_customer_order; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_customer_order; ?>"><?php echo $text_report_customer_order; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/customer_reward')) ) {?>
             <li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li>
         	<?php }}else{ ?>
             <li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/customer_credit')) ) {?>
              <li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_marketing; ?></a>
        <ul>
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/marketing')) ) {?>
              <li><a href="<?php echo $report_marketing; ?>"><?php echo $text_marketing; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_marketing; ?>"><?php echo $text_marketing; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/affiliate')) ) {?>
              <li><a href="<?php echo $report_affiliate; ?>"><?php echo $text_report_affiliate; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_affiliate; ?>"><?php echo $text_report_affiliate; ?></a></li>
			<?php } ?>
			
          
             <?php if ($menucheck){ if (($muser->hasPermission('access','report/affiliate_activity')) ) {?>
              <li><a href="<?php echo $report_affiliate_activity; ?>"><?php echo $text_report_affiliate_activity; ?></a></li>
         	<?php }}else{ ?>
              <li><a href="<?php echo $report_affiliate_activity; ?>"><?php echo $text_report_affiliate_activity; ?></a></li>
			<?php } ?>
			
        </ul>
      </li>
    </ul>
  </li>
</ul>
