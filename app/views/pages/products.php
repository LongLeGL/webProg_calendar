<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-3">
				<div class="intro-excerpt">
					<h1>Products</h1>
					<p>
						<input class="form-control me-2" type="search" name="search" id="search" placeholder="Search products" aria-label="Search">
						<ul class="list-group" id="result" name="result"></ul>
					</p>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="hero-img-wrap">
					<img src="./public/images/couch.png" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section product-section before-footer-section">
	<div class="container">
		<div class="row" id="productList" name="productList">
			<?php foreach ($data['products'] as $product) : ?>
				<div class="col-12 col-md-4 col-lg-3 mb-5">
					<a class="product-item" href="#" id="<?php echo $product['id'] ?>">
						<img src="<?php echo $product['imageUrl'] ?>" class="img-fluid product-thumbnail" width="250">
						<h3 class="product-title">	<?php echo $product['name'] ?>	</h3>
						<strong class="product-price">$<?php echo $product['price'] ?></strong>

						<span class="icon-cross"> <img src="./public/images/cross.svg" class="img-fluid"> </span>
					</a>
				</div> 
			<?php endforeach; ?>
		</div>
		<div class="d-flex justify-content-evenly">
			<div class="spinner-grow text-success" role="status"></div>
			<div class="spinner-grow text-success" role="status"></div>
			<div class="spinner-grow text-success" role="status"></div>
			<div class="spinner-grow text-success" role="status"></div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		windowOnScroll();
		liveSearch();
	});

	function liveSearch(){
		$("#search").keyup(function() {
			var searchString = $('#search').val();
			if (searchString == "") {
				$("#result").html("");
			}
			else {
				$.ajax({
					type: "POST",
					url: "index.php?page=products/search",
					data: {search: searchString},
					success: function(html) {
						$("#result").html(html).show();
					}
				});
			}
		});
	}

	function windowOnScroll() {
		$(window).on("scroll", function(e){
			if ($('#productList').offset().top + $('#productList').height() - $(window).scrollTop() - $(window).height() < 0) {
				if($(".product-item").length < <?php echo $data['totalProductsCount'] ?>) {
					var lastId = $(".product-item:last").attr("id");
					getMoreData(lastId);
				}
			}
		});
	}

	function getMoreData(lastId) {
		$(window).off("scroll");
		$.ajax({
			url: 'index.php?page=products/lazyLoad/' + lastId,
			type: "GET",
			beforeSend: function(){
				$('.spinner-grow').show();
			},
			success: function(data){
				setTimeout(function() {
					$('.spinner-grow').hide();
					$("#productList").append(data);
					windowOnScroll();
				}, 1000);
			}
		});
	}
</script>