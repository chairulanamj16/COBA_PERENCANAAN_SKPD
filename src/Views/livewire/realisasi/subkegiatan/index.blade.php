<div class="card">
    <div class="card-body">
        <x-dpa.subkegiatan.card :kegiatan=$kegiatan></x-dpa.subkegiatan.card>
        <div class="table-responsive">
            <table class="table custom-bordered-table">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">KODE</th>
                        <th>SUB KEGIATAN</th>
                        <th class="text-center">TARGET</th>
                        <th class="text-center">PAGU</th>
                        <th class="text-center">PAGU TERSERAP</th>
                        <th class="text-center">PENANGGUNG JAWAB</th>
                        <th class="text-center">
                            <i class="fas fa-cog fa-fw"><i>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    {{-- data --}}
                    @forelse ($subkegiatans as $subkegiatan)
                        <tr style="background-color: #FFD966">
                            <th>
                                {{ $subkegiatan->kode }}
                            </th>
                            <th class="col-2">
                                {{ $subkegiatan->title }}
                            </th>
                            <th class="text-center">
                                {{ $subkegiatan->target . ' ' . $subkegiatan->satuan }}
                            </th>
                            <th class="text-right">
                                <b>
                                    @currency($subkegiatan->pagu)
                                </b>
                            </th>
                            <th class="text-right">
                                <b
                                    class="{{ $subkegiatan->pagu < $subkegiatan->sumTotal() ? 'text-danger' : 'text-dark' }}">
                                    @currency($subkegiatan->sumTotal())
                                </b>
                            </th>
                            <th class="text-center">
                                {{ $subkegiatan->pegawai->nama }}
                            </th>
                            <th class="text-center p-1">
                                @if (auth()->user()->rule != 'kabid')
                                    @if ($subkegiatan->realisasi_subkegiatan->count() < 4)
                                        <button class="btn btn-sm btn-transparent" data-toggle="collapse"
                                            href="#subkegiatan-{{ $subkegiatan->uuid }}" role="button"
                                            aria-expanded="false" aria-controls="subkegiatan-{{ $subkegiatan->uuid }}">
                                            <i class="fas fa-plus fa-fw"></i>
                                        </button>
                                    @endif
                                @endif
                            </th>
                        </tr>
                        @if (auth()->user()->rule != 'kabid')
                            @if ($subkegiatan->realisasi_subkegiatan->count() < 4)
                                <x-realisasi.subkegiatan.form :subkegiatan=$subkegiatan></x-realisasi.subkegiatan.form>
                            @endif
                        @endif
                        <x-realisasi.subkegiatan.data :subkegiatan=$subkegiatan></x-realisasi.subkegiatan.data>
                    @empty <tr class="">
                            <td class="text-center" colspan="7">Sub Kegiatan Masih Kosong, Mohon Tambahkan dimenu DPA
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
