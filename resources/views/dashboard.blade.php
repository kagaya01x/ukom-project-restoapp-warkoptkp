
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard RestoApp</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light p-5">

    <div class="container">
        <h1>Dashboard RestoApp</h1>

        <p class="lead">
            Selamat datang, {{ Auth::user()->username }}!
        </p>

        <form id="logoutForm">
            @csrf
            <button type="submit" class="btn btn-danger" id="logoutBtn">
                Logout
            </button>
        </form>
    </div>

    <script>
        document.getElementById('logoutForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const button = document.getElementById('logoutBtn');
            button.disabled = true;
            button.innerText = 'Logging out...';

            try {
                const response = await fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'Logout gagal.');
                    button.disabled = false;
                    button.innerText = 'Logout';
                }
            } catch (error) {
                console.error('Logout error:', error);
                alert('Terjadi kesalahan saat logout.');

                button.disabled = false;
                button.innerText = 'Logout';
            }
        });
    </script>

</body>
</html>
