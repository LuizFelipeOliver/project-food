@extends('products.layout')

@section('content')

<div class="card mt-5">
  <h2 class="card-header">Add New Product</h2>
  <div class="card-body">

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('products.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="inputName" class="form-label"><strong>Name:</strong></label>
            <input
                type="text"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                id="inputName"
                placeholder="Name">
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputPrice" class="form-label"><strong>Price:</strong></label>
            <input
                type="number"
                name="price"
                class="form-control @error('price') is-invalid @enderror"
                id="inputPrice"
                step="0.01"
                placeholder="0.00">
            @error('price')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="inputName" class="form-label"><strong>Category:</strong></label>
            <select name="category_id" id="inputCategory" class="form-control">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="inputStatus" class="form-label"><strong>Status:</strong></label>
            <select name="status" class="form-control" id="inputStatus">
                <option value="active">Ativo</option>
                <option value="inactive">Inativo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="inputSDescription" class="form-label"><strong>Detail:</strong></label>
            <textarea
                class="form-control @error('description') is-invalid @enderror"
                style="height:150px"
                name="description"
                id="inputDetail"
                placeholder="Detail"></textarea>
            @error('description')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
    </form>

  </div>
</div>
@endsection
