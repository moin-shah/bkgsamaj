<?php $currentRoute = Yii::app()->controller->route; ?>
<header class="bkgs-header">
	<nav class="navbar navbar-expand-lg navbar-light container">
		<a class="navbar-brand d-flex align-items-center gap-2" href="/">
			<img src="/images/logo/bkgs-logo.png" alt="BKGS Logo" height="44">
			<span class="brand-text">Bhadar Kathiya Ghanchi Samaj</span>
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bkgsNav" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="bkgsNav">
			<ul class="navbar-nav gap-lg-2 align-items-lg-center">
				<li class="nav-item"><a class="nav-link <?php echo $currentRoute === 'site/index' ? 'active' : ''; ?>" href="/">Home</a></li>
				<li class="nav-item"><a class="nav-link <?php echo $currentRoute === 'site/about' ? 'active' : ''; ?>" href="/about">About Samaj</a></li>
				<li class="nav-item"><a class="nav-link <?php echo $currentRoute === 'site/districts' ? 'active' : ''; ?>" href="/districts">District List</a></li>
				<li class="nav-item"><a class="nav-link <?php echo $currentRoute === 'news/index' ? 'active' : ''; ?>" href="/news">News</a></li>
				<li class="nav-item"><a class="nav-link <?php echo $currentRoute === 'event/index' ? 'active' : ''; ?>" href="/events">Events</a></li>
				<li class="nav-item"><a class="nav-link <?php echo $currentRoute === 'site/contact' ? 'active' : ''; ?>" href="/contact">Contact Us</a></li>
				<li class="nav-item"><a class="btn btn-bkgs-primary btn-sm ms-lg-2" href="/admin/login">Admin Login</a></li>
			</ul>
		</div>
	</nav>
</header>
