<?php

class DefaultController extends AdminController
{
	const OTP_SESSION_KEY = 'admin_otp_user_id';

	public function actionLogin()
	{
		if (!Yii::app()->user->isGuest) {
			$this->redirect(array('/admin/dashboard'));
		}

		$this->render('login', array(
			'pendingUser' => $this->getPendingUser(),
		));
	}

	/**
	 * AJAX endpoint for the "Send OTP" button. Always returns JSON.
	 */
	public function actionRequestOtp()
	{
		$email = isset($_POST['email']) ? trim($_POST['email']) : '';
		$result = $this->requestOtp($email);

		header('Content-Type: application/json');
		echo json_encode($result);
		Yii::app()->end();
	}

	public function actionVerifyOtp()
	{
		$user = $this->getPendingUser();

		if ($user === null) {
			Yii::app()->user->setFlash('otp_error', 'Your OTP request expired. Please enter your email again.');
			$this->redirect(array('/admin/default/login'));
		}

		$otp = isset($_POST['otp']) ? trim($_POST['otp']) : '';

		if ($otp !== '' && $user->verifyOtp($otp)) {
			Yii::app()->session->remove(self::OTP_SESSION_KEY);

			$identity = new AdminUserIdentity($user);
			$identity->authenticate();
			Yii::app()->user->login($identity, 86400);

			$this->redirect(array('/admin/dashboard'));
		}

		Yii::app()->user->setFlash('otp_error', 'That OTP is incorrect or has expired.');
		$this->render('login', array('pendingUser' => $user));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		Yii::app()->session->remove(self::OTP_SESSION_KEY);
		$this->redirect(array('/admin/default/login'));
	}

	/**
	 * @return array{success: bool, message: string}
	 */
	private function requestOtp($email)
	{
		if ($email === '') {
			return array('success' => false, 'message' => 'Please enter your email address.');
		}

		$user = User::findByEmail($email);

		if ($user === null || !$user->isActive()) {
			return array('success' => false, 'message' => 'No active admin account was found with that email.');
		}

		Yii::app()->session->add(self::OTP_SESSION_KEY, $user->id);

		if (!$user->canRequestOtp()) {
			return array('success' => false, 'message' => 'Please wait ' . $user->otpResendWaitSeconds() . ' seconds before requesting another OTP.');
		}

		$otp = $user->generateOtp();
		$this->sendOtpEmail($user, $otp);

		return array('success' => true, 'message' => 'An OTP has been sent to ' . $user->email . '.');
	}

	private function sendOtpEmail(User $user, $otp)
	{
		$mail = new YiiMailer();
		$mail->isSMTP(true);
		$mail->Host = Yii::app()->params['host_plain'];
		$mail->Username = Yii::app()->params['host_username'];
		$mail->Password = Yii::app()->params['host_password'];
		$mail->Port = Yii::app()->params['host_port'];
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->From = 'team@softwaresuggest.com';
		$mail->FromName = 'BKGS Portal';
		$mail->AddAddress($user->email);
		$mail->IsHTML(true);
		$mail->Subject = 'Your BKGS Admin Login OTP';
		$mail->Body = '<p>Hi ' . CHtml::encode($user->name) . ',</p>'
			. '<p>Your BKGS Admin Portal login OTP is <b>' . CHtml::encode($otp) . '</b>.</p>'
			. '<p>This code expires in 10 minutes. If you did not request this, you can ignore this email.</p>';

		try
		{
			//$mail->Send();
			return true;
		} 
		catch (Exception $e) 
		{
			Yii::log('Failed to send admin OTP email: ' . $e->getMessage(), CLogger::LEVEL_ERROR);
		}
	}

	private function getPendingUser()
	{
		$userId = Yii::app()->session->itemAt(self::OTP_SESSION_KEY);

		return $userId ? User::model()->findByPk($userId) : null;
	}
}
