@php
    $width = !empty($width) ? $width : 12;
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    <div class="radio">
        @php $first = true; @endphp
        @foreach($options as $id => $optionLabel)
            <label for="{{ $name . '_' . $id }}" @if(!$first) style="margin-left: 20px;" @endif>
                {{ html()->radio($name, old($name) == $id ? true : false, $id)->id($name . '_' . $id) }}{{ $optionLabel }}
            </label>
            @php $first = false; @endphp
        @endforeach
    </div>
    @include('partials._field-error', ['field' => $name])
</div>
