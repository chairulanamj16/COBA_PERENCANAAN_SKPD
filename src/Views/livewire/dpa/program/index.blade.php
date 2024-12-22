<div>
    <x-alert></x-alert>
    <div class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <x-dpa.program.filter></x-dpa.program.filter>
                    <x-dpa.program.card :programs=$programs></x-dpa.program.card>
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
                                <x-dpa.program.form :pegawais=$pegawais></x-dpa.program.form>
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
                                                    class="form-control text-right">
                                                <span class="btn btn-transparent">
                                                    /
                                                </span>
                                                <input type="text" value="{{ $program->satuan }}"
                                                    wire:blur="updateProgram('{{ $program->uuid }}', 'satuan', $event.target.value)"
                                                    wire:keydown.enter="updateProgram('{{ $program->uuid }}', 'satuan', $event.target.value)"
                                                    class="form-control">
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
                                        <td class=" text-right">
                                            @php
                                                $pagu_validasi = 0;
                                                foreach ($program->kegiatan as $keg) {
                                                    foreach ($keg->subkegiatan as $sub) {
                                                        $pagu_validasi += $sub->pagu;
                                                    }
                                                }
                                            @endphp

                                            @currency($pagu_validasi)
                                        </td>
                                        <td class="p-1 text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('kegiatan.index', ['uuid' => $program->uuid]) }}"
                                                    class="btn btn-info btn-sm mr-2">
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                                @if ($program->kegiatan->count() == 0)
                                                    <button class="btn btn-danger btn-sm"
                                                        wire:confirm='Ingin menghapus Program ini?'
                                                        wire:click='destroyProgram("{{ $program->uuid }}")'><i
                                                            class="fas fa-times fa-fw"></i></button>
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
                                    <tr wire:ignore class="bg-form-indikator-program  collapse"
                                        id="collapse-{{ $program->uuid }}-indikator">
                                        <td></td>
                                        <td colspan="4" class="p-1">
                                            <input type="text" placeholder="INDIKATOR"
                                                class="form-control @error('indikator.{{ $program->uuid }}') is-invalid @enderror"
                                                wire:model="indikator.{{ $program->uuid }}"
                                                wire:keydown.enter='storeIndikator({{ $program }})'>

                                            @error('indikator.{{ $program->uuid }}')
                                                <span class="text-danger">
                                                    Mohon isi Indikator Program
                                                </span>
                                            @enderror
                                        </td>
                                        <td class="p-1">
                                            <div class="list-actions d-flex justify-content-around form-inline">
                                                <button class="btn btn-info btn-sm"
                                                    wire:click='storeIndikator("{{ $program->uuid }}")'>
                                                    <i class="fas fa-save fa-fw"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @foreach ($program->indikator_program as $indikator_program)
                                        <tr>
                                            <td></td>
                                            <td colspan="4" class="p-1">
                                                <input type="text" value="{{ $indikator_program->title }}"
                                                    wire:blur="updateIndikator('{{ $indikator_program->uuid }}', 'title', $event.target.value)"
                                                    wire:keydown.enter="updateIndikator('{{ $indikator_program->uuid }}', 'title', $event.target.value)"
                                                    class="form-control">
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-sm"
                                                    wire:confirm='Ingin menghapus Indikator Program ini?'
                                                    wire:click='destroyIndikator("{{ $indikator_program->uuid }}")'>
                                                    <i class="fas fa-times fa-fw"></i>
                                                </button>
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach

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

</div>
