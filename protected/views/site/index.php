<?php
$homeMeta = $home ? $home->getMeta() : array();
$contactMeta = $contact ? $contact->getMeta() : array();
?>

<!-- Hero Banner -->
<section class="bkgs-hero">
	<div class="container text-center">
		<h1><?php echo CHtml::encode($home ? $home->title : $this->getSiteName()); ?></h1>
		<?php if (!empty($homeMeta['subtitle'])): ?>
			<p class="lead"><?php echo CHtml::encode($homeMeta['subtitle']); ?></p>
		<?php endif; ?>
		<?php if ($home && $home->content): ?>
			<p class="lead"><?php echo CHtml::encode($home->content); ?></p>
		<?php endif; ?>
		<?php if (!empty($homeMeta['button_text']) && !empty($homeMeta['button_link'])): ?>
			<a class="btn btn-lg btn-bkgs-outline mt-3" href="<?php echo CHtml::encode($homeMeta['button_link']); ?>">
				<?php echo CHtml::encode($homeMeta['button_text']); ?>
			</a>
		<?php endif; ?>
	</div>
</section>

<!-- About Community -->
<section class="bkgs-section">
	<div class="container">
		<div class="row align-items-center g-5">
			<div class="col-lg-6">
				<h2 class="bkgs-section-title">About Our Community</h2>
				<div class="bkgs-section-subtitle">
					<?php echo $about ? $about->content : ''; ?>
				</div>
				<a href="/about" class="btn btn-bkgs-primary">Read More</a>
			</div>
			<div class="col-lg-6">
				<div class="row g-4">
					<?php foreach ($highlights as $highlight): ?>
						<div class="col-6">
							<div class="bkgs-card text-center">
								<div class="bkgs-highlight-stat"><?php echo CHtml::encode(preg_replace('/[^0-9+]/', '', $highlight) ?: '✓'); ?></div>
								<div class="bkgs-highlight-label"><?php echo CHtml::encode(preg_replace('/^[0-9+]+\s*/', '', $highlight)); ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- District Cards -->
<section class="bkgs-section bkgs-section-alt">
	<div class="container">
		<h2 class="bkgs-section-title text-center">Our Districts</h2>
		<p class="bkgs-section-subtitle text-center">Connecting our community across districts</p>
		<div class="row g-4">
			<?php foreach ($districts as $district): ?>
				<div class="col-md-6 col-lg-3">
					<div class="bkgs-card">
						<div class="bkgs-card-icon">&#128205;</div>
						<h5><?php echo CHtml::encode($district->name); ?></h5>
						<p class="text-muted small mb-0"><?php echo CHtml::encode($district->description); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="text-center mt-4">
			<a href="/districts" class="btn btn-bkgs-primary">View All Districts</a>
		</div>
	</div>
</section>

<!-- Latest News & Upcoming Event -->
<section class="bkgs-section">
	<div class="container">
		<div class="row g-5">
			<div class="col-lg-7">
				<h2 class="bkgs-section-title">Latest News</h2>
				<?php if (empty($news)): ?>
					<p class="text-muted">No news posted yet.</p>
				<?php else: ?>
					<ul class="list-group list-group-flush">
						<?php foreach ($news as $item): ?>
							<li class="list-group-item bg-transparent px-0 d-flex justify-content-between align-items-start">
								<a href="/news/<?php echo CHtml::encode($item->slug); ?>"><?php echo CHtml::encode($item->title); ?></a>
								<span class="text-muted small text-nowrap ms-3"><?php echo CHtml::encode(date('M Y', strtotime($item->published_at))); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
					<a href="/news" class="d-inline-block mt-3">All News &rarr;</a>
				<?php endif; ?>
			</div>
			<div class="col-lg-5">
				<h2 class="bkgs-section-title">Upcoming Event</h2>
				<?php if ($upcomingEvent === null): ?>
					<p class="text-muted">No upcoming events scheduled.</p>
				<?php else: ?>
					<div class="bkgs-card">
						<span class="badge bkgs-badge-event mb-2"><?php echo CHtml::encode(date('d M Y', strtotime($upcomingEvent->start_at))); ?></span>
						<h5><a href="/events/<?php echo CHtml::encode($upcomingEvent->slug); ?>"><?php echo CHtml::encode($upcomingEvent->title); ?></a></h5>
						<p class="text-muted mb-0">&#128205; <?php echo CHtml::encode($upcomingEvent->venue ?: ($upcomingEvent->district ? $upcomingEvent->district->name : 'Samaj-wide')); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<!-- Contact Section -->
<section class="bkgs-section bkgs-section-alt">
	<div class="container">
		<h2 class="bkgs-section-title text-center">Get In Touch</h2>
		<div class="row g-4 justify-content-center text-center">
			<?php if (!empty($contactMeta['address'])): ?>
				<div class="col-md-4">
					<div class="bkgs-card">
						<div class="bkgs-card-icon mx-auto">&#127968;</div>
						<h6>Address</h6>
						<p class="text-muted small mb-0"><?php echo CHtml::encode($contactMeta['address']); ?></p>
					</div>
				</div>
			<?php endif; ?>
			<?php if (!empty($contactMeta['phone'])): ?>
				<div class="col-md-4">
					<div class="bkgs-card">
						<div class="bkgs-card-icon mx-auto">&#128222;</div>
						<h6>Phone</h6>
						<p class="text-muted small mb-0"><a href="tel:<?php echo CHtml::encode($contactMeta['phone']); ?>"><?php echo CHtml::encode($contactMeta['phone']); ?></a></p>
					</div>
				</div>
			<?php endif; ?>
			<?php if (!empty($contactMeta['email'])): ?>
				<div class="col-md-4">
					<div class="bkgs-card">
						<div class="bkgs-card-icon mx-auto">&#9993;</div>
						<h6>Email</h6>
						<p class="text-muted small mb-0"><a href="mailto:<?php echo CHtml::encode($contactMeta['email']); ?>"><?php echo CHtml::encode($contactMeta['email']); ?></a></p>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="text-center mt-4">
			<a href="/contact" class="btn btn-bkgs-primary">Contact Us</a>
		</div>
	</div>
</section>
