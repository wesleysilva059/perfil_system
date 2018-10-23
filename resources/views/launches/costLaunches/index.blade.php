@extends('adminlte::layouts.app')
@section('contentheader_title')
	Relação de Despesas {{ucfirst($month_extense)}}
@endsection
@section('main-content')
 	<div style="float:right;">
 		<a href="#">
 		<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">
 			<i class="fa fa-plus"></i> Cadastrar Pagamento
 		</button>
 		<!-- Modal -->
		</a><br><br>
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
					 			<th>Descrição</th>
					 			<th>Data</th>
					 			<th>Funcionário</th>
					 			<th>Valor</th>
					 			<th>Observação</th>
					 			<th>Opções</th>
					 		</tr>
					 	</thead>
					 	@foreach($costLaunches as $costLaunche)
					 	<tbody>
					 		<tr>
					 			<td>{{ $costLaunche->id }}</td>
					 			<td>{{ $costLaunche->cost->name }}</td>
					 			<td>{{ $costLaunche->formateddate}}</td>
					 			<td>{{ $costLaunche->employee->name}}</td>
					 			<td>R$ {{ number_format($costLaunche->price, 2, ',','.') }}</td>
					 			<td>{{ $costLaunche->observation}}</td>
					 		<td>
					 			{{ Form::open(array('route' => array('costLaunches.destroy', $costLaunche->id), 'method' => 'delete')) }}
					 				<button type="button" class="btn btn-primary" 
					 					data-myid="{{$costLaunche->id}}"
					 					data-cost_id="{{$costLaunche->cost->id}}" 
					 					data-name="{{$costLaunche->cost->name}}" 
					 					data-mydate="{{$costLaunche->formateddate}}" 
					 					data-employee_id="{{$costLaunche->employee_id}}"
										data-myemployee="{{$costLaunche->employee->name}}"
					 					data-myprice="{{$costLaunche->price}}" 
					 					data-myobservation="{{$costLaunche->observation}}"
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
	<!-- Modal de Insert -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="myModalLabel">Cadastro de Pagamento</h4>
		      	</div>
	      		<div class="modal-body">
					<form action="{{ route('costLaunches.store')}}" method="post">
					{{csrf_field()}}	  
					<hr />	  
						<div class="row">	    
							<div class="form-group col-md-3">	      
								<label for="name">Codigo</label>	      
								<input type="number" class="form-control" id="cost_id" name="cost_id" value="{{old('cost_id')}}" required>
							</div>
							<div class="form-group col-md-9">	      
								<label for="campo1">Descrição</label>	      
								<input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
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
						   	<div class="form-group col-md-7">	      
								<label for="campo1">Valor</label>	      
								<input type="text" class="form-control" id="price" name="price" value="{{old('price')}}">
							</div>	
						</div>
						<div class="row">	    
						   	<div class="form-group col-md-12">	      
								<label for="campo1">Observação</label>	      
								<input type="text" class="form-control" id="observation" name="observation" value="{{old('observation')}}">
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
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="myModalLabel">Editar Recebimento</h4>
		      	</div>
	      		<div class="modal-body">
					<form action="{{ route('costLaunches.update', 'test')}}" method="post">
					{{method_field('patch')}}
					{{csrf_field()}}	  
						<input type="hidden" id="id" name="id" value="">	  
						<div class="row">	    
							<div class="form-group col-md-3">	      
								<label for="cost_id">Codigo</label>	      
								<input type="number" class="form-control" id="cost_id" name="cost_id" value="{{old('cost_id')}}" required>
							</div>
							<div class="form-group col-md-9">	      
								<label for="name">Descrição</label>	      
								<input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
							</div>
						</div>		  
						<div class="row">	    
						   	<div class="form-group col-md-6">	      
								<label for="date">Data</label>	      
								<input type="date" class="form-control" id="date" name="date" value="{{old('date')}}">
							</div>
							<div class="form-group col-md-6">	      
								<label for="employee_id">Funcionario</label>	      
								<select name="employee_id" class="form-control" id="employee_id">
									<option id="employee_id" value=""></option>
									option
									@foreach($employee_list as $e)
										<option value="{{$e->id}}">{{$e->name}}</option>
									@endforeach
								</select>
							</div>	
						</div>
						<div class="row">	    
						   	<div class="form-group col-md-7">	      
								R$ 
								<label for="price">Valor</label>	      
								<input type="text" class="form-control price" id="price" name="price" value="{{old('price')}}">
							</div>	
						</div>
						<div class="row">	    
						   	<div class="form-group col-md-12">	      
								<label for="observation">Observação</label>	      
								<input type="text" class="form-control" id="observation" name="observation" value="{{old('observation')}}">
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
      var cost_id = button.data('cost_id')
      var name = button.data('name') 
      var datee = button.data('mydate').split("/") 
      var date2 = datee[2]+'-'+datee[1]+'-'+datee[0]
      var employee_id = button.data('employee_id')
      var employee = button.data('myemployee')
      var price = button.data('myprice')
      var observation = button.data('myobservation') 
      var modal = $(this)

      console.log(datee,date2);

		//

      modal.find('.modal-body #cost_id').val(cost_id);
      modal.find('.modal-body #name').val(name);
      modal.find('.modal-body #date').val(date2);
      modal.find('.modal-body #id').val(id);
      modal.find('.modal-body #price').val(price);
      modal.find('.modal-body #employee_id').val(employee_id);
      modal.find('.modal-body #observation').val(observation);
	})

	$('#price').priceFormat({
	    prefix: '',
	    centsSeparator: '.',
	    thousandsSeparator: ''
	});

	$(document).ready(function(){
		$("input[name='cost_id']").blur(function(){
			var cost_id = $(this).val();
			var description = $("input[name='name']");
			var price = $("input[name='price']");
			$.getJSON('/get-cost/' + cost_id, function( cost ){
				description.val( cost.name );
				price.val(cost.price);
			});
		});
	});
</script>
	    

 
 @endsection