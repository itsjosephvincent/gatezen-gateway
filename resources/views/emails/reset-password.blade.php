<x-mail::message>
Hi {{ $user->firstname }} {{ $user->lastname }},
<br><br>
We have received a request to reset the password on your Gateway account.
<br><br>
To complete the password reset, please visit the following URL below and update your password.
<br><br>
<a href="{{ env('APP_USER_URL') }}/reset-password?token={{ $token }}">
    {{ env('APP_USER_URL') }}/reset-password?token={{ $token }}
</a>
<br><br>
If you did not specifically request this password change, please contact support immediately.
<br><br>
Thank you,
<br><br>
Support
{{ env('APP_NAME') }}
</x-mail::message>

