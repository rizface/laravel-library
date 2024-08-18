@extends('superadmin.index')

@section('content')
  <div class="card">
    <div class="card-header">
      Pengaturan
    </div>
    <div class="card-body">
      <form method="POST" action="{{route('process.admin.config')}}">
        @csrf
        <div class="form-group">
          <label for="overdue_cost">Denda Keterlambatan Per Hari</label>
          <input 
          value="{{intval($config?->cost_overdue_per_day)}}"
          name="overdue_cost" type="number" class="form-control" id="overdue_cost" placeholder="Denda Keterlambatan Per Hari">
        </div>
        <div class="form-group">
          <button class="btn btn-sm btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
@endsection