@component('mail::message')

## Hello Mr/Mrs {{$user_name}}
## Product - {{$product_name}} has been created successful



@component('mail::button', ['url' => '/example-app.loc'])
Check
@endcomponent

Thanks,<br>
     {{ config('app.name') }}
@endcomponent
