<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - RestoApp</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex align-items-center py-4 bg-body-tertiary" style="min-height: 100vh;">

    <main class="form-signin w-100 m-auto" style="max-width: 400px; padding: 15px;">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4 p-sm-5">
                <!-- Logo atau Judul Brand -->
                <div class="text-center mb-4">
                    <h2 class="h3 fw-bold mb-2">Welcome Back</h2>
                    <p class="text-muted small">Silakan masuk ke akun Anda</p>
                </div>


               <!-- Alert untuk Error dari AJAX/API -->
                <div id="errorAlert" class="alert alert-danger d-none py-2 small" role="alert"></div> 

                <!-- Form Login -->
                <form method="POST" id="loginForm">
                    @csrf

                    <!-- Username -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" placeholder="Username" value="{{ old('username') }}" required autofocus>
                        <label for="floatingInput">Username</label>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <button class="w-100 btn btn-lg bg-black text-white rounded-3 py-2 fw-semibold" id="submitBtn" type="submit">Sign In</button>
                </form>

            </div>
        </div>
    </main>

</body>
<script>
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const errorAlert = document.getElementById('errorAlert');
        const submitBtn = document.getElementById('submitBtn');

        // Sembunyikan alert error dan aktifkan loading
        errorAlert.classList.add('d-none');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Signing in...';

        try {
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({
                    username,
                    password
                }),
                credentials: 'same-origin',
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // menyimpan session


                window.location.href = data.redirect || '/dashboard';

            } else {
                errorAlert.innerText =
                    data.message || 'Username atau password salah.';
                errorAlert.classList.remove('d-none');

                submitBtn.disabled = false;
                submitBtn.innerText = 'Sign In';
            }

        } catch (error) {
            console.error('Error:', error);

            errorAlert.innerText = 'Terjadi kesalahan pada server.';
            errorAlert.classList.remove('d-none');

            submitBtn.disabled = false;
            submitBtn.innerText = 'Sign In';
        }
    });
</script>
</html>