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
                    <th>Nomor Identitas</th>
                    <th>Nama</th>
                    <th>Jumlah Buku Yang Dipinjam Saat Ini</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td class="text-capitalize">{{$u->id_num}}</td>
                        <td>{{$u->FullName()}}</td>
                        <td>{{$u->GetNumOfBorrowedBooks()}}</td>
                        <td>
                            <a href="{{route("page.admin.user_history", ["id" => $u->id])}}" class="btn btn-sm btn-outline-primary">Riwayat</a>
                            <a 
                            onclick="return confirm('Apakah kamu yakin ingin menghapus pengguna ini ?')"
                            href="{{route('process.admin.delete_user', ['id' => $u->id])}}" class="btn btn-sm btn-outline-danger">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{$users->links()}}
        </div>
    </div>
  </div>
@endsection