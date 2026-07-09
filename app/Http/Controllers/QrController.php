<?php

namespace App\Http\Controllers;

class QrController extends Controller
{
    /**
     * Standalone QR code generator page.
     *
     * The page is fully client-side (generation, customisation and download all
     * happen in the browser via the vendored qr-code-styling library), so the
     * controller only needs to serve the view. It is deliberately unlisted:
     * no link to it exists anywhere in the portfolio navigation.
     */
    public function index()
    {
        return view('qr.index');
    }
}
