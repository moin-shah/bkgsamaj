<?php
/* @var $this CustomerLeadController */
/* @var $model CustomerLead */

$this->breadcrumbs=array(
	'Customer Leads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Customer Lead', 'url'=>array('index')),
	array('label'=>'Manage Customer Lead', 'url'=>array('admin')),
);
?>

<!--<h1>Create Customer Lead</h1>-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>