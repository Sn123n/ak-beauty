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
                                <h4 class="header-title">Manage Advertise</h4>
                                <a href="{{ route('advertise.create') }}" class="btn btn-primary">Add Advertise</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success1" id="successMessage">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger" id="errorMessage">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div id="ajaxMessage" class="alert d-none alert alert-success1"></div>
                            <div class="dt-responsive">
                                <table id="example" class="table table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="sr" data-priority="1">Sr</th>
                                            <th>Product</th>
                                            <th>Platform</th>
                                            <th>Price</th>
                                            <th>Link</th>
                                            {{-- <th>Description</th> --}}
                                            <th>Date</th>
                                            <th class="status">Status</th>
                                            <th class="action" data-priority="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($avertises as $key => $ad)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $ad->product->title ?? 'N/A' }}</td>
                                                <td>{{ ucfirst($ad->socialmedia) }}</td>
                                                <td>{{ $ad->price }}</td>
                                                <td><a href="{{ $ad->link }}" target="_blank">{{ $ad->link }}</a>
                                                </td>
                                                {{-- <td>{{ Str::limit($ad->content, 100) }}</td> --}}
                                                <td>{{ $ad->date}}</td>
                                              
                                                <td>
                                                    <select class="form-control status-dropdown form-select"
                                                        data-id="{{ $ad->id }}"
                                                        onchange="changeStatus(this, 'advertise')">
                                                        <option value="1"
                                                            {{ $ad->status == 1 ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="0"
                                                            {{ $ad->status == 0 ? 'selected' : '' }}>
                                                            Deactive</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="{{ route('advertise.edit', $ad->id) }}"><i
                                                                class="fa-regular fa-pen-to-square me-1"></i></a>
                                                        <form action="{{ route('advertise.destroy', $ad->id) }}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn" onclick="return confirm('Are you sure you want to delete this Advertisement?')">
                                                                <i class="fa-solid fa-trash-can"></i>
    
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        </div> <!-- container -->
    </div> <!-- content -->

    @include('admin.layouts.footer')
    <script>
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    </script>
    <script>
       $(document).ready(function() {
            if ($(window).width() < 1100) {
                $('#example').DataTable({
                    responsive: true,
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
                    ]
                });
            } else {
                $('#example').DataTable({
                    responsive: false,
                });
            }
        });
    </script>
@endsection
