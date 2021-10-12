@php
    $width = !empty($width) ? $width : 12;

@endphp
<div class="col-md-{{ $width }} form-group @if($errors->has($name)) has-error @endif">
    {{ html()->label($label, $name)->class('control-label') }}
    <?php if(isset($onchange)){ ?>
    <input name="{{$name}}" id="{{$name}}" value="{{$offert->$name}}" onchange="">
    <?php }else{ ?>
    {{ html()->number($name, null)->class('form-control') }}
    <?php } ?>
    @include('partials._field-error', ['field' => $name])
</div>
