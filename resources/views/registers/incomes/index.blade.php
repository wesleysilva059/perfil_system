@extends('adminlte::layouts.app')
@section('contentheader_title')
	Receitas
@endsection
@section('main-content')
 	<div style="float:right;">
 		<a href="#">
 		<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">
 			<i class="fa fa-plus"></i> Cadastrar Receita
 		</button>
 		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  	<div class="modal-dialog" role="document">
		    	<div class="modal-content">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title" id="myModalLabel">Cadastro de Receitas</h4>
			      	</div>
		      		<div class="modal-body">
						<form action="{{ route('incomes.store')}}" method="post">
						{{csrf_field()}}	  
						<hr />	  
							<div class="row">	    
								<div class="form-group col-md-8">	      
									<label for="name">Receita</label>	      
									<input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
								</div>		  
							</div>	  	  
							<div class="row">	    
							   	<div class="form-group col-md-7">	      
									<label for="campo1">Preço</label>	      
									<input type="text" class="form-control" id="price" name="price" value="{{old('price')}}">
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
						style="width:100%" id="employees-table">
					 	<thead>
					 		<tr>
					 			<th>ID</th>
					 			<th>Nome</th>
					 			<th>Valor </th>
					 			<th>Opções</th>
					 		</tr>
					 	</thead>
					 	@foreach($incomes as $income)
					 	<tbody>
					 		<tr>
					 			<th>{{ $income->id }}</th>
					 			<th>{{ $income->name }}</th>
					 			<th>R$ {{ number_format($income->price,2,',','.') }}</th>
					 		<td>
					 				<a href="#" class="btn btn-info">
					 					<i class="fa fa-wrench"></i>
					 				</a>
					 				<a href="{{ route('incomes.destroy', $income->id)}}" class="btn btn-danger">
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
	<script>
 			$('#price').priceFormat({
			    prefix: '',
			    centsSeparator: '.',
			    thousandsSeparator: ''
			});
 	</script>


	
	    

 
 @endsection