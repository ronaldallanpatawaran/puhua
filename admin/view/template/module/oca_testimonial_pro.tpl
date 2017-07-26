<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-oca_testimonial_pro" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-oca_testimonial_pro" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-testimonial"><?php echo $entry_testimonial; ?></label>
            <div class="col-sm-10">
              <input type="text" name="testimonial" value="" placeholder="<?php echo $entry_testimonial; ?>" id="input-testimonial" class="form-control" />
              <div id="testimonial" class="well well-sm" style="height: 350px; overflow: auto;">
                <?php foreach ($testimonials as $testimonial) { ?>
                <div id="testimonial<?php echo $testimonial['testimonial_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $testimonial['name']; ?>
                  <input type="hidden" name="testimonial[]" value="<?php echo $testimonial['testimonial_id']; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit-row"><?php echo $entry_limit_row; ?></label>
            <div class="col-sm-10">
              <select name="limit_row" class="form-control">
                <option value="1" <?php if($limit_row == 1) { ?>selected="selected"<?php } ?> >1</option>
                <option value="2" <?php if($limit_row == 2) { ?>selected="selected"<?php } ?> >2</option>
                <option value="3" <?php if($limit_row == 3) { ?>selected="selected"<?php } ?> >3</option>
                <option value="4" <?php if($limit_row == 4) { ?>selected="selected"<?php } ?> >4</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-font"><span data-toggle="tooltip" data-placement="top" title="<?php echo $help_font; ?>"><?php echo $entry_font; ?></span></label>
            <div class="col-sm-10">
              <select name="font" placeholder="Font" id="input-font" class="form-control">
                <option value="Arial" <?php if($font == 'Arial') { echo ' selected="selected"'; } ?>>Arial</option>
                <option value="Verdana" <?php if($font == 'Verdana') { echo ' selected="selected"'; } ?>>Verdana </option>
                <option value="Comic Sans MS" <?php if($font == 'Comic Sans MS') { echo ' selected="selected"'; } ?>>Comic Sans MS</option>
                <option value="Open Sans" <?php if($font == 'Open Sans') { echo ' selected="selected"'; } ?>>Open Sans</option>
                <option value="Oswald" <?php if($font == 'Oswald') { echo ' selected="selected"'; } ?>>Oswald</option>
                <option value="Lobster" <?php if($font == 'Lobster') { echo ' selected="selected"'; } ?>>Lobster</option>
                <option value="Inconsolata" <?php if($font == 'Inconsolata') { echo ' selected="selected"'; } ?>>Inconsolata</option>
                <option value="Roboto" <?php if($font == 'Roboto') { echo ' selected="selected"'; } ?>>Roboto</option>
                <option value="Lato" <?php if($font == 'Lato') { echo ' selected="selected"'; } ?>>Lato</option>
                <option value="Roboto Condensed" <?php if($font == 'Roboto Condensed') { echo ' selected="selected"'; } ?>>Roboto Condensed</option>
                <option value="Source Sans Pro" <?php if($font == 'Source Sans Pro') { echo ' selected="selected"'; } ?>>Source Sans Pro</option>
                <option value="PT Sans" <?php if($font == 'PT Sans') { echo ' selected="selected"'; } ?>>PT Sans</option>
                <option value="Droid Sans" <?php if($font == 'Droid Sans') { echo ' selected="selected"'; } ?>>Droid Sans</option>
                <option value="Raleway" <?php if($font == 'Raleway') { echo ' selected="selected"'; } ?>>Raleway</option>
                <option value="Droid Serif" <?php if($font == 'Droid Serif') { echo ' selected="selected"'; } ?>>Droid Serif</option>
                <option value="Ubuntu" <?php if($font == 'Ubuntu') { echo ' selected="selected"'; } ?>>Ubuntu</option>
                <option value="Montserrat" <?php if($font == 'Montserrat') { echo ' selected="selected"'; } ?>>Montserrat</option>
                <option value="Roboto Slab" <?php if($font == 'Roboto Slab') { echo ' selected="selected"'; } ?>>Roboto Slab</option>
                <option value="PT Sans Narrow" <?php if($font == 'PT Sans Narrow') { echo ' selected="selected"'; } ?>>PT Sans Narrow</option>
                <option value="Lora" <?php if($font == 'Lora') { echo ' selected="selected"'; } ?>>Lora</option>
                <option value="Arimo" <?php if($font == 'Arimo') { echo ' selected="selected"'; } ?>>Arimo</option>
                <option value="Bitter" <?php if($font == 'Bitter') { echo ' selected="selected"'; } ?>>Bitter</option>
                <option value="Yanone Kaffeesatz" <?php if($font == 'Yanone Kaffeesatz') { echo ' selected="selected"'; } ?>>Yanone Kaffeesatz</option>
                <option value="Merriweather" <?php if($font == 'Merriweather') { echo ' selected="selected"'; } ?>>Merriweather</option>
                <option value="Arvo" <?php if($font == 'Arvo') { echo ' selected="selected"'; } ?>>Arvo</option>
                <option value="PT Serif" <?php if($font == 'PT Serif') { echo ' selected="selected"'; } ?>>PT Serif</option>
                <option value="Oxygen" <?php if($font == 'Oxygen') { echo ' selected="selected"'; } ?>>Oxygen</option>
                <option value="Indie Flower" <?php if($font == 'Indie Flower') { echo ' selected="selected"'; } ?>>Indie Flower</option>
                <option value="Noto Sans" <?php if($font == 'Noto Sans') { echo ' selected="selected"'; } ?>>Noto Sans</option>
                <option value="Dosis" <?php if($font == 'Dosis') { echo ' selected="selected"'; } ?>>Dosis</option>
                <option value="Francois One" <?php if($font == 'Francois One') { echo ' selected="selected"'; } ?>>Francois One</option>
                <option value="Titillium Web" <?php if($font == 'Titillium Web') { echo ' selected="selected"'; } ?>>Titillium Web</option>
                <option value="Fjalla One" <?php if($font == 'Fjalla One') { echo ' selected="selected"'; } ?>>Fjalla One</option>
                <option value="Cabin" <?php if($font == 'Cabin') { echo ' selected="selected"'; } ?>>Cabin</option>
                <option value="Shadows Into Light" <?php if($font == 'Shadows Into Light') { echo ' selected="selected"'; } ?>>Shadows Into Light</option>
                <option value="Vollkorn" <?php if($font == 'Vollkorn') { echo ' selected="selected"'; } ?>>Vollkorn</option>
                <option value="Playfair Display" <?php if($font == 'Playfair Display') { echo ' selected="selected"'; } ?>>Playfair Display</option>
                <option value="Archivo Narrow" <?php if($font == 'Archivo Narrow') { echo ' selected="selected"'; } ?>>Archivo Narrow</option>
                <option value="Muli" <?php if($font == 'Muli') { echo ' selected="selected"'; } ?>>Muli</option>
                <option value="Ubuntu Condensed" <?php if($font == 'Ubuntu Condensed') { echo ' selected="selected"'; } ?>>Ubuntu Condensed</option>
                <option value="Abel" <?php if($font == 'Abel') { echo ' selected="selected"'; } ?>>Abel</option>
                <option value="Nunito" <?php if($font == 'Nunito') { echo ' selected="selected"'; } ?>>Nunito</option>
                <option value="Signika" <?php if($font == 'Signika') { echo ' selected="selected"'; } ?>>Signika</option>
                <option value="Poiret One" <?php if($font == 'Poiret One') { echo ' selected="selected"'; } ?>>Poiret One</option>
                <option value="Play" <?php if($font == 'Play') { echo ' selected="selected"'; } ?>>Play</option>
                <option value="Bree Serif" <?php if($font == 'Bree Serif') { echo ' selected="selected"'; } ?>>Bree Serif</option>
                <option value="Cuprum" <?php if($font == 'Cuprum') { echo ' selected="selected"'; } ?>>Cuprum</option>
                <option value="Maven Pro" <?php if($font == 'Maven Pro') { echo ' selected="selected"'; } ?>>Maven Pro</option>
                <option value="Libre Baskerville" <?php if($font == 'Libre Baskerville') { echo ' selected="selected"'; } ?>>Libre Baskerville</option>
                <option value="Noto Serif" <?php if($font == 'Noto Serif') { echo ' selected="selected"'; } ?>>Noto Serif</option>
                <option value="Anton" <?php if($font == 'Anton') { echo ' selected="selected"'; } ?>>Anton</option>
                <option value="Rokkitt" <?php if($font == 'Rokkitt') { echo ' selected="selected"'; } ?>>Rokkitt</option>
                <option value="Alegreya" <?php if($font == 'Alegreya') { echo ' selected="selected"'; } ?>>Alegreya</option>
                <option value="Hammersmith One" <?php if($font == 'Hammersmith One') { echo ' selected="selected"'; } ?>>Hammersmith One</option>
                <option value="Asap" <?php if($font == 'Asap') { echo ' selected="selected"'; } ?>>Asap</option>
                <option value="Pacifico" <?php if($font == 'Pacifico') { echo ' selected="selected"'; } ?>>Pacifico</option>
                <option value="Karla" <?php if($font == 'Karla') { echo ' selected="selected"'; } ?>>Karla</option>
                <option value="Josefin Sans" <?php if($font == 'Josefin Sans') { echo ' selected="selected"'; } ?>>Josefin Sans</option>
                <option value="Exo" <?php if($font == 'Exo') { echo ' selected="selected"'; } ?>>Exo</option>
                <option value="Dancing Script" <?php if($font == 'Dancing Script') { echo ' selected="selected"'; } ?>>Dancing Script</option>
                <option value="Gloria Hallelujah" <?php if($font == 'Gloria Hallelujah') { echo ' selected="selected"'; } ?>>Gloria Hallelujah</option>
                <option value="Armata" <?php if($font == 'Armata') { echo ' selected="selected"'; } ?>>Armata</option>
                <option value="Quattrocento Sans" <?php if($font == 'Quattrocento Sans') { echo ' selected="selected"'; } ?>>Quattrocento Sans</option>
                <option value="PT Sans Caption" <?php if($font == 'PT Sans Caption') { echo ' selected="selected"'; } ?>>PT Sans Caption</option>
                <option value="Questrial" <?php if($font == 'Questrial') { echo ' selected="selected"'; } ?>>Questrial</option>
                <option value="Varela Round" <?php if($font == 'Varela Round') { echo ' selected="selected"'; } ?>>Varela Round</option>
                <option value="Merriweather Sans" <?php if($font == 'Merriweather Sans') { echo ' selected="selected"'; } ?>>Merriweather Sans</option>
                <option value="Architects Daughter" <?php if($font == 'Architects Daughter') { echo ' selected="selected"'; } ?>>Architects Daughter</option>
                <option value="Pathway Gothic One" <?php if($font == 'Pathway Gothic One') { echo ' selected="selected"'; } ?>>Pathway Gothic One</option>
                <option value="Quicksand" <?php if($font == 'Quicksand') { echo ' selected="selected"'; } ?>>Quicksand</option>
                <option value="Istok Web" <?php if($font == 'Istok Web') { echo ' selected="selected"'; } ?>>Istok Web</option>
                <option value="Pontano Sans" <?php if($font == 'Pontano Sans') { echo ' selected="selected"'; } ?>>Pontano Sans</option>
                <option value="Monda" <?php if($font == 'Monda') { echo ' selected="selected"'; } ?>>Monda</option>
                <option value="Comfortaa" <?php if($font == 'Comfortaa') { echo ' selected="selected"'; } ?>>Comfortaa</option>
                <option value="Ropa Sans" <?php if($font == 'Ropa Sans') { echo ' selected="selected"'; } ?>>Ropa Sans</option>
                <option value="Changa One" <?php if($font == 'Changa One') { echo ' selected="selected"'; } ?>>Changa One</option>
                <option value="Gudea" <?php if($font == 'Gudea') { echo ' selected="selected"'; } ?>>Gudea</option>
                <option value="Crimson Text" <?php if($font == 'Crimson Text') { echo ' selected="selected"'; } ?>>Crimson Text</option>
                <option value="Coming Soon" <?php if($font == 'Coming Soon') { echo ' selected="selected"'; } ?>>Coming Soon</option>
                <option value="News Cycle" <?php if($font == 'News Cycle') { echo ' selected="selected"'; } ?>>News Cycle</option>
                <option value="Crete Round" <?php if($font == 'Crete Round') { echo ' selected="selected"'; } ?>>Crete Round</option>
                <option value="Noticia Text" <?php if($font == 'Noticia Text') { echo ' selected="selected"'; } ?>>Noticia Text</option>
                <option value="Rambla" <?php if($font == 'Rambla') { echo ' selected="selected"'; } ?>>Rambla</option>
                <option value="Cabin Condensed" <?php if($font == 'Cabin Condensed') { echo ' selected="selected"'; } ?>>Cabin Condensed</option>
                <option value="Josefin Slab" <?php if($font == 'Josefin Slab') { echo ' selected="selected"'; } ?>>Josefin Slab</option>
                <option value="Amatic SC" <?php if($font == 'Amatic SC') { echo ' selected="selected"'; } ?>>Amatic SC</option>
                <option value="Lobster Two" <?php if($font == 'Lobster Two') { echo ' selected="selected"'; } ?>>Lobster Two</option>
                <option value="Glegoo" <?php if($font == 'Glegoo') { echo ' selected="selected"'; } ?>>Glegoo</option>
                <option value="Righteous" <?php if($font == 'Righteous') { echo ' selected="selected"'; } ?>>Righteous</option>
                <option value="Nobile" <?php if($font == 'Nobile') { echo ' selected="selected"'; } ?>>Nobile</option>
                <option value="Squada One" <?php if($font == 'Squada One') { echo ' selected="selected"'; } ?>>Squada One</option>
                <option value="Sanchez" <?php if($font == 'Sanchez') { echo ' selected="selected"'; } ?>>Sanchez</option>
                <option value="Playball" <?php if($font == 'Playball') { echo ' selected="selected"'; } ?>>Playball</option>
                <option value="Domine" <?php if($font == 'Domine') { echo ' selected="selected"'; } ?>>Domine</option>
                <option value="Fredoka One" <?php if($font == 'Fredoka One') { echo ' selected="selected"'; } ?>>Fredoka One</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-text-size"><span data-toggle="tooltip" data-placement="top" title="<?php echo $help_this_change; ?>"><?php echo $entry_font_size; ?></span></label>
            <div class="col-sm-10">
              <select name="font_size" id="input-layer-text-size" class="form-control">
                <option value="10" <?php if ($font_size == '10') { ?>selected="selected"<?php } ?> >10</option>
                <option value="11" <?php if ($font_size == '11') { ?>selected="selected"<?php } ?>>11</option>
                <option value="12" <?php if ($font_size == '12') { ?>selected="selected"<?php } ?>>12</option>
                <option value="13" <?php if ($font_size == '13') { ?>selected="selected"<?php } ?> >13</option>
                <option value="14" <?php if ($font_size == '14') { ?>selected="selected"<?php } ?>>14</option>
                <option value="15" <?php if ($font_size == '15') { ?>selected="selected"<?php } ?>>15</option>
                <option value="16" <?php if ($font_size == '16') { ?>selected="selected"<?php } ?> >13</option>
                <option value="17" <?php if ($font_size == '17') { ?>selected="selected"<?php } ?>>14</option>
                <option value="18" <?php if ($font_size == '18') { ?>selected="selected"<?php } ?>>15</option>
                <option value="19" <?php if ($font_size == '19') { ?>selected="selected"<?php } ?>>15</option>
                <option value="20" <?php if ($font_size == '20') { ?>selected="selected"<?php } ?> >13</option>
                <option value="21" <?php if ($font_size == '21') { ?>selected="selected"<?php } ?>>14</option>
                <option value="22" <?php if ($font_size == '22') { ?>selected="selected"<?php } ?>>15</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-autoplay"><span data-toggle="tooltip" data-placement="top" title="<?php echo $help_autoplay; ?>"><?php echo $entry_autoplay; ?></span></label>
            <div class="col-sm-10">
              <select name="autoplay" id="input-autoplay" class="form-control">
                <?php if ($autoplay) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-autoplay-delay"><span data-toggle="tooltip" data-placement="top" title="<?php echo $help_autoplay_delay; ?>"><?php echo $entry_autoplay_delay; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="autoplay_delay" value="<?php echo $autoplay_delay; ?>" placeholder="<?php echo $entry_autoplay_delay; ?>" id="input-autoplay-delay" class="form-control" />
              <?php if ($error_autoplay_delay) { ?>
              <div class="text-danger"><?php echo $error_autoplay_delay; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-autoplay-on-hover"><span data-toggle="tooltip" data-placement="top" title="<?php echo $help_autoplay_on_hover; ?>"><?php echo $entry_autoplay_on_hover; ?></span></label>
            <div class="col-sm-10">
              <select name="autoplay_on_hover" id="input-autoplay-on-hover" class="form-control">
                <option value="true" <?php if ($autoplay_on_hover == 'true') { ?>selected="selected"<?php } ?> >Yes</option>
                <option value="false" <?php if ($autoplay_on_hover == 'false') { ?>selected="selected"<?php } ?>>No</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-navigation"><span data-toggle="tooltip" data-placement="top" title="<?php echo $help_navigation; ?>"><?php echo $entry_navigation; ?></span></label>
            <div class="col-sm-10">
              <select name="navigation" id="input-navigation" class="form-control">
                <?php if ($navigation) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
  
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
            <div class="col-sm-10">
              <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
              <?php if ($error_width) { ?>
              <div class="text-danger"><?php echo $error_width; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
            <div class="col-sm-10">
              <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
              <?php if ($error_height) { ?>
              <div class="text-danger"><?php echo $error_height; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('input[name=\'testimonial\']').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/oca_testimonial_pro/autocomplete&token=<?php echo $token; ?>&filter_text=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['text'],
						value: item['testimonial_id']
					}
				}));
			}
		});
	},
	select: function(item) {
		$('input[name=\'testimonial\']').val('');
		
		$('#testimonial' + item['value']).remove();
		
		$('#testimonial').append('<div id="testimonial' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="testimonial[]" value="' + item['value'] + '" /></div>');	
	}
});
	
$('#testimonial').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script></div>
<?php echo $footer; ?>