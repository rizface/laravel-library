@extends('superadmin.index')

@push('css')
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@section('content')
  <div class="card">
    <div class="card-header">
      Tambah Kategori Buku
    </div>
    <div class="card-body">
      <form method="POST" action="{{route('process.admin.add_category')}}">
        @csrf
        <div class="form-group">
          <label for="category">Kategori</label>
          <input name="category" type="text" class="form-control" id="category" placeholder="Kategori">
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
@endsection