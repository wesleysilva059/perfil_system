@extends('adminlte::layouts.app')
@section('contentheader_title')
	Funcionários
@endsection
@section('main-content')
 	<div style="float:right;">
 		<a href="#">
 		<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">
 			<i class="fa fa-plus"></i> Cadastrar Funcionário
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
					 			<th>Nome</th>
					 			<th>Data de nascimento </th>
					 			<th>Email</th>
					 			<th>Telefone</th>
					 			<th>Opções</th>
					 		</tr>
					 	</thead>
					 	@foreach($employees as $employee)
					 	<tbody>
					 		<tr>
					 			<th>{{ $employee->id }}</th>
					 			<th>{{ $employee->name }}</th>
					 			<th>{{ $employee->birth }}</th>
					 			<th>{{ $employee->email}}</th>
					 			<th>{{ $employee->phone}}</th>
					 		<td>
					 				{{ Form::open(array('route' => array('employees.destroy', $employee->id), 'method' => 'delete')) }}
					 				<button type="button" class="btn btn-primary" 
					 					data-myid="{{$employee->id}}"
					 					data-name="{{$employee->name}}" 
					 					data-mydate="{{$employee->formatedbirth}}" 
					 					data-email="{{$employee->email}}"
										data-phone="{{$employee->phone}}"
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
					 </table>
 				</div>
 			</div>
 		</div>
 	</div>
 	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="myModalLabel">Cadastro de Funcionários</h4>
		      	</div>
	      		<div class="modal-body">
					<form action="{{ route('employees.store')}}" method="post">
					{{csrf_field()}}	  
					<hr />	  
						<div class="row">	    
							<div class="form-group col-md-8">	      
								<label for="name">Nome Completo</label>	      
								<input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
							</div>	
						    <div class="form-group col-md-4">
						    	<label for="campo2">Data de Nascimento</label>
						    	<input type="date" class="form-control" id="birth" name="birth" value="{{old('birth')}}" required>
						    </div>	  
						</div>	  	  
						<div class="row">	    
						   	<div class="form-group col-md-7">	      
								<label for="campo1">Email</label>	      
								<input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" required>
							</div>	
						</div>	  	  
					   	<div class="row">       
				            <div class="form-group col-md-6">         
				                <label for="campo2">Telefone</label>         
				                <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
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
		        	<h4 class="modal-title" id="myModalLabel">Cadastro de Funcionários</h4>
		      	</div>
	      		<div class="modal-body">
					<form action="{{ route('employees.update','test')}}" method="post">
					{{method_field('patch')}}
					{{csrf_field()}}	  
					<hr />	
						<input type="hidden" id="id" name="id" value="">  
						<div class="row">	    
							<div class="form-group col-md-8">	      
								<label for="name">Nome Completo</label>	      
								<input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
							</div>	
						    <div class="form-group col-md-4">
						    	<label for="campo2">Data de Nascimento</label>
						    	<input type="date" class="form-control" id="birth" name="birth" value="{{old('birth')}}" required>
						    </div>	  
						</div>	  	  
						<div class="row">	    
						   	<div class="form-group col-md-7">	      
								<label for="campo1">Email</label>	      
								<input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" required>
							</div>	
						</div>	  	  
					   	<div class="row">       
				            <div class="form-group col-md-6">         
				                <label for="campo2">Telefone</label>         
				                <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
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

<script>
	$('#editModal').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget) 
      var id = button.data('myid')
      var name = button.data('name') 
      var datee = button.data('mydate').split("/") 
      var date2 = datee[2]+'-'+datee[1]+'-'+datee[0]
      var email = button.data('email')
      var phone = button.data('phone')
      var modal = $(this)

      modal.find('.modal-body #name').val(name);
      modal.find('.modal-body #birth').val(date2);
      modal.find('.modal-body #id').val(id);
      modal.find('.modal-body #email').val(email);
      modal.find('.modal-body #phone').val(phone);
	})

</script>
	
	    

 
 @endsection