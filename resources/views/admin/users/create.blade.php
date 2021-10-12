@extends('layouts.admin')

@section('title', $user::getMsgTrans('create_heading'))

@section('javascript')
    <script>
        $(document).ready(function () {

            $("#wrap_select_places").hide();

            $("#roles").on('change', function () {
                // console.log($("#roles").val());
                let arr_roles = $("#roles").val();
                // console.log(arr_roles[0]);

                if(arr_roles[0] == 2 || arr_roles[0] == 8) {
                    $("#wrap_select_places").fadeIn(600);
                } else {
                    $("#wrap_select_places").fadeOut(600);
                }
            });

            // roleSelect.addEventListener('change', function(){
            // });
        });
    </script>
@endsection


@section('content')
@include('partials._content-heading', ['title' => $user::getMsgTrans('create_heading')])

@include('partials._alerts')

{{ html()->form('POST', route('admin.users.store'))->class('')->acceptsFiles()->open() }}

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 form-group text-center" style="min-height: 150px;">
                <ul class="list-group preview-container avatar-preview-container">

                </ul>
                @include('partials._file-upload', ['name' => 'image', 'label' => __('Avatar'), 'previewContainer' => 'avatar-preview-container', 'multiple' => false])
            </div>

            @include('partials.inputs._email', ['name' => 'email', 'label' => $user::getAttrsTrans('email').'*', 'width' => 4])

            <div class="col-md-4 form-group">
                {{ html()->label($user::getAttrsTrans('locale').'*', 'locale')->class('control-label') }}
                <select name="locale" id="locale" class="select2-with-flag" data-placeholder="@lang('Select...')">
                    @foreach(config('main.available_languages') as $abbr => $label)
                        <option value="{{ $abbr }}" @if(old('locale') && old('locale') == $abbr) selected="selected" @endif data-flag="{{ $abbr != 'en' ? $abbr : 'gb' }}">{{ __($label) }}</option>
                    @endforeach
                </select>
            </div>

            @include('partials.inputs._password', ['name' => 'password', 'label' => $user::getAttrsTrans('password').'*', 'width' => 4])

            <div class="col-md-4 form-group @if($errors->has('password')) has-error @endif">
                {{ html()->label(__('password_confirmation-form-label').'*', 'password_confirmation')->class('control-label') }}
                {{ html()->password('password_confirmation')->class('form-control') }}
                @include('partials._field-error', ['field' => 'password'])
            </div>
        </div>
        <div class="row">
            @include('partials.inputs._text', ['name' => 'name', 'label' => $user::getAttrsTrans('name').'*', 'width' => 6])

            @include('partials.inputs._text', ['name' => 'surname', 'label' => $user::getAttrsTrans('surname').'*', 'width' => 6])
        </div>
        @can('view_sensitive_data', \App\Models\Admin\User::class)
            <div class="row">

                @include('partials.inputs._select-multi', [
                    'name' => 'roles',
                    'label' => $user::getAttrsTrans('roles').'*',
                    'width' => 8,
                    'options' => $roles,
                    'multiple' => true
                ])

                <div class="col-md-4 form-group @if($errors->has('active')) has-error @endif">
                    {{ html()->label($user::getAttrsTrans('active').'*', 'active')->class('control-label') }}
                    <div class="radio">
                        <label for="active_true">
                            {{ html()->radio('active', old('active') == 1 ? true : false, 1)->id('active_true')->disabled(!Auth::user()->can('change_active_status', \App\Models\Admin\User::class)) }}@lang('Yes')
                        </label>
                        <label for="active_false" style="margin-left: 20px;">
                            {{ html()->radio('active', old('active') == 0 ? true : false, 0)->id('active_false')->disabled(!Auth::user()->can('change_active_status', \App\Models\Admin\User::class)) }}@lang('No')
                        </label>
                    </div>
                    @include('partials._field-error', ['field' => 'active'])
                </div>
            </div>
            <div class="row">
                <div id="wrap_select_places">
                    @include('partials.inputs._select-multi', [
                        'name' => 'places',
                        'label' => __('Sede').'*',
                        'width' => 12,
                        'options' => $places,
                        'multiple' => false,
                    ])
                </div>

                {{-- @include('partials.inputs._select-places', [
                    'name' => 'places',
                    'label' => __('Sede').'*',
                    'width' => 12,
                    'options' => $places,
                    'selected' => [3],
                ]) --}}
            
            </div>


        @endcan
    </div>
</div>

<div class="pull-left">
    {{ html()->submit(__('Save'))->class('btn btn-success') }}
</div>

<div class="pull-right">
    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">@lang('Back')</a>
</div>
{{ html()->form()->close() }}
@stop



