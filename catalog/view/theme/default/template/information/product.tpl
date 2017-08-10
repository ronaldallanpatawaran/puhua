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
		<div class="col-md-6">
			<img src="<?php echo "image/".$active_category['image']; ?>">
		</div>
		<div id="right_column" class="col-md-6">
			<?php echo html_entity_decode($active_category['description']); ?>
			<div class="row">
				<div class="col-sm-12">
					<a href="<?php echo $shop; ?>"><button id="btn_product_page">Shop Now</button></a>
				</div>
			</div>
		</div>
		<div class="hr">&nbsp;</div>
	</div>
</div>

<?php echo $footer; ?>