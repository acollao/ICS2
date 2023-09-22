<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{url('js/bootstrap.bundle.min.js')}}" crossorigin="anonymous"></script>
<script src="{{url('js/simple-datatables.min.js')}}" crossorigin="anonymous"></script>
<script src="{{url('js/datatables-simple-demo.js')}}"></script>
<script src="{{url('js/sweetalert2.min.js')}}" crossorigin="anonymous"></script>
<!-- Select2 -->
<script src="{{url('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Main -->
<script src="{{url('js/scripts.js')}}"></script>

<script type="text/javascript">
    // Add remove loading class on body element based on Ajax request status
    $(document).on({
        ajaxStart: function() {
            $("body").addClass("loading");
        },
        ajaxStop: function() {
            $("body").removeClass("loading");
        }
    });


    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

    });


    $(window).on('load', function() {
        setTimeout(() => {
            $(".loader").fadeOut(500)
        }, 1000);
    })



    $('.delete-confirm').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        var form = $(this).closest("form");
        var name = $(this).data("name");
        swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    alert("test");
                }
            });
    });
</script>

@stack('child-scripts')