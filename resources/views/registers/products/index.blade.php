@extends('adminlte::layouts.app')
@section('contentheader_title')
	Produtos
@endsection
@section('main-content')
 	<div style="float:right;">
 		<a href="#">
 		<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal">
 			<i class="fa fa-plus"></i> Cadastrar Produto
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
					 			<th>Estoque</th>
					 			<th>Valor</th>
					 			<th>Opções</th>
					 		</tr>
					 	</thead>
					 	@foreach($products as $product)
					 	<tbody>
					 		<tr>
					 			<th>{{ $product->id }}</th>
					 			<th>{{ $product->name }}</th>
					 			<th>{{ $product->stock }}</th>
					 			<th>R$ {{ number_format($product->price, 2, ',','.')}}</th>
					 		<td>
					 				{{ Form::open(array('route' => array('products.destroy', $product->id), 'method' => 'delete')) }}
					 				<button type="button" class="btn btn-primary" 
					 					data-myid="{{$product->id}}"
					 					data-name="{{$product->name}}"
					 					data-stock="{{$product->stock}}"  
					 					data-price="{{$product->price}}"
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
		        	<h4 class="modal-title" id="myModalLabel">Cadastro de Produtos</h4>
		      	</div>
	      		<div class="modal-body">
					<form action="{{ route('products.store')}}" method="post">
					{{csrf_field()}}	  
					<hr />	  
						<div class="row">	    
							<div class="form-group col-md-8">	      
								<label for="name">Nome</label>	      
								<input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
							</div>	
						</div>	  	  
						<div class="row">	    
						   	<div class="form-group col-md-7">	      
								<label for="campo1">Estoque</label>	      
								<input type="number" class="form-control" id="stock" name="stock" value="{{old('stock')}}" required>
							</div>	
						</div>	  	  
					   	<div class="row">       
				            <div class="form-group col-md-6">         
				                <label for="campo2">Valor</label>         
				                <input type="number" class="form-control price" id="price" name="price" value="{{old('price')}}">
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
		        	<h4 class="modal-title" id="myModalLabel">Cadastro de Produtos</h4>
		      	</div>
	      		<div class="modal-body">
					<form action="{{ route('products.update','test')}}" method="post">
					{{method_field('patch')}}
					{{csrf_field()}}	  
					<hr />	  
						<input type="hidden" id="id" name="id" value="">
						<div class="row">	    
							<div class="form-group col-md-8">	      
								<label for="name">Nome</label>	      
								<input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
							</div>	
						</div>	  	  
						<div class="row">	    
						   	<div class="form-group col-md-7">	      
								<label for="campo1">Estoque</label>	      
								<input type="number" class="form-control" id="stock" name="stock" value="{{old('stock')}}" required>
							</div>	
						</div>	  	  
					   	<div class="row">       
				            <div class="form-group col-md-6">         
				                <label for="campo2">Valor</label>         
				                <input type="number" class="form-control price" id="price" name="price" value="{{old('price')}}">
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
      var stock = button.data('stock') 
      var price = button.data('price')
      var modal = $(this)

      modal.find('.modal-body #name').val(name);
      modal.find('.modal-body #id').val(id);
      modal.find('.modal-body #stock').val(stock);
      modal.find('.modal-body #price').val(price);
	})
 			$('#price').priceFormat({
			    prefix: '',
			    centsSeparator: '.',
			    thousandsSeparator: ''
			});
 	</script>

	
	    

 
 @endsection