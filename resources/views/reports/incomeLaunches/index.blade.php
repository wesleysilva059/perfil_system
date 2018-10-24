@extends('adminlte::layouts.app')
@section('contentheader_title')
	Relatório de Receitas
@endsection
@section('main-content')
	 	 <br><br>
 	<div class="box box-primary">
 		<div class="box-header">
            <form action="{{route('incomeLaunches.search')}}" method="POST" class="form form-inline">
                {!! csrf_field() !!}
                <input type="text" name="description" class="form-control" placeholder="Serviços">
				<label for="date_init">Data Inicial</label>                
                <input type="date" name="date_init" class="form-control">
                <label for="date_end">Data Final</label>
                <input type="date" name="date_end" class="form-control">
                <select name="employee_id" class="form-control">
                    <option value="">-- Funcionário --</option>
                    
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
					 	@foreach($historics as $incomeLaunche)
					 	<tbody>
					 		<tr>
					 			<td>{{ $incomeLaunche->id }}</td>
					 			<td>{{ $incomeLaunche->income->name }}</td>
					 			<td>{{ $incomeLaunche->formateddate}}</td>
					 			<td>{{ $incomeLaunche->employee->name}}</td>
					 			<td>R$ {{ number_format($incomeLaunche->price, 2, ',','.') }}</td>
					 			<td>{{ $incomeLaunche->observation}}</td>
					 		</tr>
					 	</tbody>
					 	@endforeach
					 	<tfoot>
					 	</tfoot>
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