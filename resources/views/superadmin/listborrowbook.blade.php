@extends('superadmin.index')

@section('content')
  <div class="card">
    <div class="card-header">
      Pengembalian Buku
    </div>
    <div class="card-body">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Keterlambatan</th>
                    <th>Jumlah Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $l)
                    <tr class="text-capitalize">
                        <td>{{$l->borrower_name}}</td>
                        <td>{{$l->book_title}}</td>
                        <td>{{$l->borrowed_at}}</td>
                        <td>{{$l->ended_at}}</td>
                        <td>{{$l->overdue < 1 ? 0 : $l->overdue}} Hari</td>
                        <td>1000</td>
                        <td>
                            <a href="{{route('process.admin.return_book', ['id' => $l->log_id])}}" class="btn btn-sm btn-outline-primary">Pengembalian</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{$list->links()}}
        </div>
    </div>
  </div>
@endsection