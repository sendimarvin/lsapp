<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index ()
    {
        $title = "Welcome to laravel";
        return view('pages.index')
            ->with('title', $title);
    }


    public function about ()
    {
        return view('pages.about');
    }

    public function services ()
    {   

        $services = array(
            'web design',
            'SEO',
            'App development'
        );

        return view('pages.services')
            ->with('services', $services);
    }
}
