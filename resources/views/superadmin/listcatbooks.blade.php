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
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>ISBN</th>
                    <th>Tanggal Terbit</th>
                    <th>Jumlah Peminjaman</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $b)
                    <tr>
                        <td>{{$b->title}}</td>
                        <td>{{$b->author}}</td>
                        <td>{{$b->publisher}}</td>
                        <td>{{$b->isbn}}</td>
                        <td>{{$b->release_date}}</td>
                        <td>{{$b->total}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{$books->links()}}
        </div>
    </div>
  </div>
@endsection