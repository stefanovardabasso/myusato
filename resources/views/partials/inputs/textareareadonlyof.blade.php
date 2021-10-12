@php
    $width = !empty($width) ? $width : 12;
    $rows = !empty($rows) ? $rows : 3;
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    <textarea class="form-control" readonly name="{{$name}}">{{$offert->$name}}</textarea>
    @include('partials._field-error', ['field' => $name])
</div>
