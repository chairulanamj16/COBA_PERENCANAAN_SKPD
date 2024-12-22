<div class="card">
    <div class="card-body">
        <x-dpa.kegiatan.card :program=$program></x-dpa.kegiatan.card>
        <div class="table-responsive">
            <table class="table custom-bordered-table">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">KODE</th>
                        <th class="text-center">KEGIATAN</th>
                        <th class="text-center">TARGET</th>
                        <th class="text-center">PAGU</th>
                        <th class="text-center">PAGU TERSERAP</th>
                        <th class="text-center">PENANGGUNG JAWAB</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($kegiatans as $kegiatan)
                        <tr style="background-color: #FFD966">
                            <th>
                                {{ $kegiatan->kode }}
                            </th>
                            <th class="col-2">
                                {{ $kegiatan->title }}
                            </th>
                            <th class="text-center">
                                {{ $kegiatan->target . ' ' . $kegiatan->satuan }}
                            </th>
                            <th class="text-right">
                                <b>
                                    @currency($kegiatan->subkegiatan->sum('pagu'))
                                </b>
                            </th>
                            <th class="text-right">
                                <b
                                    class="{{ $kegiatan->subkegiatan->sum('pagu') < $kegiatan->sumTotal() ? 'text-danger' : 'text-dark' }}">
                                    @currency($kegiatan->sumTotal())
                                </b>
                            </th>
                            <th class="text-center">
                                {{ $kegiatan->pegawai->nama }}
                            </th>
                            <th class="text-center p-1">
                                <div class="btn-group">
                                    <a href="{{ route('r-subkegiatan.index', ['uuid' => $kegiatan->uuid]) }}"
                                        class="btn btn-info btn-sm ml-2 mb-2">
                                        <i class="fas fa-arrow-right fa-fw"></i>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    @if (auth()->user()->rule != 'kabid')
                                        @if ($kegiatan->realisasi_kegiatan->count() < 4)
                                            <button class="btn btn-sm btn-success btn-icon mb-2" data-toggle="collapse"
                                                href="#kegiatan-{{ $kegiatan->uuid }}" role="button"
                                                aria-expanded="false" aria-controls="kegiatan-{{ $kegiatan->uuid }}">
                                                <i class="fas fa-plus fa-fw"></i>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </th>
                        </tr>
                        @if (auth()->user()->rule != 'kabid')
                            @if ($kegiatan->realisasi_kegiatan->count() < 4)
                                <x-realisasi.kegiatan.form :kegiatan=$kegiatan></x-realisasi.kegiatan.form>
                            @endif
                        @endif
                        <x-realisasi.kegiatan.data :kegiatan=$kegiatan></x-realisasi.kegiatan.data>
                    @empty <tr class="">
                            <td class="text-center" colspan="7">Kegiatan Masih Kosong, Mohon Tambahkan dimenu DPA
                            </td>
                        </tr>
                    @endforelse
                    {{-- --}}

                </tbody>
            </table>
        </div>
    </div>
</div>
