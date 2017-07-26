<?php foreach($sections as $section) { ?>
<div id="section-tab-<?php echo $section['index']; ?>">
  <?php if ($section['title']){ ?>
  <h3><?php echo $section['title']; ?></h3>
  <?php } ?>
  
  <?php if ($section['groups']) { ?>
  <ul class="nav nav-tabs" role="tablist">
    <?php foreach($section['groups'] as $key => $group){ ?>
    <li role="presentation"><a href="#section-<?php echo $section['index']; ?>-<?php echo generateSlug($group['title']); ?>" aria-controls="section-<?php echo $section['index']; ?>-<?php echo generateSlug($group['title']); ?>" role="tab" data-toggle="tab"><?php echo $group['title']; ?></a></li>
    <?php } ?>
  </ul>

  <div class="tab-content">
    <?php foreach($section['groups'] as $key => $group){ ?>
    <div role="tabpanel" class="tab-pane fade" id="section-<?php echo $section['index']; ?>-<?php echo generateSlug($group['title']); ?>"><?php echo $group['description']; ?></div>
    <?php } ?>
  </div>
  <?php } ?>
</div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function () {
  <?php foreach($sections as $section) { ?>
  var section_index = <?php echo $section['index']; ?>;
  $('#section-tab-' + section_index + ' a:first').tab('show');
  <?php } ?>
});
</script>