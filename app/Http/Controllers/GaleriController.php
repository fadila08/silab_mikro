<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Galeri;
use App\Transformers\GaleriTransformer;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Galeri $galeri)
    {
        $galeri = $galeri->all(); 

        return fractal()
            ->collection($galeri)
            ->transformWith(new GaleriTransformer)
            ->toArray();
    }

    public function show(Galeri $galeri, $id)
    {
        $galeri = $galeri->find($id);
        
        if ($galeri == null) {
            return response()->json(['error' => 'foto tidak ditemukan'], 401);
        }

        return fractal()
            ->item($galeri)
            ->transformWith(new GaleriTransformer)
            ->toArray();
    }
    
    public function store(Request $request, Galeri $galeri)
    {
        $this->validate($request, [
            'judul' => 'required',
            'gambar' => 'file',
        ]);

        // $gambar = $request->gambar;
        // $filename = uniqid().time().'.'.$gambar->extension();
        // $path = 'gambar'.$filename;
        // // $path = 'gambar'.$gambar;
        
        // $fullpath = public_path('gambar');
        
        // if ($request->hasFile('gambar')){
        //     $gambar = file_get_contents($request->gambar->getRealPath());
        //     $gambar =base64_encode($gambar);
        // }
        // else {
        //     $gambar = null;
        // }
        
        // //check if directory i exist or not
        // File::isDirectory($path) or File::makeDirectory($fullpath, 0777, true, true);
        
        // //resize image
        // $image_resize = Image::make($gambar->getRealPath());
        // $image_resize->resize(700, null, function($constraint){
        //     $constraint->aspectRatio();
        // });
        
        // //upload image
        // $image_resize->save( public_path('gambar'.$filename) );

        $gambar = $request->file('gambar')->store('gambar');
        
        $galeri = $galeri->create([
            'judul' => $request->judul,
            'gambar' => $gambar,
        ]);

        $response = fractal()
        ->item($galeri)
        ->transformWith(new GaleriTransformer)
        ->toArray();
                    
        return response()->json($response, 201);

    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri == null) {
            return response()->json(['error' => 'foto tidak ditemukan'], 401);
        }

        $galeri->delete();

        return response()->json([
            'message' => 'data sudah terhapus',
        ]);
    }
}