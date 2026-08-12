<section class="bkgs-section">
	<div class="container">
		<h1 class="bkgs-section-title text-center">Downloads</h1>
		<p class="bkgs-section-subtitle text-center">Rules &amp; Regulations, forms, circulars and other Samaj documents</p>

		<?php if (empty($downloads)): ?>
			<p class="text-muted text-center">No downloads are available yet.</p>
		<?php else: ?>
			<?php foreach ($categoryLabels as $categoryKey => $categoryLabel): ?>
				<?php $categoryDownloads = array_filter($downloads, function ($download) use ($categoryKey) {
					return $download->category === $categoryKey;
				}); ?>
				<?php if (empty($categoryDownloads)): continue; endif; ?>
				<div class="mb-5">
					<h4 class="mb-3"><?php echo CHtml::encode($categoryLabel); ?></h4>
					<div class="row g-4">
						<?php foreach ($categoryDownloads as $download): ?>
							<div class="col-md-6 col-lg-4">
								<div class="bkgs-card d-flex flex-column">
									<h6 class="mb-2"><?php echo CHtml::encode($download->title); ?></h6>
									<?php if ($download->district): ?>
										<p class="text-muted small mb-2">&#128205; <?php echo CHtml::encode($download->district->name); ?></p>
									<?php endif; ?>
									<a href="<?php echo CHtml::encode($download->file_url); ?>" class="btn btn-sm btn-bkgs-primary mt-auto" target="_blank" rel="noopener">Download</a>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
