@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])

        <div style="text-align: center;">
            <img src="{{ asset('/img/v1/logo-sapius.svg') }}" alt="Sapius Logo" style="max-width: 25%; height: auto; display: block; margin: 0 auto;">
        </div>
        @endcomponent
    @endslot

    {{-- Body --}}
    {!! $slot !!}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
