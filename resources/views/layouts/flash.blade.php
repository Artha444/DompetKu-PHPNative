@if(session('success'))
<script>
    Swal.fire('Berhasil!', '{{ session('success') }}', 'success');
</script>
@endif

@if(session('error'))
<script>
    Swal.fire('Gagal', '{{ session('error') }}', 'error');
</script>
@endif