<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Unduhan;
use App\Transformers\UnduhanTransformer;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UnduhanController extends Controller
{
    public function insert(Request $request, Unduhan $unduhan)
    {
        $this->validate($request, [
            'judul' => 'required',
            'keterangan' => 'required',
            'file' => 'file',   // pdf file only
            'batas_tanggal_berlaku' => 'date|date_format:Y/m/d',
        ]);

        // if ($request->hasFile('file')){
        //     $file = file_get_contents($request->file->getRealPath());
        //     $file =base64_encode($file);
        // }
        // else {
        //     $file = null;
        // }
        
        if ($request->hasFile('file')){
            $file = $request->file('file')->store('file_unduhan');
        }
        else {
            $file = null;
        }

        $unduhan = $unduhan->create([
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'file' => $file,
            'batas_tanggal_berlaku' => $request->batas_tanggal_berlaku,
        ]);

        $response = fractal()
        ->item($unduhan)
        ->transformWith(new UnduhanTransformer)
        ->toArray();
                    
        return response()->json($response, 201);

    }

    public function read(Unduhan $unduhan)
    {
        $current = Carbon::now()->format('Y-m-d');

        $unduhan = $unduhan->where('batas_tanggal_berlaku', '>=', $current)->get(); 

        return fractal()
            ->collection($unduhan)
            ->transformWith(new UnduhanTransformer)
            ->toArray();
    }

    public function readbyId(Unduhan $unduhan, $id)
    {
        $unduhan = $unduhan->find($id);
        
        if ($unduhan == null) {
            return response()->json(['error' => 'unduhan tidak ditemukan'], 401);
        }

        $current = Carbon::now()->format('Y-m-d');

        if ($unduhan->batas_tanggal_berlaku < $current) {
            return response()->json(['error' => 'unduhan sudah kadaluarsa'], 401);
        }

        return fractal()
            ->item($unduhan)
            ->transformWith(new UnduhanTransformer)
            ->toArray();
    }


    public function download(Unduhan $unduhan, $id)
    {       
        $unduhan = $unduhan->find($id);

        if($unduhan == null)
        {
            return response()->json(['error' => 'file tidak ditemukan']);
        }

        $current = Carbon::now()->format('Y-m-d');

        if ($unduhan->batas_tanggal_berlaku < $current) 
        {
            return response()->json(['error' => 'file sudah kadaluarsa'], 401);
        }

        // $pathToFile = $unduhan->file;

        $file = $unduhan->file;

        $decoded = base64_decode($file);
        $file = $unduhan->judul.'.pdf';
        file_put_contents($file, $decoded);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }

        // return response()->download('storage/'.$pathToFile);
        // download('storage/'.$pathToFile, $nama_file);

    }

    public function update(Request $request, Unduhan $unduhan, $id)
    {
        $unduhan = $unduhan->find($id);

        $unduhan->judul = $request->get('judul', $unduhan->judul);
        $unduhan->keterangan = $request->get('keterangan', $unduhan->keterangan);
        $unduhan->batas_tanggal_berlaku = $request->get('batas_tanggal_berlaku', $unduhan->batas_tanggal_berlaku);

        if ($request->hasFile('file')){
            $fileupdate = $request->file('file')->store('file_unduhan');
        }
        else {
            $fileupdate = $unduhan->file;
        }

        $unduhan->file = $fileupdate;
              
        $unduhan->save();

        return fractal()
            ->item($unduhan)
            ->transformWith(new UnduhanTransformer)
            ->toArray();

    }

    public function delete(Unduhan $unduhan, $id)
    {
        $unduhan = $unduhan->find($id);

        if($unduhan == null)
        {
            return response()->json(['error' => 'file tidak ditemukan']);
        }
        
        Storage::delete($unduhan->file);
        
        $unduhan->delete();

        return response()->json([
            'message' => 'data sudah terhapus',
        ]);
    }

}
