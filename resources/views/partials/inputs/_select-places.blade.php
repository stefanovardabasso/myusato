@php
    $width = !empty($width) ? $width : 12;
    $options = !empty($options) ? $options : [];
    $value = isset($value) ? $value : null;
    $value = old($name) ? old($name) : $value;
    $disabled = isset($disabled) ? $disabled : false;
    $attributes = isset($attributes) ? $attributes : [];
    $cssClass = isset($cssClass) ? ' ' . $cssClass : '';
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    {{
        html()->select($name, $options, $value)
            ->class('form-control select2-rendered' . $cssClass)
            ->data('placeholder', "Seleziona...")
            ->disabled($disabled)
            ->attributes($attributes)
    }}
    @isset($help)<p class="help-block">{!! $help !!}</p>@endisset

    @include('partials._field-error', ['field' => $name])
</div>


@php
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    @include('partials._field-error', ['field' => $name])
</div>
