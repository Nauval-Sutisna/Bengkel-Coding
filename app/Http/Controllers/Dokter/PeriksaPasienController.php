<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        $obats = Obat::all();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required|exists:daftar_poli,id',
            'obat_json' => 'nullable|string',
            'biaya_periksa' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $obatIds = json_decode($request->obat_json ?? '[]', true);
                $obatHabis = []; 

                foreach ($obatIds as $idObat) {
                    $obat = Obat::find($idObat);

                    if (!$obat) {
                        throw new \Exception('Data obat tidak ditemukan');
                    }

                    if ($obat->stok < 1) {
                        $obatHabis[] = $obat->nama_obat;
                    }
                }

                if (count($obatHabis) > 0) {
                    throw new \Exception(
                        'Stok obat berikut sudah habis: ' . implode(', ', $obatHabis)
                    );
                }

                $periksa = Periksa::create([
                    'id_daftar_poli' => $request->id_daftar_poli,
                    'tgl_periksa' => now(),
                    'catatan' => $request->catatan,
                    'biaya_periksa' => (int) $request->biaya_periksa + 150000,
                ]);

                foreach ($obatIds as $idObat) {
                    $obat = Obat::find($idObat);

                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $idObat,
                    ]);

                    $obat->decrement('stok');
                }
            });

            return redirect()
                ->route('periksa-pasien.index')
                ->with('success', 'Data Periksa Berhasil Disimpan');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'stok' => $e->getMessage()
                ]);
        }
    }
}
