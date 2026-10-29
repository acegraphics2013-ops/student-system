@props(['type'=>'primary'])

<div 
    {{ 
        $attributes->merge([
            "class" => "alert alert-{$type}"
        ]) 
    }}
    role="alert"
>
  {{ $slot }}
</div>