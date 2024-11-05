<html>

<head>
    <title>
        POLINEMA Manage Pelatihan &amp; Sertifikasi
    </title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background-size: cover;
        }

        /* Background image with overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("{{ asset('assets/JTI.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            z-index: -2;
        }

        /* Dark blue overlay */
        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(26, 42, 79, 0.7);
            /* Biru gelap dengan transparansi 70% */
            z-index: -1;
        }


        .header {
            background-color: #1a3e7a;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            height: 50px;
        }

        .header .title {
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .header .logo {
            display: flex;
            align-items: center;
        }

        .header .logo img {
            height: 50px;
            margin-left: 10px;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100% - 70px);
            padding: 0 50px;
            gap: 100px;

            /* Menambahkan jarak 100px antara elemen flex */
        }

        .content .left {
            color: white;
        }

        .content .left h1 {
            font-family: Tahoma;
            font-size: 80px;
            margin: 0;
            font-weight: bold;
            
        }

        .content .left h2 {
            font-size: 80px;
            font-family: Tahoma;
            color: #FFB61D;
            margin: 0;
            font-weight: bold;

        }

        .content .right {
            background: #f5f5f5;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .content .right h3 {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
            text-align: center;
        }

        .content .right .form-group {
            margin-bottom: 20px;
        }

        .content .right .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .content .right .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #EBEBEB;
            
        }

        .content .right .form-group .password-toggle {
            position: relative;
        }

        .content .right .form-group .password-toggle input {
            padding-right: 40px;
        }

        .content .right .form-group .password-toggle .toggle-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .content .right .form-group .toggle-icon i {
            font-size: 18px;
        }

        .content .right .form-group .toggle-icon i.fa-eye {
            display: none;
        }

        .content .right .form-group .toggle-icon i.fa-eye-slash {
            display: block;
        }

        .content .right .form-group .toggle-icon.show i.fa-eye {
            display: block;
        }

        .content .right .form-group .toggle-icon.show i.fa-eye-slash {
            display: none;
        }

        .content .right .form-group .toggle-icon.show+input {
            type: text;
        }

        .content .right .form-group .toggle-icon:not(.show)+input {
            type: password;
        }

        .content .right .form-group .toggle-icon.show+input[type="password"] {
            type: text;
        }

        .content .right .form-group .toggle-icon:not(.show)+input[type="text"] {
            type: password;
        }

        .content .right .btn {
            width: 100%;
            padding: 10px;
            background: #7797CD;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .content .right .btn:hover {
            background: #357ab8;
        }

        .content .right .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .content .right .register-link a {
            color: #4a90e2;
            text-decoration: none;
        }
    </style>
</head>


<body>
    <div class="header">
        <div class="logo">
            <img alt="Polinema Logo" height="50" src="{{ asset('assets/polinema-logo.png') }}" width="50" />
            <div class="title">
                POLITEKNIK NEGERI MALANG
            </div>
            <img alt=" Logo" height="50" src="{{ asset('assets/jti-logo.png') }}" width="50" />
        </div>
    </div>
    <div class="content">
        <div class="left">
            <h1>
                POLINEMA
            </h1>
            <h2>
                Manage <br>Pelatihan &amp; <br>Sertifikasi
            </h2>
        </div>
        <div class="right">
            <h3>
                Silahkan Melakukan Login Akun Sistem Pendataan Pelatihan dan Sertifikasi
            </h3>
            <form action="{{ url('login') }}" method="POST" id="form-login">
                @csrf
                <div class="form-group">
                    <label for="nama_pengguna">
                        Nama Pengguna
                    </label>
                    <input id="nama_pengguna" name="nama_pengguna" placeholder="Contoh : Rismawati" type="text" />
                    <small id="error-username" class="error-text text-danger"></small>
                </div>
                <div class="form-group password-toggle">
                    <label for="password">
                        Kata Sandi
                    </label>
                    <input id="password" name="password" type="password" />
                    <div class="toggle-icon" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                        <i class="fas fa-eye-slash"></i>
                    </div>
                    <small id="error-password" class="error-text text-danger"></small>
                </div>
                <button type="submit" class="btn">
                    Sign In
                </button>
                <div class="register-link">
                    Belum punya akun?
                    <a href="{{ url('register') }}">
                        Daftar Sekarang
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.add('show');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('show');
            }
        }
    </script>


    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $("#form-login").validate({
                rules: {
                    nama_pengguna: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 5,
                        maxlength: 20
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(function () {
                                    window.location = response.redirect;
                                });
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>