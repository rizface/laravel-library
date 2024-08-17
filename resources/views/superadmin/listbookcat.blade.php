@extends('superadmin.index')

@push('css')
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
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

@push('scripts')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>
@endpush