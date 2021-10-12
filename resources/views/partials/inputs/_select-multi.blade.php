@php
    $width = !empty($width) ? $width : 12;
    $selected = !empty($selected) ? $selected : [];
    $multiple = !empty($multiple) ? true : false;
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    <select name="{{ $name }}[]" id="{{ $name }}"
            class="form-control select2-rendered"
            data-placeholder="@lang('Select...')"
            @if($multiple) multiple="multiple" @endif>
        @foreach($options as $id => $optionLabel)
            <option value="{{ $id }}" @if((!old($name) && in_array($id, $selected)) || (old($name) && in_array($id, old($name)))) selected="selected" @endif>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @include('partials._field-error', ['field' => $name])
</div>
