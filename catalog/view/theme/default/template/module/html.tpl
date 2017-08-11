<div>
  <?php if($heading_title) { ?>
    <h2><?php echo $heading_title; ?></h2>
  <?php } ?>
  <?php echo str_replace('localhost',$_SERVER['HTTP_HOST'],$html); echo "<br><br>"; ?>
</div>
