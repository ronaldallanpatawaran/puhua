<?php echo $header; ?>
<?php echo $common_banner; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
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
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
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
      <?php echo $description; ?>
      <?php if($information_id == 9){ echo $content_bottom; } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>