<div>
    <h1>Password Reset Request</h1>
    <p>We received a request to reset your password. Click the button below to reset your password automatically.</p>

    <p>
        <a href="{{ url('/api/reset_password?token=' . $token . '&email=' . urlencode($email)) }}" style="display: inline-block; padding: 10px 20px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
            Reset Password
        </a>
    </p>

    <p>If you did not request a password reset, please ignore this email.</p>
</div>