<x-layouts.app>
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h1 class="mb-4">Edit Obat</h1>
                <div class="card">
                    <div class="card-body">
                        {{-- Form update data --}}
                        <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama_obat" class="form-label">Nama Obat 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            id="nama_obat"
                                            name="nama_obat" 
                                            value="{{ old('nama_obat', $obat->nama_obat) }}" 
                                            class="form-control" 
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="kemasan" class="form-label">Kemasan 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            id="kemasan"
                                            name="kemasan" 
                                            value="{{ old('kemasan', $obat->kemasan) }}" 
                                            class="form-control" 
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="harga" class="form-label">Harga 
                                    <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="harga" 
                                    name="harga" 
                                    value="{{ old('harga', $obat->harga) }}" 
                                    class="form-control" 
                                    required 
                                    min="0" 
                                    step="1">
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update
                                </button>
                                <a href="{{ route('obat.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
