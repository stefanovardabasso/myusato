@php
    $width = !empty($width) ? $width : 12;
@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    <?php if(isset($readonly)){ ?>
    {{ html()->text($name, null)->class('form-control')->readonly() }}
    <?php }else{ ?>
    {{ html()->text($name, null)->class('form-control') }}
    <?php } ?>
    @include('partials._field-error', ['field' => $name])
</div>
