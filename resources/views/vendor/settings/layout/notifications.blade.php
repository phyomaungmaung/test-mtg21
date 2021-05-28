<script type="text/javascript">
    $(document).ready(function () {
//        toastr.options = {
//            "closeButton": true,
//            "debug": false,
//            "progressBar": true,
//            "preventDuplicates": false,
//            "positionClass": "toast-bottom-right",
//            "onclick": null,
//            "showDuration": "400",
//            "hideDuration": "1000",
//            "timeOut": "7000",
//            "extendedTimeOut": "1000",
//            "showEasing": "swing",
//            "hideEasing": "linear",
//            "showMethod": "fadeIn",
//            "hideMethod": "fadeOut"
//        }
                @if($errors->any())
        var msg = '';
        @foreach ($errors->all() as $error)
            msg = msg + "- {{ $error }} <br/>";
        @endforeach
//        toastr.error(msg, "Error");
            $.toast({
                heading: 'error',
                text: msg,
                showHideTransition: 'plain',
                position: 'bottom-right',
                stack: false,
                icon: 'error'
            });
        @endif
        @if(session('success'))
            {{--toastr.success("{{ session('success') }}", "Success");--}}
            $.toast({
                heading: 'success',
                text: "{{session('success')}}",
                showHideTransition: 'plain',
                position: 'bottom-right',
                stack: false,
                icon: 'success'
            });
        @endif
        @if(session('error'))
        {{--toastr.error("{{ session('error') }}", "Error");--}}
        $.toast({
            heading: 'error',
            text: "{{session('error')}}",
            showHideTransition: 'plain',
            position: 'bottom-right',
            stack: false,
            icon: 'error'
        });
        @endif
        @if(session('info'))
        {{--toastr.error("{{ session('info') }}", "Info");--}}
            $.toast({
                heading: 'info',
                text: "{{session('info')}}",
                showHideTransition: 'plain',
                position: 'bottom-right',
                stack: false,
                icon: 'info'
            });
        @endif
        @if(session('warning'))
        {{--toastr.warning("{{ session('warning') }}", "Warning");--}}
            $.toast({
                heading: 'Warning',
                text: "{{session('warning')}}",
                showHideTransition: 'plain',
                position: 'bottom-right',
                stack: false,
                icon: 'warning'
            });
        @endif
    })
</script>