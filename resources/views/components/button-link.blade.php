@props(['href' => null, 'type' => 'primary'])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "btn btn-{$type}"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="submit" {{ $attributes->merge(['class' => "btn btn-{$type}"]) }}>
        {{ $slot }}
    </button>
@endif
