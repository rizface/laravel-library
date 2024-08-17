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
                    <th>Kategori</th>
                    <th>Jumlah Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $c)
                    <tr>
                        <td class="text-capitalize">{{$c->name}}</td>
                        <td>{{$c->total}}</td>
                        <td>
                            <a href="{{route('page.admin.edit_category', ['id' => $c->id])}}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <a 
                            onclick="return confirm('Apakah kamu yakin ingin menghapus kategori ini ?')"
                            href="{{route('process.admin.delete_category', ['id' => $c->id])}}" class="btn btn-sm btn-outline-danger">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{$categories->links()}}
        </div>
    </div>
  </div>
@endsection