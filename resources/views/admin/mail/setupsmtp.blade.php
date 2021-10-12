@extends('layouts.admin')

@section('title',  __('Mail setup'))

@section('content')
    @include('partials._content-heading', ['title' => __('Mail setup')])

    @include('partials._alerts')


    @foreach($mymail as $my)
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="POST" action="{{route('admin.storesmtp')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group ">
                            <label for="host" class="control-label">{{ __('Host') }}</label>
                            <input type="text" name="host" id="host" value="{{$my->host}}" class="form-control">
                        </div>
                        <div class="col-md-4 form-group ">
                            <label for="port" class="control-label">{{ __('Port') }}</label>
                            <input type="text" name="port" id="port" value="{{$my->port}}" class="form-control">
                        </div>
                        <div class="col-md-4 form-group ">
                            <label for="user" class="control-label">{{ __('User') }}</label>
                            <input type=text"" name="user" id="user" value="{{$my->user}}" class="form-control">
                        </div>
                        <div class="col-md-4 form-group ">
                            <label for="password" class="control-label">{{ __('Password') }}</label>
                            <input type="text" name="password" id="password" value="{{$my->password}}" class="form-control">
                        </div>

                        <div class="col-md-4 form-group ">
                            <label for="encryption" class="control-label">{{ __('Encryption') }}</label>
                            <input type="text" name="encryption" id="encryption" value="{{$my->encryption}}" class="form-control">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group" style="margin-top: 20px;">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success update_profile_btn">Salva</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach


    <div class="pull-right">
        <a href="{{ URL::previous() }}" class="btn btn-primary">@lang('Back')</a>
    </div>


@stop


