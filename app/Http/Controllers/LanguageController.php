<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    private $locales = ['en', 'it'];

    public function store() {
        $lang = request('lang');

        app()->setLocale($lang);
        session()->put('locale', $lang);

        return back();
    }
}
