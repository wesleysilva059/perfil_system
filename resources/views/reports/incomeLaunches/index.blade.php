@extends('adminlte::layouts.app')
@section('contentheader_title')
	Relatório de Receitas
@endsection
@section('main-content')
	 	 <br><br>
 	<div class="box box-primary">
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