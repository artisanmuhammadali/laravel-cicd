<script src="{{asset('admin/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    {{-- <script src="{{asset('admin/vendors/js/charts/apexcharts.min.js')}}"></script> --}}
    <script src="{{asset('admin/vendors/js/extensions/toastr.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('admin/js/core/app-menu.js')}}"></script>
    <script src="{{asset('admin/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{asset('admin/js/scripts/pages/dashboard-ecommerce.js')}}"></script> --}}
    <!-- END: Page JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>

<script src="{{asset('admin/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('admin/js/scripts/forms/form-select2.js')}}"></script>
    
    <script src="{{asset('user/js/main.js')}}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('admin.components.timepikerScript')

<script>
    function deleteAlert(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $('#delete-form').attr('action', url);
                $('#delete-form').submit();
            }
        });
    }
    // copy referral link to clipboard

    $(document).on('click','.copy-link', function() {
        var elm = $(this).closest('.col-12').find('.link');
        $(elm).select();
        document.execCommand("copy");
        $('.copy-link').text('Copy');
        $(this).text('Copied');
    });
    // $(document).on('click','.delete-btn',function(e)
    // {
    //     e.preventDefault();
    //     let url = $(this).attr('href');
    //     deleteAlert(url)
    // })
</script>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })

        // $('#phone').mask("0000000000", {placeholder: "3xxxxxxxxx"});

        $(document).on('click','.close',function(){
            $(this).closest('.modal').modal('hide');
        })
        $(document).on('input', '.decimal', function (e) {
        this.value = this.value.replace(/[^0.00-9.99]/g, '').replace(/(\..*)\./g, '$1').replace(new RegExp("(\\.[\\d]{2}).", "g"), '$1');
        });
        
    </script>
    <script>
        $(document).ready(function() {
        // Bind the keypress event to the input fields inside the form
           $(".submit_form").on("keypress", function(event) {
           // Get the key code for the pressed key
           var keyCode = event.which ? event.which : event.keyCode;

    // Check if the pressed key is Enter (key code 13)
    if (keyCode === 13) {
      event.preventDefault(); // Prevent form submission
    }
  });
});


$(document).on('click','.toggle_btn,.close_btn',function(){
    let target = $(this).data('target');

    $(target).toggleClass('hide_box');
})


</script>

<script>
    function logout(){
      $('#logout-form').submit();
    }
  </script>