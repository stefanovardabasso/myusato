@php
    $width = !empty($width) ? $width : 12;
    $options = !empty($options) ? $options : [];
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    <select name="{{ $name  }}" class="form-control select2-rendered">
        <option>Si</option>
        <option selected>No</option>
    </select>

    @include('partials._field-error', ['field' => $name])
</div>
