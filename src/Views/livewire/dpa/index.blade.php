<div class="main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="mb-3">
                        <tr>
                            <td>
                                <i class="fas fa-circle fa-fw text-form-program"></i>
                            </td>
                            <td>:</td>
                            <td>
                                <i>
                                    Form Penginputan Program (Klik Tombol + di samping kanan tulisan AKSI untuk
                                    menampilkan form)
                                </i>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fas fa-circle fa-fw text-form-indikator-program"></i>
                            </td>
                            <td>:</td>
                            <td>
                                <i>
                                    Form Penginputan indikator Program (Klik Tombol + di baris data Program dan di
                                    samping tombol
                                    aksi program)
                                </i>
                            </td>
                        </tr>
                    </table>
                    <table class="table custom-bordered-table">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">KODE <small class="text-danger">*</small></th>
                                <th>PROGRAM <small class="text-danger">*</small></th>
                                <th class="text-center">TARGET <small class="text-danger">*</small></th>
                                <th>PENANGGUNG JAWAB <small class="text-danger">*</small></th>
                                <th>PAGU</th>
                                <th>
                                    AKSI
                                </th>
                                <th class="text-center">
                                    <button class="btn btn-success btn-icon btn-sm" data-toggle="collapse"
                                        href="#collapse-program" role="button" aria-expanded="false"
                                        aria-controls="collapse-program">
                                        <i class="fas fa-plus fa-fw"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-form-program collapse" id="collapse-program" wire:ignore>
                                <td class="p-1">
                                    <input type="text" placeholder="KODE"
                                        class="form-control @error('kode') is-invalid @enderror" wire:model="kode"
                                        wire:keydown.enter='storeProgram()'>

                                    @error('kode')
                                        <span class="text-danger">
                                            Mohon isi Kode Program
                                        </span>
                                    @enderror
                                </td>
                                <td class="p-1">
                                    <input type="text" placeholder="PROGRAM"
                                        class="form-control @error('program') is-invalid @enderror" wire:model='program'
                                        wire:keydown.enter='storeProgram()'>

                                    @error('program')
                                        <span class="text-danger">
                                            Mohon isi Nama Program
                                        </span>
                                    @enderror
                                </td>
                                <td class="p-1">
                                    <div class="input-group m-0">
                                        <input type="text" placeholder="TARGET"
                                            class="form-control @error('target') is-invalid @enderror"
                                            wire:model='target' pattern="\d+" title="Input harus berupa angka"
                                            wire:keydown.enter='storeProgram()'>

                                        @error('target')
                                            <span class="text-danger">
                                                Mohon isi Nama Target
                                            </span>
                                        @enderror
                                        /
                                        <input type="text" placeholder="SATUAN"
                                            class="form-control @error('satuan') is-invalid @enderror"
                                            wire:model='satuan' wire:keydown.enter='storeProgram()'>

                                        @error('satuan')
                                            <span class="text-danger">
                                                Mohon isi Nama Satuan
                                            </span>
                                        @enderror
                                    </div>
                                </td>
                                <td class="p-1">
                                    <select class="form-control @error('pegawai_id') is-invalid @enderror"
                                        wire:model="pegawai_id" style="width: 100% !important;"
                                        wire:keydown.enter='storeProgram()'>
                                        <option value="">PENANGGUNG JAWAB</option>
                                        @forelse ($pegawais as $pegawai)
                                            <option value="{{ $pegawai->uuid }}">{{ $pegawai->nama }}</option>
                                        @empty
                                            <option value="">Kosong</option>
                                        @endforelse
                                    </select>
                                    @error('pegawai_id')
                                        <span class="text-danger">
                                            Mohon isi Penanggung Jawab
                                        </span>
                                    @enderror
                                </td>
                                <td class="p-1"></td>
                                <td class="p-1">
                                    <div class="list-actions d-flex justify-content-around form-inline">
                                        <button class="btn btn-info btn-icon" wire:click='storeProgram()'>
                                            <i class="ik ik-save"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="p-1"></td>
                            </tr>
                            @forelse ($programs as $program)
                                <tr>
                                    <td class="p-1">
                                        <input type="text" value="{{ $program->kode }}"
                                            wire:blur="updateProgram('{{ $program->uuid }}', 'kode', $event.target.value)"
                                            wire:keydown.enter="updateProgram('{{ $program->uuid }}', 'kode', $event.target.value)"
                                            class="form-control">
                                    </td>
                                    <td class="p-1">
                                        <textarea type="text" value="{{ $program->title }}"
                                            wire:blur="updateProgram('{{ $program->uuid }}', 'title', $event.target.value)"
                                            wire:keydown.enter="updateProgram('{{ $program->uuid }}', 'title', $event.target.value)" class="form-control"
                                            rows="3">{{ $program->title }}</textarea>
                                    </td>
                                    <td class="p-1 text-center">
                                        <div class="input-group m-0">
                                            <input type="text" value="{{ $program->target }}"
                                                wire:blur="updateProgram('{{ $program->uuid }}', 'target', $event.target.value)"
                                                wire:keydown.enter="updateProgram('{{ $program->uuid }}', 'target', $event.target.value)"
                                                class="form-control col-3">
                                            <span class="btn btn-transparent">
                                                /
                                            </span>
                                            <input type="text" value="{{ $program->satuan }}"
                                                wire:blur="updateProgram('{{ $program->uuid }}', 'satuan', $event.target.value)"
                                                wire:keydown.enter="updateProgram('{{ $program->uuid }}', 'satuan', $event.target.value)"
                                                class="form-control col-9">
                                        </div>
                                    </td>
                                    <td class="p-1">
                                        <select
                                            wire:change="updateProgram('{{ $program->uuid }}', 'pegawai_id', $event.target.value)"
                                            class="form-control" style="width: 100% !important;">
                                            <option value="">PENANGGUNG JAWAB</option>
                                            @forelse ($pegawais as $pegawai)
                                                <option value="{{ $pegawai->uuid }}"
                                                    {{ $pegawai->id == $program->pegawai_id ? 'selected' : '' }}>
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
                                            foreach ($program->kegiatan as $keg) {
                                                foreach ($keg->subkegiatan as $sub) {
                                                    $pagu_validasi += $sub->pagu;
                                                }
                                            }
                                        @endphp

                                        {{ $pagu_validasi }}
                                    </td>
                                    <td class="p-1 text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('dpa.kegiatan', $program->uuid) }}"
                                                class="btn btn-info btn-icon mr-2">
                                                <i class="ik ik-corner-down-right"></i>
                                            </a>
                                            @if ($program->kegiatan->count() == 0)
                                                <button class="btn btn-danger btn-icon "
                                                    wire:confirm='Ingin menghapus Program ini?'
                                                    wire:click='destroyProgram("{{ $program->uuid }}")'><i
                                                        class="ik ik-trash-2"></i></button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-1 text-center">
                                        <button class="btn btn-success btn-icon btn-sm" data-toggle="collapse"
                                            href="#collapse-{{ $program->uuid }}-indikator" role="button"
                                            aria-expanded="false"
                                            aria-controls="collapse-{{ $program->uuid }}-indikator">
                                            <i class="fas fa-plus fa-fw"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="">
                                    <td class="text-center" colspan="7">Program Masih Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
