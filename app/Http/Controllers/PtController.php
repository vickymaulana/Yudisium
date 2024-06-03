<?php

namespace App\Http\Controllers;

use App\Models\pt;
use Illuminate\Http\Request;

class PtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $data['data_pt'] = pt::where('kd_pt', 'like', "%{$search}%")->get();
        } else {
            $data['data_pt'] = pt::all();
        }
        return view('layouts.pt.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.pt.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kd_pt' => 'required',
            'nama_pt' => 'required',
        ]);

        try {
            $data_pt = new PtController();
            $data_pt->kd_pt = $request->kd_pt;
            $data_pt->nama_pt = $request->nama_pt;
            $data_pt->save();

            $request->session()->flash('message', 'Data Berhasil Disimpan!');

            return redirect()->route('pt.index');
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Gagal Menambahkan data.');

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(pt $data_pt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $data_pt = pt::find($id);

        return view('layouts.pt.edit', compact('data_pt'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data_pt = pt::find($id);
        if (!$data_pt) {
            return redirect()->back()->with('error', 'PT tidak ditemukan');
        }
    
        try {
            $validatedData = $request->validate([
                'kd_pt' => 'required',
                'nama_pt' => 'required',
            ]);
            $data_pt->kd_pt = $request->kd_pt;
            $data_pt->nama_pt = $request->nama_pt;
            $data_pt->save();
    
            return redirect()->route('pt.index')->with('message', 'Edit Data Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Edit Data Gagal');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data_pt = PT::find($id);
        if (!$data_pt) {
            return redirect()->back()->with('error', 'PT tidak ditemukan');
        }
    
        try {
            $data_pt->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Delete data gagal');
        }
    
        session()->flash('message', 'Delete data berhasil');
        return redirect()->route('pt.index');
    }
}