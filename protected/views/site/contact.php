<?php $contactMeta = $contact ? $contact->getMeta() : array(); ?>

<section class="bkgs-section">
	<div class="container">
		<h1 class="bkgs-section-title text-center"><?php echo CHtml::encode($contact ? $contact->title : 'Contact Us'); ?></h1>

		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="bkgs-card mb-4">
					<?php echo $contact ? $contact->content : ''; ?>
				</div>

				<div class="row g-4 text-center">
					<?php if (!empty($contactMeta['address'])): ?>
						<div class="col-md-6">
							<div class="bkgs-card h-100">
								<div class="bkgs-card-icon mx-auto">&#127968;</div>
								<h6>Address</h6>
								<p class="text-muted small mb-0"><?php echo CHtml::encode($contactMeta['address']); ?></p>
							</div>
						</div>
					<?php endif; ?>
					<?php if (!empty($contactMeta['phone'])): ?>
						<div class="col-md-6">
							<div class="bkgs-card h-100">
								<div class="bkgs-card-icon mx-auto">&#128222;</div>
								<h6>Phone</h6>
								<p class="text-muted small mb-0"><a href="tel:<?php echo CHtml::encode($contactMeta['phone']); ?>"><?php echo CHtml::encode($contactMeta['phone']); ?></a></p>
							</div>
						</div>
					<?php endif; ?>
					<?php if (!empty($contactMeta['email'])): ?>
						<div class="col-md-6">
							<div class="bkgs-card h-100">
								<div class="bkgs-card-icon mx-auto">&#9993;</div>
								<h6>Email</h6>
								<p class="text-muted small mb-0"><a href="mailto:<?php echo CHtml::encode($contactMeta['email']); ?>"><?php echo CHtml::encode($contactMeta['email']); ?></a></p>
							</div>
						</div>
					<?php endif; ?>
					<?php if (!empty($contactMeta['office_hours'])): ?>
						<div class="col-md-6">
							<div class="bkgs-card h-100">
								<div class="bkgs-card-icon mx-auto">&#128337;</div>
								<h6>Office Hours</h6>
								<p class="text-muted small mb-0"><?php echo CHtml::encode($contactMeta['office_hours']); ?></p>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
