<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class JsonController extends Controller
{
    protected $students;
    public function __construct() {
        $this->students = [
            'Ace Cabuga',
            'Jahs Morate',
            'Joseph Barrot',
        ];
    }
    public function index()
    {
        return response()->json($this->students);
    }
}
