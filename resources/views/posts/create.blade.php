@extends('layouts.app')

@section('content')
    
<div class="container w-75">
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">  	
    @csrf   
  
    <label for="photo" class="mb-1">Photo:</label>   	
    <input type="file" name="photo" id="photo" class="form-control mb-2">	
    <label for="description" class="mb-1">Description:</label>   	
    <textarea name="description" id="description" class="form-control mb-2"></textarea>   
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>

@endsection
