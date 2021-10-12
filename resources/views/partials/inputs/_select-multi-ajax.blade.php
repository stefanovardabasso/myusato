@php
    $width = !empty($width) ? $width : 12;
    $selected = !empty($selected) ? $selected : [];
    $multiple = !empty($multiple) ? true : false;
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    <select name="{{ $name }}[]" id="{{ $name }}"
            class="form-control select2-ajax"
            data-placeholder="@lang('Search...')"
            data-url="{{ $route }}"
            data-text_field="text"
            @if($multiple) multiple="multiple" @endif>
        @foreach($selected as $id => $optionLabel)
            <option value="{{ $id }}" @if(!old($name) || (old($name) && in_array($id, old($name)))) selected="selected" @endif>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @include('partials._field-error', ['field' => $name])
</div>
