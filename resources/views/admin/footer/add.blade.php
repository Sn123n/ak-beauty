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

                                <h4 class="header-title">{{ $footerIcon ? 'Edit footerIcon' : 'Create footerIcon' }}</h4>

                                <a href="{{ route('footer-icon.index') }}" class="btn btn-primary">Manage footerIcon</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST"
                                action="{{ isset($footerIcon) ? route('footer-icon.update', $footerIcon->id) : route('footer-icon.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                @if (isset($footerIcon))
                                    @method('PATCH')
                                @endif

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" id="title" name="title"
                                                value="{{ old('title', $footerIcon->title ?? '') }}" class="form-control">
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                     <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="1"
                                                    {{ old('status', $footerIcon->status ?? '') == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $footerIcon->status ?? '') == 0 ? 'selected' : '' }}>Deactive
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="detail" class="form-label">Detail</label>
                                            <textarea id="detail" name="detail" class="form-control">{{ old('detail', $footerIcon->detail ?? '') }}</textarea>
                                            @error('detail')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" id="image" name="image" class="form-control">
                                            @if (isset($footerIcon) && $footerIcon->image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('footericon/' . $footerIcon->image) }}"
                                                        width="80" alt="Current Image">
                                                </div>
                                            @endif
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($footerIcon) ? 'Update' : 'Submit' }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div> <!-- end card-body -->

                    </div> <!-- end card -->

                </div><!-- end col -->

            </div><!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    @include('admin.layouts.footer')
@endsection
