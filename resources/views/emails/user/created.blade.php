@component('mail::message')
# Welcome, {{ $user->name }}!

Thank you for joining our platform. We’re excited to have you on board.

@component('mail::button', ['url' => route('dashboard')])
Go to Dashboard
@endcomponent

If you have any questions, feel free to reach out to our support team.

Thanks,<br>
{{ config('app.name') }}
@endcomponent