@component('mail::message')
## Product - {{$product}} has been showed successful



@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
