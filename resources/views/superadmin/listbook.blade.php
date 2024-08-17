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
                    <th>Tersedia</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>ISBN</th>
                    <th>Tanggal Terbit</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $b)
                    <tr>
                        <td>{{$b->title}}</td>
                        <td>{{$b->NumAvailable()}}</td>
                        <td>{{$b->author}}</td>
                        <td>{{$b->publisher}}</td>
                        <td>{{$b->isbn}}</td>
                        <td>{{$b->release_date}}</td>
                        <td>
                            @foreach ($b->categories as $c)
                                <span class="badge badge-primary text-capitalize">{{$c->name}}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{route('page.admin.edit_book', ['id' => $b->id])}}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <a 
                            onclick="return confirm('Apakah kamu yakin ingin menghapus buku ini ?')"
                            href="{{route('process.admin.delete_book', ['id' => $b->id])}}" class="btn btn-sm btn-outline-danger">Hapus</a>
                        </td>
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