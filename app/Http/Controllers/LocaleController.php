<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switchLocale(Request $request)
    {
        $locale = $request->post('locale');
        if (array_key_exists($locale, config('app.supported_locales'))) {
            app()->setLocale($locale);
            session()->put('locale', $locale);
        }
        return back();
    }
}


