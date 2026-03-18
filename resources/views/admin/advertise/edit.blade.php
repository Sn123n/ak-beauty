@extends('admin.layouts.header')

@section('content')

<div class="content">

    <!-- Start Content-->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="header-title">Create Advertise</h4>
                            <a href="{{route('advertise.index')}}" class="btn btn-primary">Manage Advertise</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('advertise.update', $advertise->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="product" class="form-label">Product</label>
                                        <select class="form-select" name="product_id">
                                            <option value="">Select</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" {{ old('product_id', $advertise->product_id) == $product->id ? 'selected' : '' }}>
                                                    {{ $product->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror   
                                    </div>
                                </div>
                        
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="platef" class="form-label">Platform</label>
                                        <select class="form-select" name="socialmedia">
                                            <option value="">Select</option>
                                            <option value="facebook" {{ old('socialmedia', $advertise->socialmedia) == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                            <option value="instgram" {{ old('socialmedia', $advertise->socialmedia) == 'instgram' ? 'selected' : '' }}>Instagram</option>
                                            <option value="thread" {{ old('socialmedia', $advertise->socialmedia) == 'thread' ? 'selected' : '' }}>Thread</option>
                                            <option value="pintrest" {{ old('socialmedia', $advertise->socialmedia) == 'pintrest' ? 'selected' : '' }}>Pintrest</option>
                                            <option value="twitter" {{ old('socialmedia', $advertise->socialmedia) == 'twitter' ? 'selected' : '' }}>Twitter</option>
                                        </select>
                                        @error('socialmedia')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                        
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="text" id="price" name="price" class="form-control" value="{{ old('price', $advertise->price) }}">
                                        @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                        
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="text" id="link" name="link" class="form-control" value="{{ old('link', $advertise->link) }}">
                                        @error('link')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                        
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-3 position-relative" id="datepicker1">
                                        <label for="date" class="form-label">Date</label>
                                        <div class="position-relative date">
                                            <input type="text" name="date" class="form-control"
                                                value="{{ old('date', \Carbon\Carbon::parse($advertise->date)->format('d/m/Y')) }}"
                                                placeholder="dd/mm/yyyy"
                                                data-provide="datepicker" data-date-today-highlight="true" data-date-container="#datepicker1">
                                                @error('date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                    </div>
                                </div>
                        
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select id="status1" name="status" class="form-control form-select">
                                            <option value="1" {{ old('status', $advertise->status) == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status', $advertise->status) == '0' ? 'selected' : '' }}>Deactive</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        
                                <div class="col-lg-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Description</label>
                                        <textarea class="form-control" name="content">{{ old('content', $advertise->content) }}</textarea>
                                        @error('content')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                        
                                <div class="col-lg-12">
                                    <div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div> <!-- container -->
</div>

@include('admin.layouts.footer')

@endsection