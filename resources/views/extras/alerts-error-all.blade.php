@if($errors->any())
<script>
    window.onload = function() {
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    };
</script>
@endif