<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="icon" href="/images/logo/favicon.ico">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/public.css">
</head>
<body>

<?php echo $this->renderPartial('//layouts/_public_header', array(), true); ?>

<main>
	<?php echo $content; ?>
</main>

<?php echo $this->renderPartial('//layouts/_public_footer', array(), true); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
