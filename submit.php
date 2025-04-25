<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $origin       = htmlspecialchars($_POST['airport_origin']);
    $destination  = htmlspecialchars($_POST['airport_destination']);
    $checkin      = htmlspecialchars($_POST['checkin_date']);
    $checkout     = htmlspecialchars($_POST['checkout_date']);
    $adults       = htmlspecialchars($_POST['adults']);
    $children     = htmlspecialchars($_POST['children']);
    $name         = htmlspecialchars($_POST['name']);
    $email        = htmlspecialchars($_POST['email']);
    $phone        = htmlspecialchars($_POST['phone']);
   // $message      = nl2br(htmlspecialchars($_POST['message']));
    

    // Email content for admin
    $to = "anscd@yourdomain.com"; // CHANGE THIS!
    $subject = "New Travel Inquiry from $name";
    $body = "
    <h2>New Travel Inquiry</h2>
    <p><strong>From:</strong> $origin</p>
    <p><strong>To:</strong> $destination</p>
    <p><strong>Check-in:</strong> $checkin</p>
    <p><strong>Check-out:</strong> $checkout</p>
    <p><strong>Adults:</strong> $adults</p>
    <p><strong>Children:</strong> $children</p>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Phone:</strong> $phone</p>
    
    ";

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Travel Air <no-reply@domain.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    // Send email to admin
    $admin_sent = mail($to, $subject, $body, $headers);

    // Auto-response to user
    $user_subject = "Thank You for Your Travel Inquiry";
    $user_body = "
        Dear $name,<br><br>
        Thank you for your travel inquiry. Our team will get back to you shortly.<br><br>
        <strong>Your Submitted Details:</strong><br>
        Origin: $origin<br>
        Destination: $destination<br>
        Check-in: $checkin<br>
        Check-out: $checkout<br>
        Adults: $adults<br>
        Children: $children<br><br>
        If you have additional questions, feel free to reply to this email.<br><br>
        Best regards,<br>
        Travel Air Team<br>
        
    ";
     $user_headers  = "MIME-Version: 1.0\r\n";
    $user_headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $user_headers .= "From: Travel Air <no-reply@domain.com>\r\n";

    // Send confirmation email to user
    $user_sent = mail($email, $user_subject, $user_body, $user_headers);
    
    if ($admin_sent && $user_sent) {
        http_response_code(200);
        echo "success";
    } else {
        http_response_code(500);
        echo "error sending email";
    }

    // Redirect to thank-you page
    header("Location: thankyou.html");
    exit;
}
?>
