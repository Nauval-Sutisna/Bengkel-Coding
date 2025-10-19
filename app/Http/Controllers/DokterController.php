<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua user dengan role dokter, sekaligus relasi ke poli
        $dokters = User::where('role', 'dokter')->with('poli')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $polis = Poli::all();
        return view('admin.dokter.create', compact('polis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Validasi input
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|max:16|unique:users,no_ktp',
            'no_hp' => 'required|string|max:15',
            'id_poli' => 'required|exists:poli,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // ✅ Simpan data ke tabel users
        User::create([
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'no_ktp' => $data['no_ktp'],
            'no_hp' => $data['no_hp'],
            'id_poli' => $data['id_poli'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'dokter',
        ]);

        // ✅ Redirect ke halaman index dokter
        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter berhasil ditambahkan!')
            ->with('type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $dokter)
    {
        $polis = Poli::all();
        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $dokter)
    {
        // ✅ Validasi data update
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|max:16|unique:users,no_ktp,' . $dokter->id,
            'no_hp' => 'required|string|max:15',
            'id_poli' => 'required|exists:poli,id',
            'email' => 'required|email|unique:users,email,' . $dokter->id,
            'password' => 'nullable|string|min:6',
        ]);

        // ✅ Siapkan data update
        $updateData = [
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_ktp' => $validated['no_ktp'],
            'no_hp' => $validated['no_hp'],
            'id_poli' => $validated['id_poli'],
            'email' => $validated['email'],
        ];

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // ✅ Update data dokter
        $dokter->update($updateData);

        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter berhasil diperbarui!')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $dokter)
    {
        $dokter->delete();

        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter berhasil dihapus!')
            ->with('type', 'success');
    }
}
