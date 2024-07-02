<?php

namespace App\Http\Controllers;

use App\Models\Diagram;
use Illuminate\Http\Request;

class DiagramController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->input('data');

        // Validate and save the data to the database
        $diagram = new Diagram();
        $diagram->data = $data;
        $diagram->save();

        return response()->json(['success' => true]);
    }
}
