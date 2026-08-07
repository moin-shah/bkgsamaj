<div class="page-content-inner lead-page invite-user-page">
	<div class="section">
		<div class="row">
			<div class="col-md-12">
				<div class="page-head invite-user-title margin-bottom-30">
					<h2 class="page-title">Invite Users</h2>
                    <div class="alert" role="alert" id="formSuccess" style="display:none;"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form id="invite-user"> 
					<div class="invite-user-wrapper">
						<label for="userEamail">Email:</label>
                        <div class="input_group">
                            <input type="email" name="email" id="userEamail" placeholder="jonathan@example.com">
                            <div id="emailError" class="field-error"></div>
                        </div>
						<label for="userName">Name:</label>
                        <div class="input_group">
                            <input type="text" name="username" id="userName" placeholder="Jonathan Williams">
                            <div id="nameError" class="field-error"></div>
                        </div>
						<button id="inviteUserSubmit" type="submit" class="btn btn-primary">Invite</button>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php $this->widget("zii.widgets.grid.CGridView", [
					"id" => "user-list-grid",
					"dataProvider" => $model,
					"rowCssClassExpression" => "",
					"filter" => null,
					"summaryText" => "",
					"afterAjaxUpdate" => "function(){ updateCount(); }",
					"itemsCssClass" => "table table-bordered table-striped table-condensed flip-content",
					"pager" => ["cssFile" => false, "htmlOptions" => ["style" => "display:none"], "header" => ""],
					"columns" => [
						["name" => "email","header" => "Email"],
						[
							"name" => "username",
							"header" => "Name",
							"value" => function($data) {
								return ucfirst($data["username"]);
							},
						],
						[
							'header'=>'Delete User',
							'name'=>'',
							'headerHtmlOptions' => ['style' => 'text-align:center'], 
							'htmlOptions'=> ['align'=>'center'],
							'value'=> function($data) {
								echo '<button class="user-delete-btn" data-popup-ordinal="0" onclick="deleteUserModal('.$data["id"].')" data-toggle="modal" data-target="#deleteuser" type="button"><img src="'.Yii::app()->baseUrl.'/images/iu_delete_i.svg" alt="lead view"></button>';
							},
						],
					],
				]); ?>
			</div>
		</div>

	</div>
</div>
<!-- Delete User Modal -->
<div class="modal fade" id="deleteuser" tabindex="-1" role="dialog" aria-labelledby="deleteusertitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteusertitle">Are you sure you want to delete this user?</h5>
				<button type="button" data-dismiss="modal" class="custom-close-v" aria-label="Close">
					<img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_close_i.svg">
				</button>
			</div>
			<div class="modal-footer">
				<input type="hidden" id="deletedUserId">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-primary" id="confirmdeleteuser">Yes</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function showAlert(message, type) {
		var $alert = $('#formSuccess');
		$alert.removeClass('alert-success alert-danger').addClass('alert-' + type);
		$alert.text(message).show();
		setTimeout(function() {
			$alert.hide();
		}, 3000);
	}
	
	$(function(){
		$('#invite-user').on('submit', function(e){
			e.preventDefault();
			const email = $.trim($('#userEamail').val());
			const username = $.trim($('#userName').val());
			const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
			let hasError = false;
			$('#emailError').text('');
			$('#nameError').text('');
			$('#formSuccess').hide().removeClass('alert-success alert-danger').text('');

			if (email === '') {
				$('#emailError').text('Please enter an email address.');
				hasError = true;
			} else if (!emailRegex.test(email)) {
				$('#emailError').text('Please enter a valid email address.');
				hasError = true;
			}

			if (username === '') {
				$('#nameError').text('Please enter a name.');
				hasError = true;
			} else if (!/^[A-Za-z\s'-]+$/.test(username)) {
				$('#nameError').text('Please enter a valid name using letters, spaces, hyphens, and apostrophes only.');
				hasError = true;
			}

			if (hasError) return false;
			
			$.ajax({
				url: '<?php echo Yii::app()->baseUrl?>/index.php?r=site/createinviteuser',
				type: 'POST',
				data: { email: email, username: username },
                beforeSend: function() {
                    $('#inviteUserSubmit').prop('disabled', true);
                },
				success: function(res){
					$('#inviteUserSubmit').prop('disabled', false);
					$('#emailError').text('');
					$('#nameError').text('');
					
					// Trim the response to handle any whitespace
					res = $.trim(res);					
					if (res === 'success') {
						$('#invite-user')[0].reset();
						showAlert('User Invited Successfully!', 'success');
						$.fn.yiiGridView.update('user-list-grid');
						return;
					}
					if (res === 'exists') {
						showAlert('This email already exists for your account.', 'danger');
						return;
					}
					if (res === 'invalid') {
						showAlert('Please provide valid details.', 'danger');
						return;
					}
					if (res === 'mail_not_sent') {
						showAlert('User created but invitation email could not be sent. Please try again later.', 'danger');
						$.fn.yiiGridView.update('user-list-grid');
						return;
					}
					if (res.indexOf('error:') === 0) {
						var errorMessage = res.substring(6).trim(); // Remove 'error:' prefix
						showAlert(errorMessage || 'An error occurred while processing your request.', 'danger');
						return;
					}
					// Fallback for any other unexpected response
					showAlert('Something went wrong. Please try again.', 'danger');
				},
				error: function(){
					$('#inviteUserSubmit').prop('disabled', false);
					$('#emailError').text('');
					$('#nameError').text('');
					showAlert('Unable to submit. Please try again.', 'danger');
				}
			});
		});
	});

	function deleteUserModal(id) {
		$("#deletedUserId").val(id);
	}
	$('#confirmdeleteuser').on('click', function () {
		const deletedUserId = $('#deletedUserId').val();
		$.ajax({
			url:'<?php echo Yii::app()->baseUrl?>/index.php?r=site/deleteuser', 
			type:"POST",
			data:{user_id:deletedUserId},
			success: function(res) {
				if (res == 'success') {
					$('#deleteuser').modal('hide');
					showAlert('User Deleted Successfully!', 'success');
					$.fn.yiiGridView.update('user-list-grid');
				} else {
					showAlert('Failed to delete user. Please try again.', 'danger');
				}
			},
			error: function (error) {
				showAlert('Unable to delete user. Please try again.', 'danger');
			}
		});

	});
</script>
