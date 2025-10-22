<x-layouts.app title="Tambah Obat">
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h1 class="mb-4">Tambah Obat</h1>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('obat.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama_obat" class="form-label">Nama Obat <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_obat" class="form-control"
                                            id="nama_obat" value="{{ old('nama_obat') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="kemasan" class="form-label">Kemasan</label>
                                        <input type="text" name="kemasan" id="kemasan"
                                            class="form-control" placeholder="Contoh: Strip, Botol, Tube">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                                <input type="number" name="harga" id="harga"
                                    class="form-control" min="0" step="1" required>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('obat.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
