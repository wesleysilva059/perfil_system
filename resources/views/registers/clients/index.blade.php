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
					 			<th>{{ $client->formatedbirth }}</th>
					 			<th>{{ $client->email}}</th>
					 			<th>{{ $client->address}}</th>
					 			<th>{{ $client->formatedphone}}</th>
					 		<td>
					 				{{ Form::open(array('route' => array('clients.destroy', $client->id), 'method' => 'delete')) }}
					 				<button type="button" class="btn btn-primary" 
					 					data-myid="{{$client->id}}"
					 					data-name="{{$client->name}}" 
					 					data-mybirth="{{$client->formatedbirth}}" 
					 					data-email="{{$client->email}}"
										data-myaddress="{{$client->address}}"
					 					data-myphone="{{$client->formatedphone}}"
					 					data-mycity="{{$client->city}}"
					 					data-mystate="{{$client->state}}"
					 					data-mycountry="{{$client->country}}"
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
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel">Cadastro de Clientes</h4>
	      	</div>
      		<div class="modal-body">
				<form action="{{ route('clients.update','test')}}" method="post">
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

<script>
	 $('#editModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) 
      var id = button.data('myid')

      var name = button.data('name') 
      var datee = button.data('mybirth').split("/") 
      var date2 = datee[2]+'-'+datee[1]+'-'+datee[0]
      var email = button.data('email')
      var address = button.data('myaddress')
      var phone = button.data('myphone')
      var city = button.data('mycity')
      var state = button.data('mystate')
      var country = button.data('mycountry') 
      var modal = $(this)

      console.log(datee,date2);

		//

      modal.find('.modal-body #id').val(id);
      modal.find('.modal-body #name').val(name);
	  modal.find('.modal-body #birth').val(date2);
      modal.find('.modal-body #address').val(address);
      modal.find('.modal-body #phone').val(phone);
      modal.find('.modal-body #city').val(city);
      modal.find('.modal-body #state').val(state);
      modal.find('.modal-body #country').val(country);

	})
</script>
	    

 
 @endsection