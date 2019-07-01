<?php
    # Link pages
    $thankyou_page = "thank_you.html";
    $error_page = "error_message.html";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $honeypot = FALSE;
        if (!empty($_REQUEST['contact_me_by_fax_only']) && (bool) $_REQUEST['contact_me_by_fax_only'] == TRUE) {
        $honeypot = TRUE;
        header("HTTP/1.0 404 Not Found");
        die();
        } else {

        # FIX: Replace this email with recipient email
        $mail_to = "info@ivojongmans.nl";
        
        # Sender Data
        
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["voornaam"])));
        $lname = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["achternaam"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);        
        $message = trim($_POST["message"]);
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($message)) {
            header( "Location: $error_page" );
            exit;
        }

        # Mail Content
        $content = "Bericht van $name $lname";

        # email headers.
        $headers = "Van: $name $lname <$email>\n";
        $headers .= "Bericht: $message";

        # Send the email.
        $success = mail($mail_to, $content, $headers);
        if ($success) {
            header( "Location: $thankyou_page" );
        } else {
            header( "Location: $error_page" );
        }
        }

    } else {
        header( "Location: $error_page" );
    }

?>