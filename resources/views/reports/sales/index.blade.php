@extends('adminlte::layouts.app')
@section('contentheader_title')
	Relatório de Venda de Produtos
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
					 			<th>Nome do Produto</th>
					 			<th>Data </th>
					 			<th>Funcionario</th>
					 			<th>Qtd</th>
					 			<th>Valor Unitário</th>
					 			<th>Valor Total</th>
					 			<th>Observações</th>
					 		</tr>
					 	</thead>
					 	@foreach($historics as $sale)
					 	<tbody>
					 		<tr>
					 			<th>{{ $sale->id }}</th>
					 			<th>{{ $sale->product->name }}</th>
					 			<th>{{ $sale->formateddate }}</th>
					 			<th>{{ $sale->employee->name}}</th>
					 			<th>{{ $sale->amount }}</th>
					 			<th>R$ {{ number_format($sale->priceUnit,2, ',','.') }}</th>
					 			<th>R$ {{ number_format($sale->priceTotal, 2, ',','.') }}</th>
					 			<th>{{ $sale->observation }}</th>
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
</script> 
 @endsection