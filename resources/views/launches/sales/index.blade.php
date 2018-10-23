@extends('adminlte::layouts.app')
@section('contentheader_title')
	Venda de Produtos {{ucfirst($month_extense)}}
@endsection
@section('main-content')
 	<div style="float:right;">
 		<a href="#">
 		<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">
 			<i class="fa fa-plus"></i> Cadastrar Venda
 		</button>
		</a>
	</div>
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
					 	@foreach($sales as $sale)
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
					 		<td>
				 				{{ Form::open(array('route' => array('sales.destroy', $sale->id), 'method' => 'delete')) }}
				 				<button type="button" class="btn btn-primary" 
				 					data-myid="{{$sale->id}}"
				 					data-product_id="{{$sale->product->id}}" 
				 					data-name="{{$sale->product->name}}" 
				 					data-mydate="{{$sale->formateddate}}" 
				 					data-employee_id="{{$sale->employee_id}}"
									data-myemployee="{{$sale->employee->name}}"
									data-myamount="{{$sale->amount}}"
				 					data-myprice="{{$sale->priceUnit}}"
				 					data-mypricetotal="{{$sale->priceTotal}}" 
				 					data-myobservation="{{$sale->observation}}"
				 					data-toggle="modal" data-target="#editModal">
										<i class="fa fa-edit"></i>
									</button>
									<button type="submit" class="btn btn-danger">
										<i class="fa fa-trash"></i>
									</button>
								{{ Form::close() }}
					 			</td>
					 		</tr>
					 	</tbody>
					 	@endforeach
					 	<tfoot>
					 		<tr>
					 			<th></th>
					 			<th></th>
					 			<th></th>
					 			<th></th>
					 			<th></th>
					 			<th>Total</th>
					 			<th>R$ {{ number_format($price, 2, ',', '.') }}</th>
					 			<th></th>
					 		</tr>
					 	</tfoot>
					 </table>
 				</div>
 			</div>
 		</div>
 	</div>

	<!-- Modal Insert -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="myModalLabel">Cadastro de Vendas</h4>
		      	</div>
	      		<div class="modal-body">
					<form action="{{ route('sales.store')}}" method="post">
					{{csrf_field()}}	  
					<hr />	  
						<div class="row">	    
							<div class="form-group col-md-3">	      
								<label for="name">Codigo</label>	      
								<input type="number" class="form-control" id="product_id" name="product_id" value="{{old('name')}}" required>
							</div>
							<div class="form-group col-md-9">	      
								<label for="campo1">Descrição</label>	      
								<input type="text" class="form-control" id="name" name="name" value="{{old('price')}}" required>
							</div>
						</div>		  
						<div class="row">	    
						   	<div class="form-group col-md-6">	      
								<label for="date">Data</label>	      
								<input type="date" class="form-control" id="date" name="date" value="{{$today or old('date')}}" required>
							</div>
							<div class="form-group col-md-6">	      
								<label for="employee_id">Funcionario</label>	      
								<select name="employee_id" class="form-control" id="employee_id" required>
									<option value="">Selecione o funcionário</option>
									@foreach($employee_list as $e)
										<option value="{{$e->id}}">{{$e->name}}</option>
									@endforeach
								</select>
							</div>	
						</div>
						<div class="row">	    
						   	<div class="form-group col-md-4">	      
								<label for="campo1">Quantidade</label>	      
								<input type="number" class="form-control" id="amount" name="amount" value="{{old('amount')}}" required>
							</div>
							<div class="form-group col-md-4">	      
								<label for="campo1">Valor Unitario</label>	      
								<input type="number" class="form-control" id="priceUnit" name="priceUnit" value="{{old('priceUnit')}}" required>
							</div>
						   	<div class="form-group col-md-4">	      
								<label for="campo1">Valor Total</label>	      
								<input type="number" class="form-control" id="priceTotal" name="priceTotal" value="{{old('priceTotal')}}" required>
							</div>	
						</div>
						<div class="row">	    
						   	<div class="form-group col-md-12">	      
								<label for="campo1">Observação</label>	      
								<input type="text" class="form-control" id="observation" name="observation" value="{{old('price')}}">
							</div>	
						</div>							
						<div class="row">
					    	<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					    	<button type="submit" class="btn btn-primary">Gravar</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Update -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="myModalLabel">Editar Venda</h4>
		      	</div>
	      		<div class="modal-body">
					<form action="{{ route('sales.update', 'test')}}" method="post">
					{{method_field('patch')}}
					{{csrf_field()}}
					<input type="hidden" id="id" name="id" value="">
						<div class="row">	    
							<div class="form-group col-md-3">	      
								<label for="name">Codigo</label>	      
								<input type="number" class="form-control" id="product_id" name="product_id" value="{{old('name')}}" required>
							</div>
							<div class="form-group col-md-9">	      
								<label for="campo1">Descrição</label>	      
								<input type="text" class="form-control" id="name" name="name" value="{{old('price')}}">
							</div>
						</div>		  
						<div class="row">	    
						   	<div class="form-group col-md-6">	      
								<label for="date">Data</label>	      
								<input type="date" class="form-control" id="date" name="date" value="{{$today or old('date')}}">
							</div>
							<div class="form-group col-md-6">	      
								<label for="employee_id">Funcionario</label>	      
								<select name="employee_id" class="form-control" id="employee_id">
									<option value="">Selecione o funcionário</option>
									@foreach($employee_list as $e)
										<option value="{{$e->id}}">{{$e->name}}</option>
									@endforeach
								</select>
							</div>	
						</div>
						<div class="row">	    
						   	<div class="form-group col-md-4">	      
								<label for="campo1">Quantidade</label>	      
								<input type="number" class="form-control" id="amount2" name="amount" value="{{old('amount')}}" >
							</div>
							<div class="form-group col-md-4">	      
								<label for="campo1">Valor Unitario</label>	      
								<input type="number" class="form-control" id="priceUnit2" name="priceUnit" value="{{old('priceUnit')}}">
							</div>
						   	<div class="form-group col-md-4">	      
								<label for="campo1">Valor Total</label>	      
								<input type="number" class="form-control" id="priceTotal2" name="priceTotal" value="{{old('priceTotal')}}">
							</div>	
						</div>
						<div class="row">	    
						   	<div class="form-group col-md-12">	      
								<label for="campo1">Observação</label>	      
								<input type="text" class="form-control" id="observation" name="observation" value="{{old('price')}}">
							</div>	
						</div>							
						<div class="row">
					    	<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					    	<button type="submit" class="btn btn-primary">Gravar</button>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>	


