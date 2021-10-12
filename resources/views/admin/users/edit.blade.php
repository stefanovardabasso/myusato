@extends('layouts.admin')

@section('title', App\Models\Admin\User::getMsgTrans('update_heading'))

@section('content')
@include('partials._content-heading', ['title' => App\Models\Admin\User::getMsgTrans('update_heading')])

@include('partials._alerts')

{{ html()->modelForm($user, 'PUT', route('admin.users.update', [$user]))->id('profile_form')->open() }}

<div class="panel panel-default">
    <div class="panel-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="tab-green active"><a href="#about" data-toggle="tab">@lang('About')</a></li>
                @can('view_permissions', \App\Models\Admin\User::class)
                    <li class="tab-green"><a href="#permissions" data-toggle="tab">@lang('Permissions')</a></li>
                @endcan
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="about" style="padding-top: 10px;">
                    <div class="row">
                        <div class="col-md-4 form-group text-center">
                            <div class="form-group">
                                <div class="avatar">
                                    <div class="avatar__border">
                                        <div class="avatar__canvas">
                                            @php
                                            $profileImage = $user->getMedia('profile-image');
                                            @endphp

                                            {{ html()->img(count($profileImage) ? $profileImage[0]->getUrl() : asset('images/admin-panel/profile-placeholder.png'))->class('img-responsive')->id('profile-preview-img') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group profile">
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> @lang('Avatar')
                                    <input type="file"
                                           name="image"
                                           class="btn file-upload">
                                </div>
                            </div>
                        </div>

                        @include('partials.inputs._email', ['name' => 'email', 'label' => $user::getAttrsTrans('email').'*', 'width' => 4])

                        <div class="col-md-4 form-group">
                            {{ html()->label($user::getAttrsTrans('locale').'*', 'locale')->class('control-label') }}
                            <select name="locale" id="locale" class="select2-with-flag" data-placeholder="@lang('Select...')">
                                @foreach(config('main.available_languages') as $abbr => $label)
                                    <option value="{{ $abbr }}" @if($user->locale == $abbr || old('locale') == $abbr) selected="selected" @endif data-flag="{{ $abbr != 'en' ? $abbr : 'gb' }}">{{ __($label) }}</option>
                                @endforeach
                            </select>
                        </div>

                        @include('partials.inputs._password', ['name' => 'password', 'label' => $user::getAttrsTrans('password').'*', 'width' => 4])

                        <div class="col-md-4 form-group @if($errors->has('password_confirmation')) has-error @endif">
                            {{ html()->label(__('password_confirmation-form-label'), 'password_confirmation')->class('control-label') }}
                            {{ html()->password('password_confirmation')->class('form-control') }}
                            @include('partials._field-error', ['field' => 'password_confirmation'])
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
                                'selected' => $user->roles()->pluck('id')->toArray(),
                                'multiple' => true
                            ])

                            <div class="col-md-4 form-group @if($errors->has('active')) has-error @endif">
                                {{ html()->label($user::getAttrsTrans('active').'*', 'active')->class('control-label') }}
                                <div class="radio">
                                    <label for="active_true">
                                        {{ html()->radio('active', (!is_null(old('active')) && old('active') == 1) || $user->active ? true : false, 1)->id('active_true')->disabled(!Auth::user()->can('change_active_status', \App\Models\Admin\User::class)) }}@lang('Yes')
                                    </label>

                                    <label for="active_false" style="margin-left: 20px;">
                                        {{ html()->radio('active', (!is_null(old('active')) && old('active') == 0) || !$user->active ? true : false, 0)->id('active_false')->disabled(!Auth::user()->can('change_active_status', \App\Models\Admin\User::class)) }}@lang('No')
                                    </label>
                                </div>
                                @include('partials._field-error', ['field' => 'active'])
                            </div>
                        </div>
                    @endcan

                </div>
                @can('view_permissions', \App\Models\Admin\User::class)
                    <div class="tab-pane" id="permissions" style="padding-top: 10px;">
                        @include('admin.permissions.partials._permissions',
                        [
                            'sections' => $sections,
                            'roles' => $user->getRolesTrans(),
                            'user_id' => $user->id
                        ])
                    </div>
                    <div class="row">

                        {{-- @if($user_role == 2 || $user_role == 8)
                            @include('partials.inputs._select-multi', [
                                'name' => 'places',
                                'label' => __('Sede').'*',
                                'width' => 12,
                                'options' => $places,
                                'multiple' => false,
                                'selected' => [$user_place],
                            ])
                        @endif --}}

                        <div id="wrap_select_places" style="display: none;">
                            @include('partials.inputs._select-multi', [
                                'name' => 'places',
                                'label' => __('Sede').'*',
                                'width' => 12,
                                'options' => $places,
                                'multiple' => false,
                                'selected' => [$user_place],
                            ])
                        </div>

                        <div id="wrap_select_badge" style="display: none;">
                            @include('partials.inputs._text', ['name' => 'user_badge', 'label' => __('Badge').'*', 'width' => 6])
                        </div>

                    </div>



                @endcan
            </div>
        </div>
    </div>
