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

                            <h4 class="header-title">Create Sliders</h4>

                            <a href="{{ route('sliders.index') }}" class="btn btn-primary">Manage Sliders</a>

                        </div>

                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('sliders.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-lg-12 col-md-12">

                                    <div class="mb-3">

                                        <label for="name" class="form-label">Name</label>

                                        <input type="text" id="name" name="name" class="form-control">
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-lg-6 col-md-6">

                                    <div class="mb-3">

                                        <label for="name" class="form-label">Button Text</label>

                                        <input type="text" id="button_text" name="button_text" class="form-control">
                                        @error('button_text')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-lg-6 col-md-6">

                                    <div class="mb-3">

                                        <label for="name" class="form-label">Button Link</label>

                                        <input type="text" id="button_link" name="button_link" class="form-control">
                                        @error('button_link')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-lg-6 col-md-6">

                                    <div class="mb-3">

                                        <label for="image" class="form-label">Slider Image</label>

                                        <input type="file" id="image" name="image" class="form-control">
                                        <span class="size-notes">Note: size 1900(width) x 600(height)</span>
                                        @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label ">Status</label>
                                        <select id="status1" name="status" class="form-control form-select">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Deactive
                                            </option>
                                        </select>
                                        @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">

                                    <div class="mb-3">

                                        <label for="content" class="form-label">Content</label>
                                        <textarea class="form-control" id="editor" name="content" rows="3" placeholder="Enter content"></textarea>

                                        @error('content')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-lg-12">

                                    <div class="">

                                        <button type="submit" class="btn btn-primary">Submit</button>

                                    </div>

                                </div>

                            </div> <!-- end row-->

                        </form>



                    </div> <!-- end card-body -->

                </div> <!-- end card -->

            </div><!-- end col -->

        </div><!-- end row -->





    </div> <!-- container -->



</div> <!-- content -->

@include('admin.layouts.footer')

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