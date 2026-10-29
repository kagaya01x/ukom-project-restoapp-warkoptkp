<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RestoApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light p-5">
    <div class="container">
        <h1>Dashboard RestoApp</h1>
        <p id="welcomeUser" class="lead">Memuat data user...</p>
        <button id="logoutBtn" class="btn btn-danger">Logout</button>
    </div>

    <script>
        // 1. Cek apakah token ada di localStorage saat halaman dibuka
        const token = localStorage.getItem('auth_token');
        if (!token) {
            // Jika tidak ada token, tendang kembali ke halaman login
            window.location.href = '/login';
        }

        // 2. Ambil data user yang sedang login menggunakan token Passport (via rute /api/user)
        async function fetchUserData() {
            try {
                const response = await fetch('/api/user', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token, // Kirim token Passport di header
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const user = await response.json();
                    document.getElementById('welcomeUser').innerText = `Selamat datang, ${user.username}!`;
                } else {
                    // Jika token invalid/expired, hapus token dan redirect ke login
                    localStorage.removeItem('auth_token');
                    window.location.href = '/login';
                }
            } catch (error) {
                console.error('Gagal memuat data user:', error);
            }
        }

        fetchUserData();

        // 3. Tombol Logout sederhana
        document.getElementById('logoutBtn').addEventListener('click', function() {
            localStorage.removeItem('auth_token');
            window.location.href = '/login';
        });
    </script>
</body>
</html>