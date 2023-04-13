<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class StudentController extends Controller
{
    public function index()
    {
        $url = 'http://localhost:8000/api/students';
        $data = Http::get($url);

        return view(
            'pages.student', 
            [
                'data' => $data['data']
            ]
        );
    }
}
