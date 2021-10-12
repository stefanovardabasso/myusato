@extends('emails.layouts.admin')

@section('content')

    <h2>@lang('Hello :name :surname!', ['name' => $notifiable->name, 'surname' => $notifiable->surname])</h2>

    <p>{{ new \Illuminate\Support\HtmlString(__('The requested report <b>:report</b> is <b>:state</b>.', [
        "report" => class_exists($report->model_target) && method_exists($report->model_target, 'getTitleTrans')
            ? $report->model_target::getTitleTrans()
            : __($report->model_target)
    , "state" => $state
    ])) }}</p>

    <p>{{ $report->state == 'failed' ? $report->message : __('You can download the report here:') }}</p>

    <p>
        <a href="{{ route('admin.reports.index') }}"
           target="_blank"
           style="box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block;
           text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1;
           border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">
            @lang('Download')
        </a>
    </p>

    <p>
        @lang('Regards'),<br>
        {{ config('app.name') }}
    </p>

@stop

@section('footer')
    <p>
        @lang("If you're having trouble clicking the button, copy and paste the URL below into your web browser:")
        <br>
        <a href="{{ route('admin.reports.index') }}" target="_blank">{{ route('admin.reports.index') }}</a>
    </p>
@stop
