@extends('superadmin.index')

@section('content')
  <div class="card">
    <div class="card-header">
      List Buku
    </div>
    <div class="card-body">
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Tanggal Dikembalikan</th>
                    <th>Jumlah Hari Keterlambatan</th>
                    <th>Jumlah Denda</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($histories as $h)
                    <tr>
                        <td>{{$h->title}}</td>
                        <td>{{$h->borrowed_at}}</td>
                        <td>{{$h->ended_at}}</td>
                        <td>{{$h->returned_at}}</td>
                        <td>{{$h->overdue}} Hari</td>
                        <td>Rp.{{number_format($h->overdue_cost, 0, "", ".")}}</td>
                        <td>{{$h->status}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{$histories->links()}}
        </div>
    </div>
  </div>
@endsection