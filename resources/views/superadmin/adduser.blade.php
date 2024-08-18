@extends('superadmin.index')

@section('content')
  <div class="card">
    <div class="card-header">
      Tambah Pengguna
    </div>
    <div class="card-body">
      <form method="POST" action="{{route('process.admin.add_user')}}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname">Nama Depan</label>
                    <input name="firstname" type="text" class="form-control" id="firstname" placeholder="Nama Depan">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">Nama Belakang</label>
                    <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Nama Belakang (Optional)">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_num">Nomor Identitas</label>
                    <input name="id_num" type="text" class="form-control" id="id_num" placeholder="Nomor Identitas">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="level">Level</label>
                    <select name="level" class="form-control">
                        <option value="#" selected>Pilih Level</option>
                        <option value="user">User</option>
                        <option value="superadmin">Super Admin</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Kata Sandi">
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
@endsection