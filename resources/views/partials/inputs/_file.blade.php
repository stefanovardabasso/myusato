@php
    $width = !empty($width) ? $width : 12;
    $multiple = !empty($multiple) ? true : false;
    $inputName = !empty($multiple) ? $name.'[]' : $name;
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    <ul class="list-group preview-container {{ $previewContainer }}">

    </ul>
    @include('partials._file-upload', ['name' => $inputName, 'label' => $label, 'previewContainer' => $previewContainer, 'multiple' => $multiple])
    @include('partials._field-error', ['field' => $name])
</div>
