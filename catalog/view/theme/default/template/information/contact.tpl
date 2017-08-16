<?php echo $header; ?>
<?php echo $content_top; ?>
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
    <div id="content" class="<?php echo $class; ?>">
      <div class="container">
        <div class="row">
          <div class="banner_navigation col-sm-12">
            <a href="<?php echo $contact_url; ?>"><button class="active"><?php echo $text_contact_details; ?></button></a>&nbsp;<a href="<?php echo $career; ?>"><button><?php echo $text_career; ?></button></a>
          </div>
        </div>
        <?php if ($geocode) { ?>
          <div id="geocode_col" class="col-sm-12">
            <?php echo $geocode; ?>
          </div>
        <?php } ?>
      <h1 class="green_labels">&nbsp;</h1>
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-6">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <fieldset>
              <h3 class="green_labels"><?php echo $text_contact; ?></h3>
              <div class="form-group required">
                <label class="col-sm-3 control-label" for="input-name"><?php echo $entry_name; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
                  <?php if ($error_name) { ?>
                  <div class="text-danger"><?php echo $error_name; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label" for="input-email"><?php echo $entry_email; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
                  <?php if ($error_email) { ?>
                  <div class="text-danger"><?php echo $error_email; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label" for="input-contact"><?php echo $entry_contact; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="contact" value="<?php echo $contact; ?>" id="input-contact" class="form-control" />
                  <?php if ($error_contact) { ?>
                  <div class="text-danger"><?php echo $error_contact; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-3 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
                <div class="col-sm-9">
                  <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
                  <?php if ($error_enquiry) { ?>
                  <div class="text-danger"><?php echo $error_enquiry; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php if ($site_key) { ?>
                <div class="form-group">
                  <div class="col-sm-6">
                    <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
                    <?php if ($error_captcha) { ?>
                      <div class="text-danger"><?php echo $error_captcha; ?></div>
                    <?php } ?>
                  </div>
                    <div class="col-sm-6">
                      <div class="buttons">
                        <div class="pull-right">
                          <button style="max-width: 100%;" type="submit" class="btn_common"><?php echo $button_submit; ?></button>
                        </div>
                      </div>
                    </div>
                </div>
              <?php } ?>
            </fieldset>
          </form>
          </div>
          <div class="col-sm-6">
            <div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <a role="button" data-toggle="collapse" data-parent=".accordion" href="#office_address" aria-expanded="false" aria-controls="collapseOne">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                      <?php echo strtoupper($text_office_address); ?>
                      <span class="pull-right">___</span>
                  </h4>
                </div>
                </a>
                <div id="office_address" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <div class="row">
                      <div class="address_col col-sm-12"><?php echo $address; ?></div>
                      <div class="address_col col-sm-12">Tel: <?php echo $telephone; ?></div>
                      <div class="address_col col-sm-12"><?php echo $text_email; echo ":&nbsp;"; echo $config_email; ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php if($locations): foreach($locations as $location):?>
            <div class="panel-group accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <a role="button" data-toggle="collapse" data-parent=".accordion" href="#offce_<?php echo $location['location_id'] ?>" aria-expanded="false" aria-controls="collapseOne">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                      <?php echo strtoupper($location['name']); ?>
                      <span class="pull-right">___</span>
                  </h4>
                </div>
                </a>
                <div id="offce_<?php echo $location['location_id'] ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <div class="row">
                      <div class="address_col col-sm-12"><?php echo $address; ?></div>
                      <div class="address_col col-sm-12">Tel: <?php echo $location['address']; ?></div>
                      <div class="address_col col-sm-12"><?php echo $text_email; echo ":&nbsp;"; echo $location['email']; ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; endif; ?>
          </div>
        </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
