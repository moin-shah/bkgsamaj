function setOtp(send_type){
    const num = $('#LoginForm_username').val();
    const emailID = num.trim().toLowerCase();
	
	if (num === '') {
        $("#LoginForm_username_em_").show().text('Please enter your email!');
        return false;
    }

    if (!isValidEmailAddress(num)) {
        $("#LoginForm_username_em_").show().text('Enter valid email!');
        return false;
    }

	$.ajax
	({
		url: 'index.php?r=site/loginOtp',
		data: {"username":emailID},
		type: 'POST',
		beforeSend: function() {
            if(send_type != 'resend_otp') {
                $("#otp").prop('disabled', true);
                $("#otp").val('Sending....');
            } else {
                $(".resend_loading").show();
                $(".resend_otp").css('pointer-events', 'none').off('click');
            }
        },
		success:function(data){
            if(data=='200' || data==200){
				$('#LoginForm_username').prop('readonly', true);
				$('.email-group, #LoginForm_username').addClass('disabled');
				$("#LoginForm_username_em_").hide();
				$("#LoginForm_username_em_").text('');
				$("#error_mob").hide();
				$("#error_mob").text('');
				$("#password").show();
				$("#otp").hide();
				$("#login").show();
				if(send_type != 'resend_otp') {
					startTimer();
				} else {
					$(".resend_loading").hide();
					startTimer();
				}
            }
		},
		statusCode: {
		401: function(xhr) {
			$("#LoginForm_username_em_").show();
			$("#LoginForm_username_em_").text('Email does not exist!');
			$("#otp").prop('disabled', false);
            $("#otp").val('Get OTP');
			return false;
		},
		404: function(xhr) {
			
			
		},
		},
		error: function() {
			if(send_type == 'resend_otp') {
				$(".resend_loading").hide();
				$(".resend_otp").css('pointer-events', 'auto');
			} else {
				$("#otp").prop('disabled', false);
				$("#otp").val('Get OTP');
			}
		}
	})
}

function startTimer() {
	var timer = 45;
	var interval = setInterval(function() {
		var minutes = Math.floor(timer / 60);
		var seconds = timer % 60;
		minutes = minutes < 10 ? '0' + minutes : minutes;
		seconds = seconds < 10 ? '0' + seconds : seconds;
		$(".resend_otp_link").show();
		if (timer > 0) {
			$('.resend_otp').text(minutes + ':' + seconds).prop('disabled', true).css('pointer-events', 'none');
			timer--;
		} else {
			clearInterval(interval);
			$('.resend_otp_link').html('Did not receive your code? <a href="javascript:void(0)" class="resend_otp" onclick="setOtp(\'resend_otp\');" style="pointer-events: auto;">Resend OTP </a><img class="resend_loading" style="display:none;" src="/images/loading.gif" alt="Loading...">');
		}
	}, 1000);
}

$(document).bind('keypress', function(e) {
	if(e.keyCode==13){
		if ($('#otp').is(":visible")){
			$('#otp').trigger('click');
			return false;
		}
		if ($('#login').is(":visible")){
			$('#login').trigger('click');
			return false;
		}
	}
});

$("#LoginForm_username").on('change',function() {
	$("#error_mob").hide();
	$("#LoginForm_username_em_").hide();
});

$("#LoginForm_password").on('change',function() {
	$("#LoginForm_password_em_").hide();
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};

$(document).ready(function () {
    const otpVal = $("#LoginForm_password").val();

    if (otpVal && otpVal.trim() !== '') {
        $("#password").show();
        $("#otp").hide();
        $("#login").show();
        $(".resend_otp_link").show();
    }
});
