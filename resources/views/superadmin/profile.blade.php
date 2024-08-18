@extends('superadmin.index')

@section('content')
  <div class="card">
    <div class="card-header">
      Profil
    </div>
    <div class="card-body">
      <form method="POST" action="{{route('process.admin.profile')}}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname">Nama Depan</label>
                    <input
                    value="{{$profile["firstname"]}}"
                    name="firstname" type="text" class="form-control" id="firstname" placeholder="Nama Depan">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">Nama Belakang</label>
                    <input 
                    value="{{$profile["lastname"]}}"
                    name="lastname" type="text" class="form-control" id="lastname" placeholder="Nama Belakang (Optional)">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="id_num">Nomor Identitas</label>
                    <input 
                    value="{{$profile["id_num"]}}"
                    name="id_num" type="text" class="form-control" id="id_num" placeholder="Nomor Identitas">
                </div>
            </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
@endsection