<section class="bkgs-section">
	<div class="container">
		<h1 class="bkgs-section-title text-center">News</h1>
		<p class="bkgs-section-subtitle text-center">Latest updates from our Samaj community</p>

		<?php if (empty($newsItems)): ?>
			<p class="text-muted text-center">No news articles have been published yet.</p>
		<?php else: ?>
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<?php foreach ($newsItems as $newsItem): ?>
						<div class="bkgs-card mb-4">
							<span class="text-muted small"><?php echo CHtml::encode(date('d M Y', strtotime($newsItem->published_at))); ?></span>
							<h4><a href="<?php echo Yii::app()->createUrl('/news/view', array('slug' => $newsItem->slug)); ?>"><?php echo CHtml::encode($newsItem->title); ?></a></h4>
							<p class="text-muted mb-2"><?php echo CHtml::encode($newsItem->excerpt); ?></p>
							<a href="<?php echo Yii::app()->createUrl('/news/view', array('slug' => $newsItem->slug)); ?>" class="btn btn-bkgs-primary btn-sm">Read More</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
