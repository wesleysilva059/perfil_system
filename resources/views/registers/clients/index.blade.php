@extends('adminlte::layouts.app')
@section('contentheader_title')
	Clientes
@endsection
@section('main-content')
 	<div style="float:right;">
 		<a href="#">
 		<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">
 			<i class="fa fa-plus"></i> Cadastrar Cliente
 		</button>
 		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  	<div class="modal-dialog" role="document">
		    	<div class="modal-content">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="myModalLabel">Cadastro de Clientes</h4>
			      	</div>
		      		<div class="modal-body">
						<form action="{{ route('clients.store')}}" method="post">
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
							   	<div class="form-group col-md-5">	      
									<label for="campo1">Email</label>	      
									<input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" required>
								</div>	
								<div class="form-group col-md-7">	      
									<label for="campo2">Endereço</label>	      
									<input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">
								</div>	    	    
							</div>	  	  
						   	<div class="row">	    
							    <div class="form-group col-md-4">	      
							    	<label for="campo2">Cidade</label>	      
							    	<input type="text" class="form-control" id="city" name="city" value="{{old('city')}}">
							    </div>	    	    
							    <div class="form-group col-md-4">	      
							    	<label for="campo3">Estado</label>	      
							    	<input type="text" class="form-control" id="state" name="state" value="{{old('state')}}">
							    </div>
							    <div class="form-group col-md-4">	      
							    	<label for="campo2">Pais</label>	      
							    	<input type="text" class="form-control" id="country" name="country" value="{{old('country')}}">
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
		</a><br><br>
	</div>
 	 <br><br>
 	<div class="box box-primary">
 		<div class="row">
 			<div class="col-sm-12">
 				<div class="box-body">
 					<table class="table table-hover table-condensed"
						style="width:100%" id="clients-table">
					 	<thead>
					 		<tr>
					 			<th>ID</th>
					 			<th>Nome</th>
					 			<th>Data de nascimento </th>
					 			<th>Email</th>
					 			<th>Endereço</th>
					 			<th>Telefone</th>
					 			<th>Opções</th>
					 		</tr>
					 	</thead>
					 	@foreach($clients as $client)
					 	<tbody>
					 		<tr>
					 			<th>{{ $client->id }}</th>
					 			<th>{{ $client->name }}</th>
					 			<th>{{ $client->birth }}</th>
					 			<th>{{ $client->email}}</th>
					 			<th>{{ $client->address}}</th>
					 			<th>{{ $client->formatedphone}}</th>
					 		<td>
					 				<a href="#" class="btn btn-info">
					 					<i class="fa fa-wrench"></i>
					 				</a>
					 				<a href="{{ route('clients.destroy', $client->id)}}" class="btn btn-danger">
					 					<i class="fa fa-trash"></i>
					 				</a>
					 			</td>
					 		</tr>
					 	</tbody>
					 	@endforeach
					 </table>
 				</div>
 			</div>
 		</div>
 	</div>


	
	    

 
 @endsection