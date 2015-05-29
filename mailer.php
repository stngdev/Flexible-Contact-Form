<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["cd-name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
		$companyname = strip_tags(trim($_POST["cd-company"]));
				$companyname = str_replace(array("\r","\n"),array(" "," "),$companyname);
        $email = filter_var(trim($_POST["cd-email"]), FILTER_SANITIZE_EMAIL);
        $budget = $_POST["cd-budget"];
		$project = $_POST["radio-button"];
		$features = implode(' | ', $_POST["checkbox_group"]);
		$message = trim($_POST["cd-textarea"]);
		
		

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "stephenn@nowsolutions.com.au";

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content = "Name: $name\n";
		$email_content .= "Company: $budget $companyname\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n\n";
		$email_content .= "$name has a budget of $budget\n";
		$email_content .= "Project type is $project\n";
		$email_content .= "Features: $features";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>