<div class="card">
    <div class="card-body">
        <x-dpa.subkegiatan.card :kegiatan=$kegiatan></x-dpa.subkegiatan.card>
        <div class="table-responsive">
            <table class="mb-3">
                <tr>
                    <td>
                        <i class="fas fa-circle fa-fw text-form-subkegiatan"></i>
                    </td>
                    <td>:</td>
                    <td>
                        <i>
                            Form Penginputan Sub Kegiatan (Klik Tombol + di samping kanan tulisan AKSI untuk menampilkan
                            form)
                        </i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <i class="fas fa-circle fa-fw text-form-indikator-subkegiatan"></i>
                    </td>
                    <td>:</td>
                    <td>
                        <i>
                            Form Penginputan indikator Sub Kegiatan (Klik Tombol + di baris data Sub Kegiatan dan di
                            samping
                            tombol
                            aksi sub kegiatan)
                        </i>
                    </td>
                </tr>
            </table>
            <table class="table custom-bordered-table">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">KODE <small class="text-danger">*</small></th>
                        <th>SUB KEGIATAN <small class="text-danger">*</small></th>
                        <th class="text-center">TARGET <small class="text-danger">*</small></th>
                        <th>PENANGGUNG JAWAB <small class="text-danger">*</small></th>
                        <th>PAGU <small class="text-danger">*</small></th>
                        <th>AKSI</th>
                        <th class="text-center">
                            <button class="btn btn-success btn-icon btn-sm" data-toggle="collapse"
                                href="#collapse-subkegiatan" role="button" aria-expanded="false"
                                aria-controls="collapse-subkegiatan">
                                <i class="fas fa-plus fa-fw"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <x-dpa.subkegiatan.form :pegawais=$pegawais></x-dpa.subkegiatan.form>
                    @forelse ($subKegiatans as $subkegiatan)
                        <tr class="bg-light">
                            <td class="p-1">
                                <input type="text" value="{{ $subkegiatan->kode }}"
                                    wire:blur="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'kode', $event.target.value)"
                                    wire:keydown.enter="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'kode', $event.target.value)"
                                    class="form-control">
                            </td>
                            <td class="p-1">
                                <textarea type="text" wire:blur="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'title', $event.target.value)"
                                    wire:keydown.enter="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'title', $event.target.value)"
                                    class="form-control" rows="3">{{ $subkegiatan->title }}</textarea>
                            </td>
                            <td class="p-1 col-2">
                                <div class="input-group mb-0">
                                    <input type="text" value="{{ $subkegiatan->target }}"
                                        wire:blur="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'target', $event.target.value)"
                                        wire:keydown.enter="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'target', $event.target.value)"
                                        class="form-control col-3">
                                    <div class="btn btn-transparent">
                                        /
                                    </div>
                                    <input type="text" value="{{ $subkegiatan->satuan }}"
                                        wire:blur="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'satuan', $event.target.value)"
                                        wire:keydown.enter="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'satuan', $event.target.value)"
                                        class="form-control col-9">
                                </div>
                            </td>
                            <td class="p-1">
                                <select
                                    wire:change="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'pegawai_id', $event.target.value)"
                                    class="form-control" style="width: 100% !important;">
                                    <option value="">Pilih</option>
                                    @forelse ($pegawais as $pegawai)
                                        <option value="{{ $pegawai->uuid }}"
                                            {{ $pegawai->id == $subkegiatan->pegawai_id ? 'selected' : '' }}>
                                            {{ $pegawai->nama }}
                                        </option>
                                    @empty
                                        <option value="">Kosong</option>
                                    @endforelse
                                </select>
                            </td>
                            <td class="p-1 text-right">
                                <div class="list-actions d-flex justify-content-start form-inline">
                                    <input type="number" value="{{ $subkegiatan->pagu }}"
                                        wire:blur="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'pagu', $event.target.value)"
                                        wire:keydown.enter="updateSubkegiatan('{{ $subkegiatan->uuid }}', 'pagu', $event.target.value)"
                                        class="form-control">
                                    <span class="ml-2">
                                        <strong>(@currency($subkegiatan->pagu))</strong>
                                    </span>
                                </div>
                            </td>
                            <td class="p-1 text-center">
                                @if ($subkegiatan->realisasi_subkegiatan->count() == 0)
                                    <button class="btn btn-danger btn-sm"
                                        wire:confirm='Ingin menghapus Sub Kegiatan ini?'
                                        wire:click.prevent='destroySubkegiatan("{{ $subkegiatan->uuid }}")'><i
                                            class="fas fa-times fa-fw"></i></button>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-success btn-icon btn-sm" data-toggle="collapse"
                                    href="#collapse-{{ $subkegiatan->uuid }}-indikator" role="button"
                                    aria-expanded="false" aria-controls="collapse-{{ $subkegiatan->uuid }}-indikator">
                                    <i class="fas fa-plus fa-fw"></i>
                                </button>
                            </td>
                        </tr>
                        <x-dpa.subkegiatan.form-indikator :subkegiatan=$subkegiatan></x-dpa.subkegiatan.form-indikator>
                        <x-dpa.subkegiatan.indikator :subkegiatan=$subkegiatan></x-dpa.subkegiatan.indikator>
                    @empty
                        <tr class="">
                            <td class="text-center" colspan="7">Sub Kegiatan Masih Kosong</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
