@extends('adminlte::layouts.app')
@section('contentheader_title')
	Relatório de Venda de Produtos
@endsection
@section('main-content')

 	 <br><br>
 	<div class="box box-primary">
 		<div class="box-header">
            <form action="{{route('sales.search')}}" method="POST" class="form form-inline">
                {!! csrf_field() !!}
                <input type="text" name="product_id" class="form-control" placeholder="Id Produto">
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