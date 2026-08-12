<section class="bkgs-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<h1 class="bkgs-section-title"><?php echo CHtml::encode($news->title); ?></h1>
				<?php if ($news->published_at): ?>
					<p class="text-muted"><?php echo CHtml::encode(date('d M Y', strtotime($news->published_at))); ?></p>
				<?php endif; ?>

				<div class="bkgs-card">
					<?php echo $news->content; ?>
				</div>

				<p class="mt-4"><a href="<?php echo Yii::app()->createUrl('/news'); ?>">&larr; Back to News</a></p>
			</div>
		</div>
	</div>
</section>
