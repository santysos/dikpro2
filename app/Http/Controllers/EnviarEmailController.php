<?php

namespace App\Http\Controllers;

use App\Mail\EnviarEMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnviarEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {

        }

    }

    public function EnviarOrdenPorEmail(Request $request)
    {
        Mail::to($request->email)->send(new EnviarEMail($request->content));
    }
    public function create()
    {

    }

    public function store(ProductosFormRequest $request)
    {

    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(ProductosFormRequest $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
