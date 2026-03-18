<!-- Footer Start -->

<footer class="footer">

    <div class="container-fluid">

        <div class="row">

            <div class="col-12 text-center">

                <script>
                    document.write(new Date().getFullYear())
                </script> © Rizester

            </div>

        </div>

    </div>

</footer>

<!-- end Footer -->



</div>

<!--contetn div end-->


</div>

<!-- END wrapper -->

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

<!-- App js -->

<script src="{{ asset('assets/js/app.min.js') }}"></script>

<!-- Vendor js -->

<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

<!--data table-->

<script src="{{ asset('assets/js/datatable/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('assets/js/datatable/dataTables.bootstrap5.min.js') }}"></script>

<script src="{{ asset('assets/js/datatable/dataTables.buttons.min.js') }}"></script>

<script src="{{ asset('assets/js/datatable/dataTables.responsive.min.js') }}"></script>

<!-- Bootstrap Datepicker Plugin js -->

<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>


{{-- ckeditor --}}
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>

<script>
   function changeStatus(selectElement, page) {
    var id = $(selectElement).data("id"); 
    var status = $(selectElement).val(); 

    $.ajax({
        url: "{{ route('update.status') }}", 
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: id,
            status: status,
            page: page
        },
        success: function(response) {
            $("#ajaxMessage").removeClass('d-none').addClass('alert-success')
                .text(response.message)
                .fadeIn().delay(2000).fadeOut();
        },
        error: function(xhr) {
            $("#ajaxMessage").removeClass('d-none').addClass('alert-danger')
                .text("Error updating status")
                .fadeIn().delay(2000).fadeOut();
        }
    });
}

</script>
</body>

</html>
