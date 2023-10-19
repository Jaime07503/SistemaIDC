<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function proceso(Request $request) {
        $materia = $request->materia;
        return view('layouts.investigaciones-proceso', ['materiaIDC' => strtr($materia, "-", " "), 'progresoIDC' => 75]);
    }
}