</div>

<div class="pull-left">
    {{ html()->submit(__('Save'))->class('btn btn-success update_profile_btn') }}
</div>

<div class="pull-right">
    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">@lang('Back')</a>
</div>
{{ html()->form()->close() }}
@stop

@section('javascript')
@parent
<script>
    $(document).ready(function () {
        $.ajax({
                url: "{{ route('admin.place.getrole') }}?user_id={{ request('user')->id }}",
                type: 'get',
                success: function(response){
                    if(response['role'] == 2 || response['role'] == 8) {
                        $("#wrap_select_places").show();
                        $("#wrap_select_badge").show();
                    }
                }
            });

        // $("#wrap_select_places").hide();

        $("#roles").on('change', function () {
            let arr_roles = $("#roles").val();
            if(arr_roles[0] == 2 || arr_roles[0] == 8) {
                $("#wrap_select_places").fadeIn(600);
                $("#wrap_select_badge").fadeIn(600);
            } else {
                $("#wrap_select_places").fadeOut(600);
                $("#wrap_select_badge").fadeOut(600);
            }
        });

        let $profileImage = $('#profile-preview-img');
        let $imageInput = $('input[name="image"]');
        let $updateButton = $('.update_profile_btn');
        let cropperConfig = {
            aspectRatio: 1 / 1,
            autoCropArea: 100,
            minContainerWidth: 138,
            minCanvasWidth: 138,
            dragMode: "none",
            cropBoxResizable: false
        };

        $profileImage.cropper(cropperConfig);

        $imageInput.on('change', function () {
            readURL(this);
        });

        $updateButton.on('click', function (evt) {
            evt.preventDefault();

            let form = $('#profile_form');
            let avatar = $('#profile-preview-img');
            let currentAvatarUrl = '{{ count($profileImage) ? $profileImage[0]->getFullUrl() : asset('images/admin-panel/profile-placeholder.png') }}';

            if (currentAvatarUrl.substr(-avatar.attr("src").length) !== avatar.attr("src")) {
                let cropCanvas = $profileImage.cropper('getCroppedCanvas');
                let cropPNG = cropCanvas.toDataURL("image/png");
                $.ajax('{{ route('admin.profile.avatar', [$user]) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        image: cropPNG,
                    },
                    success: function (res) {
                        form.submit();
                    },
                    error: function (err, a, b) {
                        if (err.hasOwnProperty('responseJSON') && err.responseJSON.hasOwnProperty('errors') && err.responseJSON.errors.hasOwnProperty(image)) {
                            let alert = '<div class="alert alert-danger"><ul class="list-unstyled"><li>' + err.responseJSON.errors.image[0] + '</li></ul></div>';
                            $('.alerts').append(alert);
                            $("html, body").animate({scrollTop: 0}, "slow");
                            return false;
                        }

                        let alert = '<div class="alert alert-danger"><ul class="list-unstyled"><li>' + _t('There was an error while uploading the avatar. Please try with another image or contact the support team.') + '</li></ul></div>';
                        $('.alerts').append(alert);
                        $("html, body").animate({scrollTop: 0}, "slow");
                        return false;

                    }
                });
            } else {
                form.submit();
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $profileImage.attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
                $profileImage.cropper('destroy');

                setTimeout(function () {
                    $profileImage.cropper(cropperConfig);
                }, 1000);
            }
        }
    });
</script>
@stop


