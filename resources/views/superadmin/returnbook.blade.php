@extends('superadmin.index')

@section('content')
  <div class="card">
    <div class="card-header">
      Pengembalian Buku
    </div>
    <div class="card-body">
      <form method="POST" action="{{route('process.admin.return_book', ["id" => $log->log_id])}}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input
                    disabled 
                    value="{{$log->book_title}}"
                    name="title" type="text" class="form-control" id="title" placeholder="Judul Buku">
                  </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="author">Nama Peminjam</label>
                    <input
                    disabled 
                    value="{{$log->borrower_name}}"
                    name="author" type="text" class="form-control" id="author" placeholder="Nama Penulis">
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="borrowed_at">Tanggal Pinjam</label>
                    <input
                    disabled 
                    value="{{$log->borrowed_at}}"
                    name="borrowed_at" type="date" class="form-control" id="borrowed_at">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ended_at">Tanggal Pengembalian</label>
                    <input
                    disabled 
                    value="{{$log->ended_at}}"
                    name="ended_at" type="date" class="form-control" id="ended_at">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="overdue">Keterlambatan (Hari)</label>
                    <input
                    disabled 
                    value="{{$log->overdue < 0 ? 0 : $log->overdue}}"
                    name="overdue" type="text" class="form-control" id="overdue">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="overdue">Denda Keterlambatan</label>
                    <input
                    disabled 
                    value="{{$log->GetOverdue() * intval($config->cost_overdue_per_day)}}"
                    name="overdue" type="number" class="form-control" id="overdue">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="note">Catatan</label>
            <textarea name="note" class="form-control" id="note" placeholder="Catatan Pengembalian"></textarea>
        </div>

        <div class="form-group">
          <button class="btn btn-sm btn-primary">Kirim</button>
        </div>
      </form>
    </div>
  </div>
@endsection