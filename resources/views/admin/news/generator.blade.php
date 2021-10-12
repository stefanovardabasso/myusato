@extends('layouts.admin')

@section('title',  __('Newsletter'))

@section('content')
    @include('partials._content-heading', ['title' => __('Generazione template newsletter')])

    @include('partials._alerts')
    <div class="row">
        <div class="col-lg-12">

            <div class=" pull-right" style="margin-bottom: 2%">
                <button class="btn btn-primary" onclick="copyfunction()">
                    <i class="glyphicon glyphicon-duplicate"></i>
                </button>
            </div>

             <textarea id="myInput" class="form-control">
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Cls - Myusato</title>
                        </head>
                        <body style="margin:0;padding:0;border:0;font-family:'Open Sans', sans-serif;background:#f2f2f2;">
                        <div class="wrapper" style="width:100%;background-color:#ffcb0f;max-width:600px;margin:0 auto;">
                            <div class="header" style="text-align:center;">
                                <img src="https://rtc.cls.it/images/admin-panel/logo.png" alt="" style="width:50%">
                            </div>
                            <div class="main" style="padding:40px;background-color:#fff;">


                                        <center><a href="http://myusato.cls.it/"> {{__('Vai')}}</a> </center>

                            </div>
                            <table class="footer" style="font-family:'Open Sans', sans-serif;width:100%;padding:20px;background-color:#ffcb0f;">

                            </table>
                        </div>
                        </body>
                        </html>
             </textarea>

        </div>
    </div>


    <div class="pull-right" style="margin-top: 5%">
        <a href="{{ URL::previous() }}" class="btn btn-primary">@lang('Back')</a>
    </div>

<script>
    function copyfunction() {
        var copyText = document.getElementById("myInput");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

        /* Alert the copied text */
        alert("Copied the text");
    }



</script>
@stop


