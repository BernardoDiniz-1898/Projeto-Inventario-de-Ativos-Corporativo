<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    protected array $supported = [
        'pt_BR' => 'pt_BR',
        'en' => 'en',
        'es' => 'es',
    ];

    public function switch(Request $request, string $locale)
    {
        if (!isset($this->supported[$locale])) {
            abort(400);
        }

        Session::put('locale', $locale);

        return redirect()->back();
    }
}
