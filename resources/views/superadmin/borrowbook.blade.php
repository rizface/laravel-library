@extends('superadmin.index')

@push('css')
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@section('content')
  <div class="card">
    <div class="card-header">
      Pinjam Buku
    </div>
    <div class="card-body">
      <form method="POST" action="{{route('process.admin.borrow_book')}}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Judul</label>
                    <select name="book_id" id="title" class="form-control">
                        <option value="" selected disabled>Pilih Buku</option>
                        @foreach ($books as $b)
                        <option value="{{$b->id}}">{{$b->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Peminjam</label>
                    <select name="borrower_id" id="title" class="form-control">
                        <option value="" selected disabled>Pilih Peminjam</option>
                        @foreach ($users as $u)
                        <option value="{{$u->id}}">{{$u->FullName()}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date">Tanggal Pinjam</label>
                    <input type="date" name="start_date" id="start_date" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date">Tanggal Pengembalian</label>
                    <input type="date" name="end_date" id="end_date" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group">
          <button class="btn btn-sm btn-primary">Pinjam</button>
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