<x-mail::message>
# {{ trans('pdf.email_greetings') }}

{{ trans('pdf.email_first_message') }}

{{ trans('pdf.email_second_message') }}

{{ trans('pdf.email_third_message') }}

{{ trans('pdf.email_signature') }}<br>
{{ config('app.name') }}
</x-mail::message>
