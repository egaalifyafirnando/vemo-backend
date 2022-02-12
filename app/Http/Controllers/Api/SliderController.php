<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $sliders = Slider::latest()->get();
        return response()->json([
            'success'   => true,
            'message'   => 'List Data Sliders',
            'sliders'   => $sliders
        ]);
    }
}
