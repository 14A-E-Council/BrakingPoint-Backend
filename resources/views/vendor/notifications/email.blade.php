<x-mail::message>
{{-- Greeting --}}

@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Kedves felhasználó!')
@endif
@endif

{{-- Intro Lines --}}
Kérjük kattintson az alábbi gombra, hogy megerősítse az e-mail címét!

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" color="error">
E-mail cím megerősítse!
</x-mail::button>
@endisset

{{-- Outro Lines --}}
Ha nem Ön hozta létre ezt a fiókot, további teendőre nincs szükség!

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Üdvözlettel'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Ha problémája adódik a \":actionText\" gomb megnyomásával, másolja be a következő URL-t\n".
    'a böngészőjébe:',
    [
        'actionText' => "E-mail cím megerősítése!",
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
