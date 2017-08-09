<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row">
    <?php if($information_id != 12){ ?>
      <div class="banner_navigation col-sm-12">
        <a href="<?php echo $company_profile; ?>">
          <button class="<?php echo $company_profile_active; ?>"><?php echo $text_company_profile; ?></button>
        </a>&nbsp;
        <a href="<?php echo $our_benefits; ?>"><button class="<?php echo $our_benefits_active; ?>"><?php echo $text_our_benefits; ?>
          </button>
        </a>&nbsp;
        <a href="<?php echo $certifications; ?>"><button class="<?php echo $certifications_active; ?>"><?php echo $text_certifications; ?></button>
        </a>
      </div>
    <?php } ?>
    <div id="content" class="col-sm-12">
      <center>
        <div class="hr_col col-sm-4">
          <hr>
        </div>
        <div class="col-sm-4"><h1 class="information_title"><?php echo $heading_title; ?></h1></div>
        <div class="hr_col col-sm-4">
          <hr>
        </div>
      </center>
      <div class="row">
        <div class="col"></div>
      </div>
      <?php $type= isset($_GET['type']) && $_GET['type'] != "" ? $_GET['type'] : 0; ?>
      <?php echo $description; ?>
      <?php if($information_id == 8){ ?>
        <div class="row">
          <div id="company_timeline" class="col-xs-12">
        <?php 
          $counter = 1;
          foreach ($company_timeline as $banner) { 
            $counter++;
        ?>
        <?php $class = (($counter % 2) == 1) ? "down" : "up"; ?>
          <div class="<?php echo $class; ?> timeline col-xs-12">
            <img src="<?php echo 'image/'.$banner['image']; ?>">
            <span class="title"><?php echo $banner['title']; ?></span>
            <span class="description"><?php echo html_entity_decode($banner['description']); ?></span>
          </div>
        <?php }; ?>
          </div>
          <div id="company_clients_logo" class="col-xs-12">
            <?php if($company_clients): ?>
              <?php foreach ($company_clients as $client) {
                echo "<div class='col-md-2 col-sm-4 col-xs-2'><img class='img-responsive' src='image/".$client['image']."'></div>";
              } ?>
            <?php endif; ?>
        </div>

        <div id="company_testimonial_section" class="col-xs-12">
        <hr>
        <h3 class="about_us_section_title"><?php echo $text_testimonials; ?></h3>
          <?php 
            if($testimonials):
              foreach ($testimonials as $testimonial) {
                echo "<div class='testimonials col-md-6 col-xs-12'><p>" . html_entity_decode($testimonial['text']) . "</p><br><span class='author'>".$testimonial['author']."</span><br><span class='date_added'>".$testimonial['date_added']."</span></div>";
              }
            endif;
           ?>
           <div class="col-md-12">
             <br>
             <a href="<?php echo $testimonial_link; ?>"><button class="btn_green"><?php echo $text_see_more; ?></button></a>
           </div> 
        </div>
      <?php } ?>
      <?php if($information_id == 9){ echo $content_bottom; } ?>
      <?php if($information_id == 10){ ?>
      <center>  
        <div id="certifications">
          <p><span style="font-size: 18px; text-align: center; color: rgb(0, 0, 0);">&nbsp;&nbsp;</span><a href="index.php?route=information/information&amp;information_id=10&amp;type=0" style="font-size: 18px; text-align: center;"><span class="<?php if($type == 0){ echo "active"; } ?>"  style="color: rgb(0, 0, 0);">Test Reports</span></a><span  style="font-size: 18px; text-align: center; color: rgb(0, 0, 0);">&nbsp;&nbsp;&nbsp;&nbsp;</span><a href="index.php?route=information/information&amp;information_id=10&amp;type=1" style="font-size: 18px; text-align: center;"><span class="<?php if($type == 1){ echo "active"; } ?>" style="color: rgb(0, 0, 0);">Product Certifications</span></a><span style="font-size: 18px; text-align: center; color: rgb(0, 0, 0);">&nbsp;&nbsp;&nbsp;&nbsp;</span><a href="index.php?route=information/information&amp;information_id=10&amp;type=2" style="font-size: 18px; text-align: center;"><span class="<?php if($type == 2){ echo "active"; } ?>" style="color: rgb(0, 0, 0);">Awards</span></a><span style="font-size: 18px; text-align: center; color: rgb(0, 0, 0);">&nbsp;&nbsp;</span></p>
          </div>
        </center>
       <?php echo $content_middle; } ?>
    </div>
  </div>
</div>
<div id="information_services">
  <?php if($information_id == 12){ echo $content_service; ?>
  <div class="container">
    <div class="col-md-12">
        <div class="col-md-6">
          asdasd
        </div>
        <div class="col-md-6">
          asdasd
        </div>
    </div>
  </div>
  <?php } ?>
</div>

</div>
<?php echo $footer; ?>

<script type="text/javascript">
    $('#company_timeline').owlCarousel({
    items: 4,
    autoPlay: 3000,
    navigation: true,
    navigationText: ['<i class="left-arrow fa-5x"></i>', '<i class="right-arrow fa-5x"></i>'],
    pagination: true
  });
</script>