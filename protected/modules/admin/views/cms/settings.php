<div class="admin-card admin-card-narrow">
	<form method="post" action="<?php echo Yii::app()->createUrl('/admin/cms/settings'); ?>">
		<div class="mb-3">
			<label class="form-label">Site Name</label>
			<input type="text" class="form-control" name="Setting[site_name]" value="<?php echo CHtml::encode($siteName); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label">Tagline</label>
			<input type="text" class="form-control" name="Setting[site_tagline]" value="<?php echo CHtml::encode($siteTagline); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label">Footer Text</label>
			<input type="text" class="form-control" name="Setting[footer_text]" value="<?php echo CHtml::encode($footerText); ?>">
		</div>

		<div class="mb-3">
			<label class="form-label">Community Highlights</label>
			<?php foreach ($highlights as $i => $highlight): ?>
				<input type="text" class="form-control mb-2" name="highlight_items[]" value="<?php echo CHtml::encode($highlight); ?>">
			<?php endforeach; ?>
			<input type="text" class="form-control mb-2" name="highlight_items[]" placeholder="Add another highlight...">
			<div class="form-text">One highlight per line, e.g. "5000+ Members". Blank rows are ignored.</div>
		</div>
		<input type="hidden" name="Setting[community_highlights]" id="highlights-json" value="">

		<div class="d-flex gap-2 mt-4">
			<button type="submit" class="btn btn-bkgs-primary">Save Settings</button>
			<a href="<?php echo Yii::app()->createUrl('/admin/cms'); ?>" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>

<script>
document.querySelector('.admin-card form').addEventListener('submit', function () {
	var items = Array.prototype.slice.call(document.querySelectorAll('input[name="highlight_items[]"]'))
		.map(function (input) { return input.value.trim(); })
		.filter(function (value) { return value !== ''; });
	document.getElementById('highlights-json').value = JSON.stringify(items);
});
</script>
