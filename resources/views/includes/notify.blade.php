@push('js')
	{{-- expr --}}
<script type="text/javascript">
    $(document).ready(function(){
            @if ($message = session('success'))
                $.toast({
                    heading: 'Success',
                    text: "{{$message}}",
                    position: 'bottom-right',
                    stack: false,
                    icon: 'success',
                    hideAfter: 8000
                });
            @endif
            @if ($message = session('error'))
                $.toast({
                    heading: 'Error',
                    text: "{{$message}}",
                    position: 'bottom-right',
                    stack: false,
                    icon: 'error',
                    hideAfter: 8000
                });
            @endif

            @if ($message = session('warning'))
                $.toast({
                    heading: 'Warning',
                    text: "{{$message}}",
                    position: 'bottom-right',
                    stack: false,
                    icon: 'warning',
                    hideAfter: 8000
                });
            @endif


            @if ($message = session('info'))
                $.toast({
                    heading: 'Info',
                    text: "{{$message}}",
                    position: 'bottom-right',
                    stack: false,
                    icon: 'info',
                    hideAfter: 8000
                });
            @endif

            @if ($errors->any())
                var msg = '';
                @foreach ($errors->all() as $error)
                    msg = msg + "- {{ $error }} <br/>";
                @endforeach
                $.toast({
                    heading: 'error',
                    text: msg,
                    position: 'bottom-right',
                    stack: false,
                    icon: 'error',
                    hideAfter: 8000
                });
            @endif
    });
    
</script>
@endpush