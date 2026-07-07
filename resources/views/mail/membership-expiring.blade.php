@component('mail::message')
# Membership Expiring Soon

Hi {{ $membership->user->name }},

Your **{{ $membership->plan->name }}** membership will expire on **{{ $membership->end_date->format('d M Y') }}**.

Renew now to keep your access uninterrupted.

@component('mail::button', ['url' => route('pricing')])
Renew Membership
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
