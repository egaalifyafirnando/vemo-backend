<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(10);
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link' => 'required'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        // save to DB
        $slider = Slider::create([
            'image' => $image->hashName(),
            'link' => $request->link
        ]);

        if ($slider) {
            // redirect dengan pesan sukses
            return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            // redirect dengan pesan error
            return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $image = Storage::disk('local')->delete('public/sliders/' . $slider->image);
        $slider->delete();

        if ($slider) {
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
