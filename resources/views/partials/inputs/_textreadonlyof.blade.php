@php
    $width = !empty($width) ? $width : 12;
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    <input name="{{$name}}" value="{{$offert->$name}}" class="form-control" readonly>
    @include('partials._field-error', ['field' => $name])
</div>
