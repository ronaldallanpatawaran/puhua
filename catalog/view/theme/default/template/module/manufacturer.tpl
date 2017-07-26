<?php if ($manufacturers) { ?>
<div class="list-group">
  <?php foreach ($manufacturers as $manufacturer) { ?>
  <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
    <a href="<?php echo $manufacturer['href']; ?>" class="list-group-item active">
      <?php echo $manufacturer['name']; ?>
      <?php if($manufacturer['image']) { ?>
      <img src="<?php echo $manufacturer['image']; ?>" alt="<?php echo $manufacturer['name']; ?>" class="img-responsive"  width="20px" style="float:right;"/>
      <?php } ?>
    </a>
  <?php } else { ?>
    <a href="<?php echo $manufacturer['href']; ?>" class="list-group-item">
      <?php echo $manufacturer['name']; ?>
      <?php if($manufacturer['image']) { ?>
      <img src="<?php echo $manufacturer['image']; ?>" alt="<?php echo $manufacturer['name']; ?>" class="img-responsive" width="20px"  style="float:right;"/>
      <?php } ?>
    </a>
  <?php } ?>
  <?php } ?>
</div>
<?php } ?>