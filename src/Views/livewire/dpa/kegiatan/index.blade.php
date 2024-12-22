<div class="card">
    <div class="card-body">
        <x-dpa.kegiatan.card :program=$program></x-dpa.kegiatan.card>
        <div class="table-responsive">
            <table class="mb-3">
                <tr>
                    <td>
                        <i class="fas fa-circle fa-fw text-form-kegiatan"></i>
                    </td>
                    <td>:</td>
                    <td>
                        <i>
                            Form Penginputan Kegiatan (Klik Tombol + di samping kanan tulisan AKSI untuk menampilkan
                            form)
                        </i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="fas fa-circle fa-fw text-form-indikator-kegiatan"></i>
                    </td>
                    <td>:</td>
                    <td>
                        <i>
                            Form Penginputan indikator Kegiatan (Klik Tombol + di baris data Kegiatan dan di samping
                            tombol
                            aksi kegiatan)
                        </i>
                    </td>
                </tr>
            </table>
            <table class="table custom-bordered-table">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">KODE <small class="text-danger">*</small></th>
                        <th>KEGIATAN <small class="text-danger">*</small></th>
                        <th class="text-center">TARGET <small class="text-danger">*</small></th>
                        <th>PENANGGUNG JAWAB <small class="text-danger">*</small></th>
                        <th>PAGU</th>
                        <th class="text-center">AKSI</th>
                        <th class="text-center">
                            <button class="btn btn-success btn-icon btn-sm" data-toggle="collapse"
                                href="#collapse-kegiatan" role="button" aria-expanded="false"
                                aria-controls="collapse-kegiatan">
                                <i class="fas fa-plus fa-fw"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <x-dpa.kegiatan.form :pegawais=$pegawais></x-dpa.kegiatan.form>
                    @forelse ($kegiatans as $kegiatan)
                        <tr class="bg-light">
                            <td class="p-1">
                                <input type="text" value="{{ $kegiatan->kode }}"
                                    wire:blur="updateKegiatan('{{ $kegiatan->uuid }}', 'kode', $event.target.value)"
                                    wire:keydown.enter="updateKegiatan('{{ $kegiatan->uuid }}', 'kode', $event.target.value)"
                                    class="form-control ">
                            </td>
                            <td class="p-1">
                                <textarea type="text" value="{{ $kegiatan->title }}"
                                    wire:blur="updateKegiatan('{{ $kegiatan->uuid }}', 'title', $event.target.value)"
                                    wire:keydown.enter="updateKegiatan('{{ $kegiatan->uuid }}', 'title', $event.target.value)" class="form-control "
                                    rows="3">{{ $kegiatan->title }}</textarea>
                            </td>
                            <td class="p-1 col-2">
                                <div class="input-group mb-0">
                                    <input type="text" value="{{ $kegiatan->target }}"
                                        wire:blur="updateKegiatan('{{ $kegiatan->uuid }}', 'target', $event.target.value)"
                                        wire:keydown.enter="updateKegiatan('{{ $kegiatan->uuid }}', 'target', $event.target.value)"
                                        class="form-control col-3">
                                    <div class="btn btn-transparent">
                                        /
                                    </div>
                                    <input type="text" value="{{ $kegiatan->satuan }}"
                                        wire:blur="updateKegiatan('{{ $kegiatan->uuid }}', 'satuan', $event.target.value)"
                                        wire:keydown.enter="updateKegiatan('{{ $kegiatan->uuid }}', 'satuan', $event.target.value)"
                                        class="form-control col-9">
                                </div>
                            </td>
                            <td class="p-1">
                                <select
                                    wire:change="updateKegiatan('{{ $kegiatan->uuid }}', 'pegawai_id', $event.target.value)"
                                    class="form-control " style="width: 100% !important;">
                                    <option value="">PENANGGUNG JAWAB</option>
                                    @forelse ($pegawais as $pegawai)
                                        <option value="{{ $pegawai->uuid }}"
                                            {{ $pegawai->id == $kegiatan->pegawai_id ? 'selected' : '' }}>
                                            {{ $pegawai->nama }}
                                        </option>
                                    @empty
                                        <option value="">Kosong</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="p-1 text-right">
                                @php
                                    $pagu_validasi = 0;
                                    foreach ($kegiatan->subkegiatan as $sub) {
                                        $pagu_validasi += $sub->pagu;
                                    }
                                @endphp
                                @currency($pagu_validasi)
                            </td>
                            <td class="p-1 text-center">
                                <div class="btn-group">
                                    <a href="{{ route('subkegiatan.index', ['uuid' => $kegiatan->uuid]) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                    @if ($kegiatan->subkegiatan->count() == 0)
                                        <button class="btn btn-danger btn-sm ml-2"
                                            wire:confirm='Ingin menghapus Kegiatan ini?'
                                            wire:click.prevent='destroyKegiatan("{{ $kegiatan->uuid }}")'><i
                                                class="fas fa-times fa-fw"></i></button>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-success btn-icon btn-sm" data-toggle="collapse"
                                    href="#collapse-{{ $kegiatan->uuid }}-indikator" role="button"
                                    aria-expanded="false" aria-controls="collapse-{{ $kegiatan->uuid }}-indikator">
                                    <i class="fas fa-plus fa-fw"></i>
                                </button>
                            </td>
                        </tr>
                        <x-dpa.kegiatan.form-indikator :kegiatan=$kegiatan></x-dpa.kegiatan.form-indikator>
                        <x-dpa.kegiatan.indikator :kegiatan=$kegiatan></x-dpa.kegiatan.indikator>
                    @empty
                        <tr class="">
                            <td class="text-center" colspan="7">Kegiatan Masih Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
