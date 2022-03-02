@component('mail::message')

Name : {{ $name }} <br>
Email : {{ $email }} <br>

Message : {{ $message }} <br>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
