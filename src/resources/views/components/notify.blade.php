<div id="laravel-notify">
    {{ session()->forget('notify.message') }}

    <script>
        var notify = {
            timeout: "{{ config('notify.timeout') }}",
        }
    </script>
</div>