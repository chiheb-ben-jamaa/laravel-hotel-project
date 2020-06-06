@extends('adminlte.dashboard')
@section('content')
	


<div class="row" style="padding-top: 10px">
	<div class="col-md-8">
	@if($message = Session::get('success'))
	<div class="alert alert-success" style="margin:50px">
		<p> {{ $message }} </p>
	</div>
	@endif
	</div>
</div>


<div class="card-body">
	<div class="card" style="margin-right:40px;margin-left:40px;">
	<table id="example2" class="table table-bordered"  aria-describedby="example2_info">
	
	
	
	<tr class="table">
			<th>Image</th>
			<th> No </th>
			<th> Titre </th>
			<th> Description </th>
			<th> Action </th>
		</tr>
		@foreach($sliders as $key => $slide)
		<tr class="table-light">
				<td>
				<img width="100" height="100" src="/images/{{ $slide->image }}" class="loaded" alt="icon" >
				</td>
				<td style="text-align: center; vertical-align: middle;"> {{ ++$i }} </td>
				<td style="text-align: center; vertical-align: middle;"> {{ $slide->titre }} </td>
				<td style="text-align: center; vertical-align: middle;"> {{ $slide->description }} </td>
				<td style="text-align: center; vertical-align: middle;">
					<form action="{{ route('slider.destroy', $slide->id) }}" method="POST">
						<a class="btn btn-primary" href="{{ route('slider.edit', $slide->id) }}">Edit</a>
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger">Delete</button>
					</form>
				</td>
			</tr>
		@endforeach
	</table>

	<div class="row" style="margin:10px">
		<div class="col-md-8">

			<div class="pull-left" style="margin-left: 20px">
				<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> 
					<i class="fa fa-plus" aria-hidden="true">
						slider
					</i>
					</button>
			</div>
		</div>
	</div>

	</div>
</div>



	<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">
			  <h3>Ajouter image slider </h3>
			</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  
		
			@if($errors->any())
				<div class="alert alert-danger">
					<strong>Oopps! </strong> Something went wrong.
					<ul>
						@foreach($errors->all() as $error)
							<li> {{ $error }} </li>
						@endforeach
					</ul>
				</div>
			@endif
		
			<form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="row">
					<div class="col-lg-12" style="margin-bottom: 20px">
						<div class="form-group">
							<strong>Titre:</strong>
							<input type="text" name="titre" class="form-control" placeholder="titre">
						</div>
					</div>
		
					<div class="col-lg-12" style="margin-bottom: 20px">
						<div class="form-group">
							<strong>Description:</strong>
							<textarea name="description" placeholder="description" class="form-control"></textarea>
						</div>
					</div>
		
					<div class="col-md-12" style="margin-bottom: 20px">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="customFile" name="image">
							<label class="custom-file-label" for="customFile" name="image">Image</label>
					  	</div>
					</div>


					<div class="col-lg-12">
						
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>



	  </div>
	</div>
  </div>





  
	<!-- Modal -->
<div class="modal fade" id="editmodel" tabindex="-1" role="dialog" aria-labelledby="editmodel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">
			  <h3> Add New Product </h3>
			</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  
		
			@if($errors->any())
				<div class="alert alert-danger">
					<strong>Oopps! </strong> Something went wrong.
					<ul>
						@foreach($errors->all() as $error)
							<li> {{ $error }} </li>
						@endforeach
					</ul>
				</div>
			@endif
		
			<form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="row">
					<div class="col-lg-12" style="margin-bottom: 20px">
						<div class="form-group">
							<strong>Titre:</strong>
							<input type="text" name="titre" class="form-control" placeholder="titre">
						</div>
					</div>
		
					<div class="col-lg-12" style="margin-bottom: 20px">
						<div class="form-group">
							<strong>Description:</strong>
							<textarea name="description" placeholder="description" class="form-control"></textarea>
						</div>
					</div>
		
					<div class="col-md-8" style="margin-bottom: 20px">
						<div class="form-group">
							<label style="margin-bottom: 20px">Select Image</label>
							<input type="file" name="image" />
						</div>
					</div>
					<div class="col-lg-12">
						
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</form>



	  </div>
	</div>
  </div>




  <!-- Edit Modal -->

@endsection