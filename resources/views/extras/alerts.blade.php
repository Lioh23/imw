
@if(session('success'))
<script>
    window.onload = function(e) {
        toastr.success("{{ session('success') }}");
    };
</script>
@endif

@if(session('error'))
<script>
    window.onload = function(e) {
        toastr.success("{{ session('error') }}");
    };
</script>
@endif