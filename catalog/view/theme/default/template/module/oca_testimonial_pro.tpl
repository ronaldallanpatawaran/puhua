<h3><?php echo $heading_title; ?></h3>
<div class="row">
  
  <div id="testimonial<?php echo $module; ?>" class="owl-carousel col-lg-3 col-md-3 col-sm-6 col-xs-12">

    <?php foreach ($testimonials as $testimonial) { ?>
    <div class="col-sm-12 oca_testimonial ocatestimonial">
      <img src="<?php echo $testimonial['thumb'] ?>" class="img-thumbnail" />
      <p><?php echo $testimonial['text'] ?></p>
      <b>-<?php echo $testimonial['author'] ?></b>
    </div>
    <?php } ?>
  </div>
  
  
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <?php if($navigation) { ?>
    <a class="btn prev"><?php echo $button_prev; ?></a>
    <a class="btn next"><?php echo $button_next; ?></a>
  <?php } ?>  
    <a href="<?php echo $viewall; ?>" class="btn"><?php echo $button_viewall; ?></a>
  </div>
  

  <script type="text/javascript">
    $(document).ready(function() {
      var owl = $("#testimonial<?php echo $module; ?>");
      owl.owlCarousel({
        autoPlay : <?php echo $autoplay_delay; ?>,
        stopOnHover : <?php echo $autoplay_on_hover; ?>,
        autoHeight : true,
        transitionStyle:"fade",
        items : <?php echo $limit_row; ?>,
        singleItem : false,
        pagination : false,

      });
      // Custom Navigation Events
      $(".next").click(function(){
        owl.trigger('owl.next');
      })
      $(".prev").click(function(){
        owl.trigger('owl.prev');
      })
    });
  </script>  
  <script type="text/javascript">
  WebFont.load({
    google: {
      families: ['<?php echo $font; ?>']
    }
  });
</script>
</div>
