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

                                <h4 class="header-title">Create Product</h4>

                                <a href="{{ route('coupons.index') }}" class="btn btn-primary">Manage Coupon</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST"
                                action="{{ isset($coupon_data) ? route('coupons.update', $coupon_data->id) : route('coupons.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if (isset($coupon_data))
                                    @method('PATCH')
                                @endif
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control " id="title" name="title"
                                                placeholder="Enter Coupon Title"
                                                value="{{ old('title', isset($coupon_data) ? $coupon_data->title : '') }}">
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">Coupon Code</label>
                                            <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                                placeholder="Enter Coupon Code"
                                                value="{{ old('coupon_code', isset($coupon_data) ? $coupon_data->coupon_code : '') }}">
                                            @error('coupon_code')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="qnty" class="form-label">Description</label>
                                            <input type="text" class="form-control" id="description" name="description"
                                                placeholder="Enter Coupon Description"
                                                value="{{ old('description', isset($coupon_data) ? $coupon_data->description : '') }}">
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="discount" class="form-label">Discount</label>
                                            <div class="input-group">
                                                <select name="discount_type" id="discount_type" class="form-select">
                                                    <option value="flat" {{ old('discount_type', isset($coupon_data) ? $coupon_data->discount_type : '') == 'flat' ? 'selected' : '' }}>Rs</option>
                                                    <option value="percentage" {{ old('discount_type', isset($coupon_data) ? $coupon_data->discount_type : '') == 'percentage' ? 'selected' : '' }}>%</option>
                                                </select>
                                                <!-- Flat Discount Input -->
                                                <input type="number" id="discount_rupees" name="discount_rupees" class="form-control"
                                                    value="{{ old('discount_rupees', isset($coupon_data) ? $coupon_data->discount_rupees : '') }}"
                                                    placeholder="Enter discount ruppies" step="0.01">
                                                
                                                <!-- Percentage Discount Input -->
                                                <input type="number" id="discount_percentage" name="discount_percentage" class="form-control"
                                                    value="{{ old('discount_percentage', isset($coupon_data) ? $coupon_data->discount_percentage : '') }}"
                                                    placeholder="Enter discount percentage" step="0.01">
                                            </div>
                                            @error('discount_rupees')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            @error('discount_percentage')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                                                                                                                      
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                value="{{ old('start_date', isset($coupon_data) ? $coupon_data->start_date : '') }}">
                                            @error('start_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Expiry Date</label>
                                            <input type="date" class="form-control" id="expiry_date" name="expiry_date"
                                                value="{{ old('expiry_date', isset($coupon_data) ? $coupon_data->expiry_date : '') }}">
                                            @error('expiry_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    @include('admin.layouts.footer')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let discountType = document.getElementById("discount_type");
            let discountRupees = document.getElementById("discount_rupees");
            let discountPercentage = document.getElementById("discount_percentage");
        
            function toggleDiscountFields() {
                if (discountType.value === "percentage") {
                    discountPercentage.style.display = "block";
                    discountRupees.style.display = "none";
                    discountRupees.value = ""; // Clear value when hidden
                } else {
                    discountPercentage.style.display = "none";
                    discountRupees.style.display = "block";
                    discountPercentage.value = ""; // Clear value when hidden
                }
            }
        
            toggleDiscountFields(); // Initial check
        
            discountType.addEventListener("change", toggleDiscountFields);
        });
        </script>
        
    <script>
        CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
            toolbar: {
                items: [
                    'exportPDF', 'exportWord', '|',
                    'findAndReplace', 'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
                    'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed',
                    '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'textPartLanguage', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            },
            // placeholder: 'Welcome to CKEditor 5!',
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            htmlSupport: {
                allow: [{
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }]
            },
            htmlEmbed: {
                showPreviews: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            mention: {
                feeds: [{
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                        '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
                        '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
                        '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }]
            },
            removePlugins: [
                'CKBox',
                'CKFinder',
                'EasyImage',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                'MathType'
            ]
        });
    </script>
@endsection
