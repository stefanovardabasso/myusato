@php
    $width = !empty($width) ? $width : 12;
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    {{ html()->email($name, null)->class('form-control') }}
    @include('partials._field-error', ['field' => $name])
</div>
