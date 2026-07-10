<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark',
            'font_size' => 'required|in:small,normal,large',
            'accent_color' => 'required|in:blue,green,purple,red,orange',
            'sidebar' => 'required|in:collapsed,expanded',
        ]);

        return response()->json(['success' => true, 'settings' => $validated]);
    }
}
