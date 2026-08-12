<section class="bkgs-section">
	<div class="container">
		<h1 class="bkgs-section-title text-center">Raja Chithi</h1>
		<p class="bkgs-section-subtitle text-center">Formal circulars and notices issued by the Samaj</p>

		<?php if (empty($rajaChithis)): ?>
			<p class="text-muted text-center">No Raja Chithi has been published yet.</p>
		<?php else: ?>
			<div class="row g-4">
				<?php foreach ($rajaChithis as $rajaChithi): ?>
					<div class="col-12">
						<div class="bkgs-card">
							<div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
								<h5 class="mb-0"><?php echo CHtml::encode($rajaChithi->title); ?></h5>
								<span class="text-muted small text-nowrap"><?php echo CHtml::encode(date('d M Y', strtotime($rajaChithi->issued_date))); ?></span>
							</div>
							<p class="text-muted small mb-2">&#128205; <?php echo $rajaChithi->district ? CHtml::encode($rajaChithi->district->name) : 'Samaj-wide'; ?></p>
							<?php if ($rajaChithi->description): ?>
								<p class="mb-2"><?php echo CHtml::encode($rajaChithi->description); ?></p>
							<?php endif; ?>
							<?php if ($rajaChithi->attachment_url): ?>
								<a href="<?php echo CHtml::encode($rajaChithi->attachment_url); ?>" class="btn btn-sm btn-bkgs-primary" target="_blank" rel="noopener">View Attachment</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
