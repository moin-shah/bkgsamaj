<section class="bkgs-section">
	<div class="container">
		<h1 class="bkgs-section-title text-center">Events</h1>
		<p class="bkgs-section-subtitle text-center">Gatherings and programs across our Samaj community</p>

		<h2 class="bkgs-section-title">Upcoming</h2>
		<?php if (empty($upcomingEvents)): ?>
			<p class="text-muted">No upcoming events at the moment.</p>
		<?php else: ?>
			<div class="row g-4 mb-5">
				<?php foreach ($upcomingEvents as $event): ?>
					<div class="col-md-6 col-lg-4">
						<div class="bkgs-card">
							<span class="badge bkgs-badge-event mb-2"><?php echo CHtml::encode(date('d M Y', strtotime($event->start_at))); ?></span>
							<h5><a href="<?php echo Yii::app()->createUrl('/event/view', array('slug' => $event->slug)); ?>"><?php echo CHtml::encode($event->title); ?></a></h5>
							<p class="text-muted small mb-0">&#128205; <?php echo CHtml::encode($event->venue ?: ($event->district ? $event->district->name : 'Samaj-wide')); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<h2 class="bkgs-section-title">Past Events</h2>
		<?php if (empty($pastEvents)): ?>
			<p class="text-muted">No past events to show.</p>
		<?php else: ?>
			<div class="row g-4">
				<?php foreach ($pastEvents as $event): ?>
					<div class="col-md-6 col-lg-4">
						<div class="bkgs-card">
							<span class="badge bg-secondary mb-2"><?php echo CHtml::encode(date('d M Y', strtotime($event->start_at))); ?></span>
							<h5><a href="<?php echo Yii::app()->createUrl('/event/view', array('slug' => $event->slug)); ?>"><?php echo CHtml::encode($event->title); ?></a></h5>
							<p class="text-muted small mb-0">&#128205; <?php echo CHtml::encode($event->venue ?: ($event->district ? $event->district->name : 'Samaj-wide')); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
