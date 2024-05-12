@component('mail::message')
# Password Reset Request

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

Thank you for using our application!

@endcomponent