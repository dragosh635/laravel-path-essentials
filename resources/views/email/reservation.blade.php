@component('mail::message')
    # Introduction

    Reservation for {{ $name }} as {{ config('app.name') }}

    @component('mail::button', ['url' => ''])
        Button Text
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
