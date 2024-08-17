@extends('superadmin.index')

@push('css')
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@section('content')
  <div class="card">
    <div class="card-header">
      Tambah Buku
    </div>
    <div class="card-body">
      <form method="POST" action="{{route('process.admin.edit_book', ["id" => $book->id])}}">
        @csrf
        <div class="form-group">
          <label for="title">Judul</label>
          <input 
          value="{{old('title') ?? $book->title}}"
          name="title" type="text" class="form-control" id="title" placeholder="Judul Buku">
        </div>
        <div class="form-group">
          <label for="qty">Jumlah</label>
          <input 
          value="{{old('qty') ?? $book->qty}}"
          name="qty" type="number" class="form-control" id="number" placeholder="Jumlah Buku">
        </div>
        <div class="form-group">
          <label for="author">Penulis</label>
          <input 
          value="{{old('author') ?? $book->author}}"
          name="author" type="text" class="form-control" id="author" placeholder="Nama Penulis">
        </div>
        <div class="form-group">
          <label for="publisher">Penerbit</label>
          <input 
          value="{{old('publisher') ?? $book->publisher}}"
          name="publisher" type="text" class="form-control" id="publisher" placeholder="Nama Penulis">
        </div>
        <div class="form-group">
          <label for="isbn">ISBN</label>
          <input 
          value="{{old('isbn') ?? $book->isbn}}"
          name="isbn" type="text" class="form-control" id="isbn" placeholder="ISBN">
        </div>
        <div class="form-group">
          <label for="release-date">Tanggal Terbit</label>
          <input 
          value="{{old('release_date') ?? $book->release_date}}"
          name="release_date" type="date" class="form-control" id="release-date">
        </div>
        <div class="form-group">
          <label>Kategori</label>
          <select name="categories[]" class="select2" multiple="multiple" data-placeholder="Pilih Kategori Buku" style="width: 100%;">
            @foreach ($categories as $c)
              <option  {{$book->IsBookCategory($c->id) ? "selected" : ""}} value="{{$c->id}}" class="text-capitalize">{{$c->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <button class="btn btn-sm btn-primary">Edit</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>
@endpush