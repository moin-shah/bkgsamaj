<footer class="bkgs-footer">
	<div class="container">
		<div class="row gy-4">
			<div class="col-md-6 col-lg-3">
				<div class="d-flex align-items-center gap-2 mb-2">
					<img src="/images/logo/bkgs-logo.png" alt="BKGS Logo" height="36">
					<span class="brand-text-footer">Bhadar Kathiya Ghanchi Samaj</span>
				</div>
				<p class="footer-tagline"><?php echo CHtml::encode(Setting::get('site_tagline', '')); ?></p>
			</div>
			<div class="col-md-6 col-lg-3">
				<h6 class="footer-heading">Quick Links</h6>
				<ul class="list-unstyled footer-links">
					<li><a href="/">Home</a></li>
					<li><a href="/about">About Samaj</a></li>
					<li><a href="/districts">District List</a></li>
					<li><a href="/contact">Contact Us</a></li>
				</ul>
			</div>
			<div class="col-md-6 col-lg-3">
				<h6 class="footer-heading">Community</h6>
				<ul class="list-unstyled footer-links">
					<li><a href="/news">News</a></li>
					<li><a href="/events">Events</a></li>
					<li><a href="/raja-chithi">Raja Chithi</a></li>
					<li><a href="/gallery">Gallery</a></li>
					<li><a href="/downloads">Downloads &amp; Rules</a></li>
				</ul>
			</div>
			<div class="col-md-6 col-lg-3">
				<h6 class="footer-heading">Admin</h6>
				<ul class="list-unstyled footer-links">
					<li><a href="/admin/login">Admin Login</a></li>
				</ul>
			</div>
		</div>
		<hr class="footer-divider">
		<p class="footer-copy mb-0"><?php echo CHtml::encode(Setting::get('footer_text', '')); ?></p>
	</div>
</footer>
