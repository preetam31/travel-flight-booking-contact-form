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
    $message      = nl2br(htmlspecialchars($_POST['message']));
    

    // Email content for admin
    $to = "abcd@yourdomain.com"; // CHANGE THIS!
    $subject = "New Flight Inquiry from $name";
    $body = "
    <h2>New Flight Inquiry</h2>
    <p><strong>Leaving From:</strong> $origin</p>
    <p><strong>Going To:</strong> $destination</p>
    <p><strong>Departing:</strong> $checkin</p>
    <p><strong>Returning:</strong> $checkout</p>
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
    
    
    $user_subject = "✈️ Your Flight Request - Travel Air";

    $user_body = '
    <html>
    <body style="font-family: Arial, sans-serif; color: #333;">
      <div style="max-width: 600px; margin: 0 auto; border: 1px solid #ccc; border-radius: 6px; padding: 20px;">
        <div style="text-align: center;">
          <img src="https://yourdomain.com/img/logo/companylogo.png" style="max-width: 200px;" alt="Logo">
        </div>
        <div style="padding: 20px;">
       <p style="font-size: 16px;">Dear <strong>' . $name . '</strong>,</p>
          <p><strong>Your flight request is processed</strong>.</p>
          <p>One of our Travel Agents will be in touch with you shortly. If you want to update your contact phone number, please complete this 
          <a href="mailto:reservation@yourdomain.com?subject=My preferred phone number &body=My preferred phone number%3A" style="text-decoration:underline;color:#0b5394;">form</a>.</p>

          <p><strong>Get a price quote instantly!</strong></p>
          <p>For immediate assistance, you can:</p>
          <p>
            <a href="mailto:reservation@yourdomain.com?subject=My travel request &body=Hi there%21%0A%0APlease proceed%20with my travel request and free planning%2E%0A%0AMy preferred phone contact number%3A%0A%0AAdditional information%3A" style="text-decoration:underline;color:#0b5394;">Reply</a> to this email Or call us at <a href="tel:+19000000000" style="text-decoration:underline;color:#0b5394;">+1 (416) 842 1666</a>
          </p>

          <div style="text-align:center; margin: 20px 0;">
  <a href="tel:+19000000000"
     style="display:inline-block;padding:10px 20px;background:#265eaa;color:#fff;text-decoration:none;border-radius:5px;font-size:16px;margin-right:10px;">
    <img src="assets/images/email/call-icon.png"
         alt="Call" style="vertical-align:middle;margin-right:10px;" height="16">
    Call
  </a>

  <a href="https://wa.me/+190000000?text=Please%20kindly%20assist%20me%20with%20my%20Travel%20Request.%20"
     style="display:inline-block;padding:10px 20px;background:#26a619;color:#fff;text-decoration:none;border-radius:5px;font-size:16px;">
    <img src="assets/images/email/wahtsapp-icon.png"
         alt="Chat" width="16" style="vertical-align:middle;margin-right:10px;">
    Chat
  </a>
</div>

          <p><strong>Call to book the top-rated airlines!</strong></p>
          <img src="assets/images/email/airlines-logo.jpg" width="100%" style="border-radius:6px;" alt="Airlines">

          <p>These are specially negotiated airfares and cannot be sold online.</p>

          <p>Travels offers worldwide discounted airline tickets, 24/7 support, flight + hotel booking, and over 2,100 Live Travel Agents.</p>

          <p><strong>Best regards,</strong><br>
          Travels & Tours<br>
          </p>
        </div>
      </div>
    </body>
    </html>
    ';
     $user_headers  = "MIME-Version: 1.0\r\n";
    $user_headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $user_headers .= "From: Travel Air <no-reply@domain.com>\r\n";
    $user_headers .= "Reply-To: <reservation@domain.com>\r\n";
    
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
