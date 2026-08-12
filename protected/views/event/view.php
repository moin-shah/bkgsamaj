<section class="bkgs-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<h1 class="bkgs-section-title"><?php echo CHtml::encode($event->title); ?></h1>

				<?php if ($event->banner_url): ?>
					<img src="<?php echo CHtml::encode($event->banner_url); ?>" alt="<?php echo CHtml::encode($event->title); ?>" class="img-fluid rounded mb-4">
				<?php endif; ?>

				<div class="bkgs-card mb-4">
					<div class="row g-3">
						<div class="col-md-6">
							<h6 class="mb-1">District</h6>
							<p class="text-muted mb-0"><?php echo $event->district ? CHtml::encode($event->district->name) : 'Samaj-wide'; ?></p>
						</div>
						<div class="col-md-6">
							<h6 class="mb-1">Venue</h6>
							<p class="text-muted mb-0"><?php echo CHtml::encode($event->venue ?: 'To be announced'); ?></p>
						</div>
						<div class="col-md-6">
							<h6 class="mb-1">Starts</h6>
							<p class="text-muted mb-0"><?php echo CHtml::encode(date('d M Y, h:i A', strtotime($event->start_at))); ?></p>
						</div>
						<?php if ($event->end_at): ?>
							<div class="col-md-6">
								<h6 class="mb-1">Ends</h6>
								<p class="text-muted mb-0"><?php echo CHtml::encode(date('d M Y, h:i A', strtotime($event->end_at))); ?></p>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="bkgs-card">
					<?php echo nl2br(CHtml::encode($event->description)); ?>
				</div>

				<p class="mt-4"><a href="<?php echo Yii::app()->createUrl('/event'); ?>">&larr; Back to Events</a></p>
			</div>
		</div>
	</div>
</section>
