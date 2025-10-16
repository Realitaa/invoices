@props(['message', 'type' => 'error'])

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tentukan background berdasarkan type
        let backgroundColor = "{{ $type === 'success' ? 'var(--color-green-500)' : 'var(--color-red-500)' }}";

        Toastify({
            text: "{{ $message }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            style: {
                background: backgroundColor,
            }
        }).showToast();
    });
</script>