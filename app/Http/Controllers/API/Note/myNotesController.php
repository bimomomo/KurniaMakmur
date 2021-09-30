<?php

namespace App\Http\Controllers\API\Note;

use App\Http\Controllers\Controller;
use App\Models\Notes\myNotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class myNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $x = myNotes::select(
            'barang.*',
            'barang.uuid as uuidBarang',
            'my_notes.*',
        )
            ->join('barang', 'barang.uuid', 'my_notes.nama_barang')
            ->get();
        if ($x) {
            $pesan = 'oke';
        } else {
            $pesan = 'oke';
        }
        return response()->json(['data' => $x, 'pesan' => $pesan]);
    }

    public function validasi($request)
    {
        return Validator::make($request->all(), [
            'nama_barang' => [
                'required',
            ],
            'judul' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validasi($request);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return myNotes::create([
            'uuid' => Str::uuid(),
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'nama_barang' => $request->nama_barang['uuid'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return myNotes::where('uuid', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validasi($request);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return myNotes::where('uuid', $request->uuid)->update([
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'nama_barang' => $request->nama_barang['uuid'],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return myNotes::where('uuid', $id)->delete();
    }

    //Custom query
    public function deletebanyak($id)
    {
        $mltId = explode(',', $id);
        return myNotes::whereIn('uuid', $mltId)->delete();
    }
}
