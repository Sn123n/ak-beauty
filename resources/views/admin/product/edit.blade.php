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

                                <h4 class="header-title">Edit Product</h4>

                                <a href="{{ route('products.index') }}" class="btn btn-primary">Manage Product</a>

                            </div>

                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('products.update', $product->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category</label>
                                            <select id="category_id" name="category_id" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Product Title</label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                value="{{ old('title', $product->title) }}">
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">SKU</label>
                                            <input type="text" id="sku" name="sku" class="form-control"
                                                value="{{ old('sku', $product->sku) }}">
                                            @error('sku')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="qnty" class="form-label">Quantity</label>
                                            <input type="number" id="qnty" name="qnty" class="form-control"
                                                value="{{ old('qnty', $product->qnty) }}">
                                            @error('qnty')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="cost_per_gram" class="form-label">Cost per Gram</label>
                                            <input type="number" id="cost_per_gram" name="cost_per_gram"
                                                class="form-control"
                                                value="{{ old('cost_per_gram', $product->cost_per_gram) }}">
                                            @error('cost_per_gram')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="total_cost" class="form-label">Total Cost</label>
                                            <input type="number" id="total_cost" name="total_cost" class="form-control"
                                                value="{{ old('total_cost', $product->total_cost) }}">
                                            @error('total_cost')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label"> Price</label>
                                            <input type="number" id="price" name="price" class="form-control"
                                                value="{{ old('price', $product->price) }}">
                                            @error('price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="discount" class="form-label">Discount</label>
                                            <div class="input-group">
                                                <select name="discount_type" id="discount_type" class="form-select">
                                                    <option value="rs"
                                                        {{ old('discount_type', $product->discount_type) == 'rs' ? 'selected' : '' }}>
                                                        Rs</option>
                                                    <option value="percent"
                                                        {{ old('discount_type', $product->discount_type) == 'percent' ? 'selected' : '' }}>
                                                        %</option>
                                                </select>
                                                <input type="number" id="discount" name="discount" class="form-control"
                                                    value="{{ old('discount', $product->discount) }}"
                                                    placeholder="Enter discount">

                                            </div>
                                            @error('discount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status1" name="status" class="form-control form-select">
                                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>
                                                    Deactive</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" id="image" name="image" class="form-control">
                                            <span class="size-notes">Note: size 500(width) x 500(height)</span>
                                            <input type="hidden" name="old_image" value="{{ $product->image }}">

                                            <div id="mainImagePreview" class="mt-2"></div>
                                            @if ($product->image)
                                                <img src="{{ asset('product/' . $product->image) }}" alt="Product Image"
                                                    width="100" class="mt-2">
                                            @endif
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Back Image</label>
                                            <input type="file" id="back_image" name="back_image"
                                                class="form-control">
                                            <span class="size-notes">Note: size 500(width) x 500(height)</span>
                                            <input type="hidden" name="old_back_image"
                                                value="{{ $product->back_image }}">

                                            @if ($product->back_image)
                                                <img src="{{ asset('product/' . $product->back_image) }}"
                                                    alt="Product Image" width="100" class="mt-2">
                                            @endif
                                            @error('back_image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="other_image" class="form-label">Other Images</label>
                                            <input type="file" id="other_image" name="other_image[]"
                                                class="form-control" multiple>
                                            <span class="size-notes">Note: size 500(width) x 500(height)</span>
                                            <input type="hidden" name="old_other_images"
                                                value="{{ $product->other_image }}">

                                            <div id="otherImagePreview" class="row mt-2"></div>
                                            <div class="row">
                                                @if (!empty($product->other_image))
                                                    @foreach (json_decode($product->other_image, true) as $image)
                                                        <div class="col-md-3 position-relative image-container">
                                                            <img src="{{ asset('product/' . $image) }}" alt="Other Image"
                                                                class="img-thumbnail" style="width:100px; height:100px;">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image"
                                                                data-id="{{ $product->id }}"
                                                                data-image="{{ $image }}">
                                                                &times;
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Content</label>
                                            <textarea class="form-control" id="editor" name="content" rows="3">{{ old('content', $product->content) }}</textarea>
                                            @error('content')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="hidden" name="daily_deal" value="no">
                                                <input type="checkbox" name="daily_deal" class="form-check-input"
                                                    id="customCheck1" value="yes"
                                                    {{ old('daily_deal', $product->daily_deal) == 'yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="customCheck1">Daily Deal</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">Update</button>
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
        $(document).on("click", ".delete-image", function() {
            let button = $(this);
            let productId = button.data("id");
            let imageName = button.data("image");

            $.ajax({
                url: "{{ route('product.deleteImage') }}",
                type: "DELETE",
                data: {
                    id: productId,
                    image: imageName,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        button.closest(".image-container").remove();
                    } else {
                        // alert(response.message);
                    }
                },
                error: function() {
                    // alert("Something went wrong!");
                },
            });
        });


        $(document).ready(function() {

            $("#image").on("change", function(e) {
                let file = e.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $("#mainImagePreview").html(`
                    <div class="position-relative">
                        <img src="${e.target.result}" alt="Preview" width="100">

                    </div>
                `);

                        $("img[alt='Product Image']").hide();
                    };
                    reader.readAsDataURL(file);
                }
            });

        });

        $(document).ready(function() {
            $("#other_image").on("change", function(e) {
                $("#otherImagePreview").html("");

                Array.from(e.target.files).forEach((file, index) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let imgPreview = `
                    <div class="col-md-3 position-relative preview-image">
                        <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="width:100px; height:100px;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-preview" data-index="${index}">
                            &times;
                        </button>
                    </div>
                `;
                        $("#otherImagePreview").append(imgPreview);
                    };
                    reader.readAsDataURL(file);
                });
            });
            $(document).on("click", ".remove-preview", function() {
                $(this).closest(".preview-image").remove();
                let indexToRemove = $(this).data("index");
                let fileInput = $("#other_image")[0];
                let files = Array.from(fileInput.files);
                files.splice(indexToRemove, 1);
                let newFileList = new DataTransfer();
                files.forEach(file => newFileList.items.add(file));
                fileInput.files = newFileList.files;
            });
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
