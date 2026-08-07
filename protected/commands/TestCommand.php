<?php

class TestCommand extends CConsoleCommand {
    public function run($args) {
        $email_to="bhaveshvaghela32@gmail.com";
		$email_subject="It works";
		$email_message="Hello. I can send mail!";
		$headers = "From: Bhavesh\r\n"."Reply-To: bhaveshvaghela05@yahoo.com\r\n'" ."X-Mailer: PHP/" . phpversion();
		mail($email_to, $email_subject, $email_message, $headers);  
    }
}
?>