<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class ContactController extends Controller
{
    public function index()
    {
        return view('clients.contact.index');
    }
} 