@extends('adminlte::layouts.app')
@section('contentheader_title')
	Relatório de Despesas
@endsection
@section('main-content')
 	 <br><br>
 	<div class="box box-primary">
 		<div class="box-header">
            <form action="{{route('costLaunches.search')}}" method="POST" class="form form-inline">
                {!! csrf_field() !!}
                <input type="text" name="income_id" class="form-control" placeholder="Id Serviços">
				<label for="date_init">Data Inicial</label>                
                <input type="date" name="date_init" class="form-control">
                <label for="date_end">Data Final</label>
                <input type="date" name="date_end" class="form-control">
                <select name="employee_id" class="form-control">
                    <option value="">-- Funcionário --</option>
                    @foreach($employee_list as $employee)
                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                    @endforeach
                </select>                

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>

 		<div class="row">
 			<div class="col-sm-12">
 				<div class="box-body">
 					<table class="table table-hover table-condensed"
						style="width:100%" id="employees-table">
					 	<thead>
					 		<tr>
					 			<th>ID</th>
					 			<th>Descrição</th>
					 			<th>Data</th>
					 			<th>Funcionário</th>
					 			<th>Valor</th>
					 			<th>Observação</th>
					 		</tr>
					 	</thead>
					 	@foreach($historics as $costLaunche)
					 	<tbody>
					 		<tr>
					 			<td>{{ $costLaunche->id }}</td>
					 			<td>{{ $costLaunche->cost->name }}</td>
					 			<td>{{ $costLaunche->formateddate}}</td>
					 			<td>{{ $costLaunche->employee->name}}</td>
					 			<td>R$ {{ number_format($costLaunche->price, 2, ',','.') }}</td>
					 			<td>{{ $costLaunche->observation}}</td>
					 		</tr>
					 	</tbody>
					 	@endforeach
					 </table>
					  @if(isset($dataForm))
					 	{!! $historics->appends($dataForm)->links() !!}
					 @else
					 	{!! $historics->links() !!}
					 @endif
 				</div>
 			</div>
 		</div>
 	</div>
 @endsection