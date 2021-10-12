@php
    $width = !empty($width) ? $width : 12;
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->checkbox($name, '0', 1)->class('form-check-input') }}
    {{ html()->label($label, $name)->class('form-check-label') }}
    @include('partials._field-error', ['field' => $name])
</div>
