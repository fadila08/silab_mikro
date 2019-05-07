<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Pengumuman;
use App\Transformers\PengumumanDetailTransformer;
use App\Transformers\PengumumanTransformer;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    public function index(Pengumuman $pengumuman)
    {
        $current = Carbon::now()->format('Y-m-d');

        // if ($pengumuman->batas_tanggal_berlaku >= $current) {
        //     $pengumuman = $pengumuman->get();
        // }


        $pengumuman = $pengumuman->where('batas_tanggal_berlaku', '>=', $current)->get(); 

        return fractal()
            ->collection($pengumuman)
            ->transformWith(new PengumumanTransformer)
            ->toArray();
    }

    public function store(Request $request, Pengumuman $pengumuman)
    {
        $this->validate($request, [
            'judul' => 'required',
            'isi' => 'required',
            'file_lampiran' => 'file',  //pdf file
            'batas_tanggal_berlaku' => 'date',
        ]);

        // if ($request->hasFile('file_lampiran')){
        //     $lampiran = file_get_contents($request->file_lampiran->getRealPath());
        //     $lampiran =base64_encode($lampiran);
        // }
        // else {
        //     $lampiran = null;
        // }
        

        if ($request->hasFile('file_lampiran')){
            $lampiran = $request->file('file_lampiran')->store('lampiran');
        }
        else {
            $lampiran = null;
        }
        
        $filelampiran = $lampiran;

        $pengumuman = $pengumuman->create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'file_lampiran' => $filelampiran,
            'format' => $request->file_lampiran->extension(),
            'batas_tanggal_berlaku' => $request->batas_tanggal_berlaku,
        ]);

        $response = fractal()
        ->item($pengumuman)
        ->transformWith(new PengumumanDetailTransformer)
        ->toArray();
                    
        return response()->json($response, 201);

    }

    public function show(Pengumuman $pengumuman, $id)
    {
        $pengumuman = $pengumuman->find($id);
        
        if ($pengumuman == null) {
            return response()->json(['error' => 'pengumuman tidak ditemukan'], 401);
        }

        $current = Carbon::now()->format('Y-m-d');

        if ($pengumuman->batas_tanggal_berlaku < $current) {
            return response()->json(['error' => 'pengumuman sudah kadaluarsa'], 401);
        }

        return fractal()
            ->item($pengumuman)
            ->transformWith(new PengumumanDetailTransformer)
            ->toArray();
    }

    public function downloadLampiran(Pengumuman $pengumuman, $id)
    {
        $pengumuman = $pengumuman->find($id);

        if($pengumuman == null)
        {
            return response()->json(['error' => 'file lampiran tidak ditemukan']);
        }

        $current = Carbon::now()->format('Y-m-d');

        if ($pengumuman->batas_tanggal_berlaku < $current) {
            return response()->json(['error' => 'file lampiran sudah kadaluarsa'], 401);
        }

        if ($pengumuman->file_lampiran == null)
        {
            return response()->json(['error' => 'file lampiran tidak ditemukan']);
        }

        $file_lampiran = $pengumuman->file_lampiran;

        $decoded = base64_decode($file_lampiran);
        $file = $pengumuman->judul.'.'.$pengumuman->format;
        // file_put_contents($file, $decoded);

        // if (file_exists($file)) {
        //     header('Content-Description: File Transfer');
        //     header('Content-Type: application/octet-stream');
        //     header('Content-Disposition: attachment; filename="'.basename($file).'"');
        //     header('Expires: 0');
        //     header('Cache-Control: must-revalidate');
        //     header('Pragma: public');
        //     header('Content-Length: ' . filesize($file));
        //     readfile($file);
        //     exit;
        // }
        
        return response()->json($file_lampiran);
        

    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $pengumuman->judul = $request->judul;
        $pengumuman->isi = $request->isi;
        $pengumuman->batas_tanggal_berlaku = $request->batas_tanggal_berlaku;

        if ($request->hasFile('file_lampiran')){
             $lampiran = $request->file('file_lampiran')->store('lampiran');
        }
        else {
            $lampiran = $pengumuman->file_lampiran;
        }

        $pengumuman->file_lampiran = $lampiran;
              
        $pengumuman->save();

        return fractal()
            ->item($pengumuman)
            ->transformWith(new PengumumanDetailTransformer)
            ->toArray();

    }

    public function destroy(Pengumuman $pengumuman)
    {
        if($pengumuman == null)
        {
            return response()->json(['error' => 'pengumuman tidak ditemukan']);
        }
        
        Storage::delete($pengumuman->file_lampiran);
        
        $pengumuman->delete();

        return response()->json([
            'message' => 'data sudah terhapus',
        ]);
    }


}