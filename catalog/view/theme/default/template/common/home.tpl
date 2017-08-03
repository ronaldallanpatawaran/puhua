<?php echo $header; ?>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <?php echo $column_right; ?>
    </div>
    <div class="<?php echo $class; ?>">
        <?php echo $content_top; ?>
    </div>
</div>
<div id="home_background">
    <div class="container">
        <br><br><br>
        <div class="col-md-12">
            <?php echo $content_middle ?>
        </div>
    </div>
</div>
<div id="home_news">
    <div class="container">
        <div class="col-md-12">
            <center>
                <div class="hr_col col-sm-4">
                  <hr>
                </div>
                <div class="col-sm-4"><h1 class="information_title">OUR <strong>NEWS</strong></h1></div>
                <div class="hr_col col-sm-4">
                  <hr>
                </div>
          </center>
            <br>
        </div>
        <div class="col-md-12">
            <?php echo $content_bottom; ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <br>
                <center><a href="<?php echo $news; ?>"><button id="view_more">View More</button></a></center>
            </div>
        </div>

    </div>
</div>
<?php echo $footer; ?>