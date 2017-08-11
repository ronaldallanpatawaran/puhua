<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="content">
	<div id="product_page_categories">
		<?php if($categories): ?>
			<?php foreach ($categories as $category) {
				$class = $category_id == $category['category_id'] ? "active" : "";
				echo "<a href='index.php?route=information/product&category_id=".$category['category_id']."'><label class='".$class."'>" . $category['name'] . "</label></a>&nbsp;&nbsp;";
			} ?>
		<?php endif; ?>
	</div><br><br>
	<div id="product_page_content" class="container">
		<div class="row">
			<div class="center-align col-md-6">
				<img class="image-responsive" src="<?php echo "image/".$active_category['image']; ?>">
			</div>
			<div id="right_column" class="col-md-6">
				<?php echo html_entity_decode($active_category['description']); ?>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?php echo $shop; ?>"><button id="btn_product_page">Shop Now</button></a>
					</div>
				</div>
			</div>
		</div>
		<div class="hr">&nbsp;</div>
		<div id="carousel_products" class="row">
			<?php if($products): ?>
				<?php foreach ($products as $product) {
					echo "<div class='center-align'><img class='image-responsive' src='".$product['thumb']."'><label class='title'>".$product['name']."</label><label class='description'>".htmlspecialchars_decode($product['description'])."</label></div>";
				} ?>

			<?php endif; ?>
		</div>
		<br>
		<div id="benefits_row" class="row">
			<div class="col-md-12">
				<label id="benefits_title">Benefits of Diatomaceous Earth</label>
			</div>
			<br><br><br>
			<div class="col-md-12">
				<div class="col-md-3 col-xs-6">
					<div class="col-xs-3">
						<img src="image/catalog/banners/about us/01_prevent-mould.png">
					</div>
					<div class="col-xs-9">						<?php echo $text_benefits_1; ?>
					</div>
				</div>
				<div class="col-md-3 col-xs-6">
					<div class="col-xs-3">
						<img src="image/catalog/banners/about us/02_nochemicals.png">
					</div>
					<div class="col-xs-9">						<?php echo $text_benefits_2; ?>
					</div>
				</div>
				<div class="col-md-3 col-xs-6">
					<div class="col-xs-3">
						<img src="image/catalog/banners/about us/03_releasenegativeions.png">
					</div>
					<div class="col-xs-9">						<?php echo $text_benefits_3; ?>
					</div>
				</div>
				<div class="col-md-3 col-xs-6">
					<div class="col-xs-3">
						<img src="image/catalog/banners/about us/04_flameresistant.png">
					</div>
					<div class="col-xs-9">						<?php echo $text_benefits_4; ?>
					</div>
				</div>
			</div>
			<br><br><br>
			<div class="col-md-12">
				<div class="col-md-3 col-xs-6">
					<div class="col-xs-3">
						<img src="image/catalog/banners/about us/05_antibacteria.png">
					</div>
					<div class="col-xs-9">						<?php echo $text_benefits_5; ?>
					</div>
				</div>
				<div class="col-md-3 col-xs-6">
					<div class="col-xs-3">
						<img src="image/catalog/banners/about us/06_eliminatessmoke.png">
					</div>
					<div class="col-xs-9">		
						<?php echo $text_benefits_6; ?>
					</div>
				</div>
				<div class="col-md-3 col-xs-6">
					<div class="col-xs-3">
						<img src="image/catalog/banners/about us/07_savesenergy.png">
					</div>
					<div class="col-xs-9">		
						<?php echo $text_benefits_7; ?>
					</div>
				</div>
				<div class="col-md-3 col-xs-6">
					<div class="col-xs-3">
						<img src="image/catalog/banners/about us/08_soundabsorption.png">
					</div>
					<div class="col-xs-9">						<?php echo $text_benefits_8; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>

<script type="text/javascript">
    $('#carousel_products').owlCarousel({
    items: 4,
    itemsTablet: [600,2],
    itemsTablet: [667,2],
    autoPlay: 3000,
    navigation: true,
    navigationText: ['<i class="left-arrow fa-5x"></i>', '<i class="right-arrow fa-5x"></i>'],
    pagination: true
  });

</script>