<script type='text/javascript'>
	
	  $('#editModal').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget) 
      var id = button.data('myid')
      var product_id = button.data('product_id')
      var name = button.data('name') 
      var datee = button.data('mydate').split("/") 
      var date2 = datee[2]+'-'+datee[1]+'-'+datee[0]
      var employee_id = button.data('employee_id')
      var employee = button.data('myemployee')
      var amount = button.data('myamount')
      var price = button.data('myprice')
      var priceTotal = button.data('mypricetotal')
      var observation = button.data('myobservation') 
      var modal = $(this)

      modal.find('.modal-body #product_id').val(product_id);
      modal.find('.modal-body #name').val(name);
      modal.find('.modal-body #date').val(date2);
      modal.find('.modal-body #id').val(id);
      modal.find('.modal-body #amount2').val(amount);
      modal.find('.modal-body #priceUnit2').val(price);
      modal.find('.modal-body #priceTotal2').val(priceTotal);
      modal.find('.modal-body #employee_id').val(employee_id);
      modal.find('.modal-body #observation').val(observation);
	})

	$('#price').priceFormat({
	    prefix: '',
	    centsSeparator: '.',
	    thousandsSeparator: ''
	});

	$(document).ready(function(){
		$("input[name='product_id']").blur(function(){
			var product_id = $(this).val();
			var description = $("input[name='name']");
			var priceUnit = $("input[name='priceUnit']");
			$.getJSON('/get-product/' + product_id, function( product ){
				description.val( product.name );
				priceUnit.val(product.price);
			});
		});
	});

	$(document).ready(function() {

	 $("#amount").blur(function() {
	   var qtd = $(this).val();
	   var valor = $("#priceUnit").val();
	   var calculo = qtd * valor;
	   $("#priceTotal").val(calculo);
	   console.log(qtd,valor,calculo);

	  });
	});
		$(document).ready(function() {

	 $("#amount2").blur(function() {
	   var qtd = $(this).val();
	   var valor = $("#priceUnit2").val();
	   var calculo = qtd * valor;
	   $("#priceTotal2").val(calculo);
	   console.log(qtd,valor,calculo);

	  });
	});
</script> 
 @endsection