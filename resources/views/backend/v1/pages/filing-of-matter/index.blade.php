@extends('backend.v1.template.index')

@section('title', 'Data Jenis Perkara')
@push('after-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush
@push('after-js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        $('.summernote').summernote({
            height: 250,
            placeholder: 'Tulis Keterangan di sini...'
        });
        $('.btn-edit').on('click', function() {
            const name = $(this).data('name');
            const name_rek = $(this).data('name_rek');
            const rek = $(this).data('rek');
            const price = $(this).data('price');
            const description = $(this).data('description');
            const icon = $(this).data('icon');
            const url = $(this).data('url');
            console.log(description);

            $('#name').focus();
            $('#name').val(name);
            $('#name_rek').val(name_rek);
            $('#rek').val(rek);
            $('#price').val(price);
            $('#summernote').val(description)
            $('#icon-img').html(`
             <img src="${icon}" class="img-fluid" width="50">
        `)

            $('#method').html(`
        <input type="hidden" name="_method" value="PATCH">
        `);

            $('#form').attr('action', url);
        });
    </script>
@endpush
@section('content')


    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card border-0">
                <div class="card-body">
                    <form id="form" action="{{ route('filing-of-matter.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="method"></div>
                        <div class="form-group">
                            <label for="name" class="form-label">Jenis Perkara</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="price" class="form-label">Biaya</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name_rek" class="form-label">Name Rekening</label>
                            <input type="text" name="name_rek" id="name_rek" value="{{ old('name_rek') }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="rek" class="form-label">No.Rekening</label>
                            <input type="number" name="rek" id="rek" value="{{ old('rek') }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea name="description" id="description" class="summernote">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="icon" class="form-label">Icon</label>
                            <br>
                            <span id="icon-img"></span>
                            <input type="file" name="icon" id="icon" value="{{ old('icon') }}"
                                class="form-control">
                        </div>

                        <button class="btn btn-primary btn-block rounded-pill">
                            Simpan
                        </button>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm datatables rounded">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Perkara</th>
                                    <th>Biaya</th>
                                    <th>Nama Rekening</th>
                                    <th>No.Rekening</th>
                                    <th>Keterangan</th>
                                    <th>Icon</th>
                                    <th>
                                        <span class="text-danger">*</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filingOfMatters as $filingOfMatter)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $filingOfMatter->name }}</td>
                                        <td>Rp. {{ number_format($filingOfMatter->price, 2, ',', '.') }}</td>
                                        <td>{{ $filingOfMatter->name_rek }}</td>
                                        <td>{{ $filingOfMatter->rek }}</td>
                                        <td>{!! $filingOfMatter->description !!}</td>
                                        <td>
                                            <img src="{{ url('storage') . '/' . $filingOfMatter->icon }}"
                                                class="img-fluid" width="60">
                                        </td>
                                        <td>
                                            <form action="{{ route('filing-of-matter.destroy', $filingOfMatter->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn text-danger btn-sm btn-block"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">
                                                    <i class="fas fa-trash"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                            <button class="btn text-primary btn-sm btn-block btn-edit"
                                                data-name="{{ $filingOfMatter->name }}"
                                                data-price="{{ $filingOfMatter->price }}"
                                                data-name_rek="{{ $filingOfMatter->name_rek }}"
                                                data-rek="{{ $filingOfMatter->rek }}"
                                                data-description="{{ $filingOfMatter->description }}"
                                                data-icon="{{ url('storage') . '/' . $filingOfMatter->icon }}"
                                                data-url="{{ route('filing-of-matter.update', $filingOfMatter->id) }}">
                                                <i class="fas fa-edit"></i>
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
