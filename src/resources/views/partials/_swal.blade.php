<script>
    window.addEventListener('swal', function(e) {
        // Swal.fire(e.detail);
        Swal.fire({
            title: e.detail.title,
            icon: e.detail.icon,
            iconColor: e.detail.iconColor,
            timer: 3000,
            toast: true,
            position: 'top-right',
            toast: true,
            showConfirmButton: false,
        });
    });
</script>