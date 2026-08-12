<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo Yii::app()->createUrl('/admin/cms/edit', array('slug' => $model->slug)); ?>">
		<?php echo CHtml::errorSummary($model); ?>

		<div class="mb-3">
			<label class="form-label">Title</label>
			<?php echo CHtml::activeTextField($model, 'title', array('class' => 'form-control')); ?>
		</div>

		<div class="mb-3">
			<label class="form-label"><?php echo $model->slug === 'about_samaj' ? 'Content' : 'Intro Text'; ?></label>
			<?php echo CHtml::activeTextArea($model, 'content', array('class' => 'form-control', 'rows' => 8)); ?>
		</div>

		<?php if ($model->slug === 'home_banner'): ?>
			<hr class="my-4">
			<h6 class="mb-3">Hero Banner Fields</h6>
			<div class="mb-3">
				<label class="form-label">Subtitle</label>
				<input type="text" class="form-control" name="meta[subtitle]" value="<?php echo CHtml::encode(isset($meta['subtitle']) ? $meta['subtitle'] : ''); ?>">
			</div>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label">Button Text</label>
					<input type="text" class="form-control" name="meta[button_text]" value="<?php echo CHtml::encode(isset($meta['button_text']) ? $meta['button_text'] : ''); ?>">
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label">Button Link</label>
					<input type="text" class="form-control" name="meta[button_link]" value="<?php echo CHtml::encode(isset($meta['button_link']) ? $meta['button_link'] : ''); ?>">
				</div>
			</div>
			<div class="mb-3">
				<label class="form-label">Banner Image URL</label>
				<input type="text" class="form-control" name="meta[image_url]" value="<?php echo CHtml::encode(isset($meta['image_url']) ? $meta['image_url'] : ''); ?>">
			</div>
		<?php elseif ($model->slug === 'contact_info'): ?>
			<hr class="my-4">
			<h6 class="mb-3">Contact Details</h6>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label">Phone</label>
					<input type="text" class="form-control" name="meta[phone]" value="<?php echo CHtml::encode(isset($meta['phone']) ? $meta['phone'] : ''); ?>">
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label">Email</label>
					<input type="email" class="form-control" name="meta[email]" value="<?php echo CHtml::encode(isset($meta['email']) ? $meta['email'] : ''); ?>">
				</div>
			</div>
			<div class="mb-3">
				<label class="form-label">Address</label>
				<input type="text" class="form-control" name="meta[address]" value="<?php echo CHtml::encode(isset($meta['address']) ? $meta['address'] : ''); ?>">
			</div>
			<div class="mb-3">
				<label class="form-label">Office Hours</label>
				<input type="text" class="form-control" name="meta[office_hours]" value="<?php echo CHtml::encode(isset($meta['office_hours']) ? $meta['office_hours'] : ''); ?>">
			</div>
		<?php endif; ?>

		<div class="d-flex gap-2 mt-4">
			<button type="submit" class="btn btn-bkgs-primary">Save Changes</button>
			<a href="<?php echo Yii::app()->createUrl('/admin/cms'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>
