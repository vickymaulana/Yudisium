<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data['mahasiswa'] = mahasiswa::where('id_batch', 'like', "%{$search}%")->get();
        } else {
            $data['mahasiswa'] = mahasiswa::all();
        }
        return view('layouts.mahasiswa.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.mahasiswa.create');
    }


    public function verifikasi(Request $request)
    {
        $search = $request->get('search');
        
        $query = mahasiswa::query();
        
        if ($search) {
            $query->where('nim_mhs', 'like', "%{$search}%")
                  ->orWhere('nama_mhs', 'like', "%{$search}%");
        }
        
        $data['mahasiswa'] = $query->get();
        
        return view('layouts.mahasiswa.verifikasi', $data);
    }
    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_batch' => 'required',
            'nim_mhs' => 'required',
            'nama_mhs' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'ipk' => 'required',
            'jml_smstr_aktif' => 'required',
            'jml_cuti' => 'required',
            'kode_prodi' => 'required',
            'nama_prodi' => 'required',
        ]);

        $mahasiswa = new mahasiswa();
        $mahasiswa->id_batch = $request->id_batch;
        $mahasiswa->nim_mhs = $request->nim_mhs;
        $mahasiswa->nama_mhs = $request->nama_mhs;
        $mahasiswa->tempat_lahir = $request->tempat_lahir;
        $mahasiswa->tgl_lahir = $request->tgl_lahir;
        $mahasiswa->ipk = $request->ipk;
        $mahasiswa->jml_smstr_aktif = $request->jml_smstr_aktif;
        $mahasiswa->jml_cuti = $request->jml_cuti;
        $mahasiswa->kode_prodi = $request->kode_prodi;
        $mahasiswa->nama_prodi = $request->nama_prodi;
        if ($mahasiswa->save()) {
            return redirect()->route('mahasiswa.index')->with('message', 'Data Mahasiswa Berhasil Dibuat.');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambah Data Mahasiswa.');
        }
        return redirect()->route('mahasiswa.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $mahasiswa = mahasiswa::find($id);

        return view('layouts.mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = mahasiswa::find($id);
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Batch tidak ditemukan');
        }

        try {
            $validatedData = $request->validate([
                'id_batch' => 'required',
                'nim_mhs' => 'required',
                'nama_mhs' => 'required',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'ipk' => 'required',
                'jml_smstr_aktif' => 'required',
                'jml_cuti' => 'required',
                'kode_prodi' => 'required',
                'nama_prodi' => 'required',
            ]);
            $mahasiswa->id_batch = $request->id_batch;
            $mahasiswa->nim_mhs = $request->nim_mhs;
            $mahasiswa->nama_mhs = $request->nama_mhs;
            $mahasiswa->tempat_lahir = $request->tempat_lahir;
            $mahasiswa->tgl_lahir = $request->tgl_lahir;
            $mahasiswa->ipk = $request->ipk;
            $mahasiswa->jml_smstr_aktif = $request->jml_smstr_aktif;
            $mahasiswa->jml_cuti = $request->jml_cuti;
            $mahasiswa->kode_prodi = $request->kode_prodi;
            $mahasiswa->nama_prodi = $request->nama_prodi;
            $mahasiswa->save();

            return redirect()->route('mahasiswa.index')->with('message', 'Edit Mahasiswa Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Edit Mahasiswa Gagal');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mahasiswa = mahasiswa::find($id);
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan');
        }

        try {
            $mahasiswa->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Delete Mahasiswa gagal');
        }

        session()->flash('message', 'Delete Mahasiswa berhasil');
        return redirect()->route('mahasiswa.index');
    }
}
