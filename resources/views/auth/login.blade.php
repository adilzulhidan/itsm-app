<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JTEKT ITSM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            height: 100vh;
            /* Mengganti gradient dengan gambar background */
            background: linear-gradient(120deg, rgba(41, 127, 185, 0), rgba(141, 68, 173, 0.01)), 
                        url('/images/bg-login.JPG') no-repeat center center fixed;
            background-size: cover;
            display: flex; 
            align-items: center; 
            justify-content: center;
            position: relative;
        }
        
        /* Overlay untuk meningkatkan keterbacaan teks */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        
        /* Pastikan konten di atas overlay */
        .container {
            position: relative;
            z-index: 2;
        }
        
        .glass-card {
            background: #ffffff; /* Menggunakan putih solid */
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }
        .form-floating > .form-control:focus ~ label { color: #8e44ad; }
        .btn-login {
            background: linear-gradient(to right, #080808ff, #d71616ff);
            border: none; color: white; font-weight: bold;
            transition: transform 0.2s;
        }
        .btn-login:hover { transform: scale(1.02); color: white; }
        .login-header {
            background: #ffffff; /* Menggunakan putih solid */
            padding: 2rem; text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        /* Form input styling */
        .form-control {
            background-color: #ffffff; /* Putih solid untuk input */
            border: 1px solid #dee2e6;
        }
        
        .form-control:focus {
            background-color: #ffffff; /* Tetap putih saat focus */
            border-color: #8e44ad;
            box-shadow: 0 0 0 0.25rem rgba(142, 68, 173, 0.25);
        }
        
        /* Input group styling */
        .input-group-text {
            background-color: #ffffff; /* Putih solid untuk input group */
            border: 1px solid #dee2e6;
            border-left: none;
        }
        
        /* Footer styling */
        .bg-light {
            background-color: #ffffff !important; /* Putih solid untuk footer */
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        /* Fallback jika gambar tidak ditemukan */
        @media (max-width: 768px) {
            body {
                background: linear-gradient(120deg, #070707ff, #ca0000ff);
            }
            body::before {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="glass-card">
                <div class="login-header">
                    <!-- Logo JTEKT tanpa lingkaran -->
                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: auto; height: auto;">
                        <img src="/images/logo-jtekt.png" 
                             alt="Logo JTEKT" 
                             class="img-fluid"
                             style="max-height: 70px; width: auto;">
                    </div>
                    <h4 class="fw-bold text-dark mb-0">ITSM</h4>
                  
                </div>

                <div class="p-4 pt-3">
                    @if(session('error') || $errors->any())
                        <div class="alert alert-danger py-2 text-center small rounded-3">
                            <i class="bi bi-x-circle me-1"></i> Login Gagal. Cek email/password.
                        </div>
                    @endif

                    <form action="{{ route('login.perform') }}" method="POST">
                        @csrf
                        
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control rounded-3" id="email" placeholder="Email" required>
                            <label for="email"><i class="bi bi-envelope me-1"></i> Email Perusahaan</label>
                        </div>

                        <div class="input-group mb-3">
                            <div class="form-floating flex-grow-1">
                                <input type="password" name="password" class="form-control rounded-3" id="password" placeholder="Password" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" required>
                                <label for="password"><i class="bi bi-lock me-1"></i> Password</label>
                            </div>
                            <span class="input-group-text bg-white" style="cursor: pointer;" onclick="togglePass()">
                                <i class="bi bi-eye-slash text-muted" id="iconPass"></i>
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label small text-secondary" for="remember">Remember me</label>
                            </div>
                            <a href="#" class="small text-decoration-none text-secondary">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn btn-login w-100 py-3 rounded-pill shadow-sm">
                            SIGN IN
                        </button>
                    </form>
                </div>
                
                <div class="bg-light p-3 text-center border-top">
                    <small class="text-muted" style="font-size: 0.75rem;">
                        Butuh akses? Hubungi <a href="#" class="fw-bold text-decoration-none text-primary">IT Administrator</a>
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function togglePass() {
        var x = document.getElementById("password");
        var icon = document.getElementById("iconPass");
        if (x.type === "password") {
            x.type = "text";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        } else {
            x.type = "password";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        }
    }
    
    // Fallback jika gambar tidak ditemukan
    window.addEventListener('load', function() {
        const bgImage = new Image();
        bgImage.src = '/images/bg-login.JPG';
        
        bgImage.onerror = function() {
            console.log('Background image failed to load, using gradient fallback');
           
        };
    });
</script>

</body>
</html>