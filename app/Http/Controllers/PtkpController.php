<?php

namespace App\Http\Controllers;

use App\Models\Ptkp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PtkpController extends Controller
{
    public function index()
    {
        $data = Ptkp::paginate(10);
        return view('superadmin.ptkp.index', compact('data'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        
        if ($keyword) {
            $data = Ptkp::where('nip', 'like', '%' . $keyword . '%')
                        ->orWhere('nama', 'like', '%' . $keyword . '%')
                        ->get();
        } else {
            $data = Ptkp::all();
        }
        
        return response()->json(['data' => $data]);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal! Pastikan file yang diunggah sesuai format.');
            return redirect()->back();
        }

        try {
            Excel::import(new \App\Imports\PtkpImport(), $request->file('file'));
            Session::flash('success', 'Data PTKP berhasil diimport!');
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal mengimport data: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('superadmin.ptkp.create');
    }

    public function store(Request $req)
    {
        $check = Ptkp::where('nip', $req->nip)->first();
        if ($check == null) {
            $new = new Ptkp();
            $new->nip = $req->nip;
            $new->nama = $req->nama;
            $new->ptkp = $req->ptkp;
            $new->save();
            Session::flash('success', 'Berhasil menambahkan data PTKP');
            return redirect('/superadmin/ptkp');
        } else {
            $req->flash();
            Session::flash('warning', 'NIP sudah ada');
            return back();
        }
    }

    public function edit($id)
    {
        $data = Ptkp::find($id);
        return view('superadmin.ptkp.edit', compact('data'));
    }

    public function update(Request $req, $id)
    {
        $data = Ptkp::find($id);
        $data->nip = $req->nip;
        $data->nama = $req->nama;
        $data->ptkp = $req->ptkp;
        $data->save();
        Session::flash('success', 'Berhasil mengupdate data PTKP');
        return redirect('/superadmin/ptkp');
    }

    public function delete($id)
    {
        Ptkp::find($id)->delete();
        Session::flash('success', 'Berhasil menghapus data PTKP');
        return redirect('/superadmin/ptkp');
    }
}