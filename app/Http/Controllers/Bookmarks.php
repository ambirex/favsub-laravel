<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class Bookmarks extends Controller
{
    public function index() {
      return view('base');
    }

    public function view($id, $slug) {
      echo $id . '<hr>'. $slug;
    }
}
