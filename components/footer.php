<?php
if(isset($_POST['subscribe_newsletter'])) {
    // Verify CSRF token
    if(!isset($_POST['csrf_token'])) {
        $warning_msg[] = 'Invalid form submission';
    } else {
        $email = filter_var($_POST['newsletter_email'], FILTER_SANITIZE_EMAIL);
        
        // Validate email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $warning_msg[] = 'Please enter a valid email address';
        } else {
            $directory = __DIR__ . '/../newsletters';
            $filepath = $directory . '/subscribers.txt';
            
            // Create directory if it doesn't exist
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0777, true)) {
                    $warning_msg[] = 'Unable to create newsletter directory';
                    goto end_subscription;
                }
            }
            
            // Check if email already exists
            $exists = false;
            if (file_exists($filepath)) {
                $existing_emails = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                if ($existing_emails !== false) {
                    $exists = in_array($email, $existing_emails);
                }
            }
            
            if($exists) {
                $warning_msg[] = 'This email is already subscribed';
            } else {
                // Append email to file
                if (file_put_contents($filepath, $email . PHP_EOL, FILE_APPEND) !== false) {
                    $success_msg[] = 'Thank you for subscribing to our newsletter!';
                } else {
                    $warning_msg[] = 'Unable to save your subscription';
                }
            }
        }
    }
    end_subscription:
}
?>
<div class="top-footer">
	<h2><i class="bx bx-envelope"></i>Sign Up For Newsletter</h2>
	<form method="post" action="" class="input-field">
		<input type="hidden" name="csrf_token" value="<?php echo bin2hex(random_bytes(32)); ?>">
		<input type="email" name="newsletter_email" placeholder="email address..." required>
		<button type="submit" name="subscribe_newsletter" class="btn">subscribe</button>
	</form>
</div>
<footer>
	<div class="overlay"></div>
	<div class="footer-content">
		<div class="img-box">
			<img src="img/logo2.png">
		</div>
		<div class="inner-footer">
			<div class="card">
				<h3>about us</h3>
				<ul>
					<li>about us</li>
					<li>our difference</li>
					<li>community matters</li>
					<li>press</li>
					<li>blog</li>
					<li>bouqs video</li>
				</ul>
			</div>
			<div class="card">
				<h3>services</h3>
				<ul>
					<li>order</li>
					<li>help center</li>
					<li>shipping</li>
					<li>term of use</li>
					<li>account detail</li>
					<li>my account</li>
				</ul>
			</div>
			<div class="card">
				<h3>local</h3>
				<ul>
					<li>allahabad</li>
					<li>mumbai</li>
					<li>new delhi</li>
					<li>old delhi</li>
					<li>new yourk</li>
					<li>los angeles</li>
				</ul>
			</div>
			<div class="card">
				<h3>newsletter</h3>
				<p>Sign Up For Newslatter</p>
				<div class="social-links">
					<i class="bx bxl-instagram"></i>
					<i class="bx bxl-twitter"></i>
					<i class="bx bxl-behance"></i>
					<i class="bx bxl-youtube"></i>
					<i class="bx bxl-whatsapp"></i>
				</div>
			</div>
		</div>
		<div class="bottom-footer">
			<p>Gina - Hawazen </p>
		</div>
	</div>
</footer>