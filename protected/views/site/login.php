<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl.'/js/login.js?v=3.3'
);
?>


<div class="content">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'htmlOptions'=>array('class'=>'login-form'),
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>false,
		'validateOnType'=>false,
		'validateOnBlur'=>false,
	),
)); ?>
		<div class="logo">
		<img src="/../../../images/logo/bkgs-logo.png" alt="saasworthy" class="logo-default" />
		</div>
		<h3 class="form-title">Login to your account</h3>
		<div class="form-group">
		<div class="input-icon email-group">
		<i class="fa fa-envelope-o" aria-hidden="true"></i>
		<?php echo $form->textField($model,'username',array('class'=>'form-control placeholder-no-fix','placeholder'=>'Enter email')); ?>
		</div>
		<?php echo $form->error($model,'username'); ?>
		</div>
		
		<div class="form-group" style="display:none" id="password">
		<div class="input-icon">
		<i class="fa fa-lock" aria-hidden="true"></i>
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control placeholder-no-fix','placeholder'=>'Enter OTP','autocomplete'=>'one-time-code')); ?>
		</div>
		<?php echo $form->error($model,'password'); ?>
		<span style="display:none;" class="resend_otp_link">Did not receive your code? <a href="javascript:void(0)" class="resend_otp" onclick="setOtp('resend_otp');" >Resend OTP </a><img class="resend_loading" style="display:none;" src="<?php echo Yii::app()->baseUrl; ?>/images/loading.gif" alt="Loading..." /></span>	
		</div>
		
		<div class="form-actions" >
			<?php echo CHtml::Button('Get OTP',array('class'=>'btn green-haze pull-right','id'=>'otp','onClick'=>'setOtp();')); ?>
			<?php echo CHtml::submitButton('Login',array('class'=>'btn green-haze pull-right','style'=>'display:none','id'=>'login')); ?>			
		</div>
		
		<div class="powered-by">
			<p>Powered by BKGS</p>
		</div>
	
<?php $this->endWidget(); ?>
</div>