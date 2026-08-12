<?php
$this->layout = false;
$this->pageTitle = 'Admin Login - BKGS Portal';
$requestOtpUrl = $this->createUrl('/admin/default/requestOtp');
$verifyOtpUrl = $this->createUrl('/admin/default/verifyOtp');
$pendingEmail = $pendingUser ? $pendingUser->email : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="icon" href="/images/logo/favicon.ico">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/admin.css">
</head>
<body class="admin-auth-body">
	<div class="admin-auth-wrapper">
		<div class="admin-auth-card">
			<div class="text-center mb-4">
				<img src="/images/logo/bkgs-logo.png" alt="BKGS Logo" height="56">
				<h4 class="mt-3 mb-0">BKGS Admin Portal</h4>
				<p class="text-muted small">Sign in with a one-time code sent to your email</p>
			</div>

			<?php if (Yii::app()->user->hasFlash('otp_error')): ?>
				<div class="alert alert-danger"><?php echo Yii::app()->user->getFlash('otp_error'); ?></div>
			<?php endif; ?>

			<div id="request-status" class="alert d-none"></div>

			<!-- Step 1: email -->
			<div id="email-step" class="<?php echo $pendingEmail ? 'd-none' : ''; ?>">
				<div class="mb-3">
					<label class="form-label" for="email">Email Address</label>
					<input type="email" class="form-control" id="email" required autofocus placeholder="you@bkgsamaj.org" value="<?php echo CHtml::encode($pendingEmail); ?>">
				</div>
				<button type="button" id="send-otp-btn" class="btn btn-bkgs-primary w-100">Send OTP</button>
			</div>

			<!-- Step 2: otp -->
			<div id="otp-step" class="<?php echo $pendingEmail ? '' : 'd-none'; ?>">
				<p class="text-muted small mb-3" id="otp-sent-to-text">
					Enter the 6-digit code sent to <strong id="otp-sent-to-email"><?php echo CHtml::encode($pendingEmail); ?></strong>
				</p>
				<form method="post" action="<?php echo $verifyOtpUrl; ?>" id="otp-form">
					<div class="mb-3">
						<label class="form-label" for="otp">One-Time Code</label>
						<input type="text" class="form-control text-center" id="otp" name="otp" maxlength="6" pattern="[0-9]{6}" placeholder="••••••">
					</div>
					<button type="submit" class="btn btn-bkgs-primary w-100">Verify &amp; Sign In</button>
				</form>
				<div class="text-center mt-3">
					<button type="button" id="resend-otp-btn" class="btn btn-link btn-sm p-0">Resend OTP</button>
					<span class="text-muted mx-1">&middot;</span>
					<button type="button" id="change-email-btn" class="btn btn-link btn-sm p-0">Change email</button>
				</div>
			</div>

			<div class="text-center mt-4">
				<a href="/" class="small text-muted">&larr; Back to website</a>
			</div>
		</div>
	</div>

	<script>
	(function () {
		var emailStep = document.getElementById('email-step');
		var otpStep = document.getElementById('otp-step');
		var sendBtn = document.getElementById('send-otp-btn');
		var resendBtn = document.getElementById('resend-otp-btn');
		var changeEmailBtn = document.getElementById('change-email-btn');
		var emailInput = document.getElementById('email');
		var statusBox = document.getElementById('request-status');
		var otpSentToEmail = document.getElementById('otp-sent-to-email');
		var currentEmail = emailInput.value.trim();

		function showStatus(message, isError) {
			statusBox.textContent = message;
			statusBox.classList.remove('d-none', 'alert-success', 'alert-danger');
			statusBox.classList.add(isError ? 'alert-danger' : 'alert-success');
		}

		function requestOtp(email, btn) {
			var originalText = btn.textContent;
			btn.disabled = true;
			btn.textContent = 'Sending...';

			var xhr = new XMLHttpRequest();
			xhr.open('POST', '<?php echo $requestOtpUrl; ?>', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				btn.disabled = false;
				btn.textContent = originalText;
				var data = {};
				try { data = JSON.parse(xhr.responseText); } catch (e) {}

				if (data.success) {
					currentEmail = email;
					otpSentToEmail.textContent = email;
					emailStep.classList.add('d-none');
					otpStep.classList.remove('d-none');
					document.getElementById('otp').focus();
				}
				showStatus(data.message || 'Something went wrong. Please try again.', !data.success);
			};
			xhr.onerror = function () {
				btn.disabled = false;
				btn.textContent = originalText;
				showStatus('Could not reach the server. Please try again.', true);
			};
			xhr.send('email=' + encodeURIComponent(email));
		}

		sendBtn.addEventListener('click', function () {
			var email = emailInput.value.trim();
			if (!email) {
				showStatus('Please enter your email address.', true);
				return;
			}
			requestOtp(email, sendBtn);
		});

		resendBtn.addEventListener('click', function () {
			requestOtp(currentEmail, resendBtn);
		});

		changeEmailBtn.addEventListener('click', function () {
			otpStep.classList.add('d-none');
			emailStep.classList.remove('d-none');
			statusBox.classList.add('d-none');
			emailInput.focus();
		});
	})();
	</script>
</body>
</html>
