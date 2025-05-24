<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HRMagnet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <style>
        body {
            background-color: #f5f6fa;
        }

        .navbar {
            background-color: #640032;
        }

        .bg-brown-header {
            background-color:  #640032;/
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar-brand span {
            color: #bbbbbb;
        }

        .nav-link {
            color: white !important;
            margin-right: 1rem;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .profile-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .action-btns .btn {
            margin-right: 5px;
        }

        .pagination .page-link {
            color: #640032;
        }

        .pagination .active .page-link {
            background-color: #640032;
            border-color: #640032;
        }

        .gear-icon {
            font-size: 18px;
            margin-right: 15px;
            color: #ccc;
            text-decoration: none;
        }

        .gear-icon:hover {
            color: white;
        }

        .navbar-nav .nav-item:last-child {
            margin-right: 0;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg px-3">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('diplomas.index') }}">
            <img src="{{ asset('storage/images/certificat.jpg') }}" alt="Logo" class="me-2 img-thumbnail"
                style="width: 30px; height: 30px; object-fit: cover;">

        </a>

        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto ms-3">
                <li class="nav-item"><a class="nav-link" href="{{ route('diplomas.index') }}">Manage Diploma</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('bacs.index') }}">Manage Bac</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Log out</a></li>
            </ul>

            <div class="d-flex align-items-center">
                <a href="{{ route('profile.show') }}" class="gear-icon"><i class="fas fa-cog"></i></a>
                @php
                    use Illuminate\Support\Str;

                    $photo = Session::get('user_profile');
                    $photoUrl = $photo
                        ? (Str::contains($photo, 'images')
                            ? asset('storage/' . $photo)
                            : $photo)
                        : asset('storage/images/woman.png');
                @endphp

                <img src="{{ $photoUrl }}" alt="user photo" class="profile-img ms-2" />
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        @yield('content')
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    @stack('scripts')

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
