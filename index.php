<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupon Complaint Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background:
                linear-gradient(135deg,
                    #1e3c00 0%,
                    #2d5a27 25%,
                    #3d7a3d 50%,
                    #2d5a27 75%,
                    #1e3c00 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, .15);
            z-index: 1030;
        }

        .glass-card {
            background: rgba(255, 255, 255, .95);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        }

        .feature-card {
            transition: .3s;
        }

        .feature-card:hover {
            transform: translateY(-8px);
        }

        .hero {
            min-height: 90vh;
            display: flex;
            align-items: center;
        }

        .btn-custom {
            background:
                linear-gradient(135deg,
                    #28a745 0%,
                    #1e7e34 100%);
            border: none;
        }

        .section-title {
            font-weight: 700;
            color: #198754;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #198754;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: auto;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">

        <div class="container">

            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-shield-check"></i>
                Lupon Complaint System
            </a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a href="#features" class="nav-link text-white fw-semibold ">
                            Features
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#process" class="nav-link text-white fw-semibold ">
                            Process
                        </a>
                    </li>

                    <li class="nav-item ms-lg-3">
                        <a href="login.php" class="btn btn-success">
                            Login
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <!-- HERO -->

    <section class="hero">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6 text-white">

                    <span class="badge bg-success mb-3 p-2">
                        Barangay Lupon
                    </span>

                    <h1 class="display-4 fw-bold mb-3">
                        Resolve Community Disputes Efficiently
                    </h1>

                    <p class="lead mb-4">

                        Submit complaints online, track progress,
                        receive hearing schedules, and monitor
                        resolutions from anywhere.

                    </p>

                    <a href="register.php" class="btn btn-light btn-lg me-2">

                        <i class="bi bi-person-plus"></i>
                        Register

                    </a>

                    <a href="login.php" class="btn btn-success btn-lg">

                        <i class="bi bi-box-arrow-in-right"></i>
                        Login

                    </a>

                </div>

                <div class="col-lg-6">

                    <div class="glass-card p-5 text-center">

                        <i class="bi bi-shield-check" style="font-size:5rem;color:#198754;">
                        </i>

                        <h3 class="fw-bold mt-3">
                            Lupon Complaint System
                        </h3>

                        <p class="text-muted">

                            Digital platform for complaint filing,
                            mediation scheduling and resolution tracking.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- FEATURES -->

    <section class="py-5" id="features">

        <div class="container">

            <div class="text-center text-white mb-5">

                <h2 class="fw-bold">
                    System Features
                </h2>

                <p>
                    Everything needed to manage complaints digitally.
                </p>

            </div>

            <div class="row g-4">

                <div class="col-md-4">

                    <div class="glass-card feature-card h-100 p-4 text-center">

                        <div class="icon-circle mb-3">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>

                        <h5 class="fw-bold">
                            Online Filing
                        </h5>

                        <p class="text-muted">
                            Submit complaints without visiting the barangay office.
                        </p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="glass-card feature-card h-100 p-4 text-center">

                        <div class="icon-circle mb-3">
                            <i class="bi bi-search"></i>
                        </div>

                        <h5 class="fw-bold">
                            Case Tracking
                        </h5>

                        <p class="text-muted">
                            Monitor complaint status in real time.
                        </p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="glass-card feature-card h-100 p-4 text-center">

                        <div class="icon-circle mb-3">
                            <i class="bi bi-calendar-event"></i>
                        </div>

                        <h5 class="fw-bold">
                            Hearing Schedule
                        </h5>

                        <p class="text-muted">
                            View mediation schedules and updates online.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- PROCESS -->

    <section class="pb-5" id="process">

        <div class="container">

            <div class="glass-card p-5">

                <div class="text-center mb-5">

                    <h2 class="section-title">
                        How It Works
                    </h2>

                </div>

                <div class="row text-center">

                    <div class="col-md-3">

                        <h1 class="text-success">
                            <i class="bi bi-pencil-square"></i>
                        </h1>

                        <h6>1. File</h6>

                    </div>

                    <div class="col-md-3">

                        <h1 class="text-success">
                            <i class="bi bi-clipboard-check"></i>
                        </h1>

                        <h6>2. Review</h6>

                    </div>

                    <div class="col-md-3">

                        <h1 class="text-success">
                            <i class="bi bi-calendar2-check"></i>
                        </h1>

                        <h6>3. Hearing</h6>

                    </div>

                    <div class="col-md-3">

                        <h1 class="text-success">
                            <i class="bi bi-check-circle"></i>
                        </h1>

                        <h6>4. Resolution</h6>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- FOOTER -->

    <footer class="text-center text-white py-4">

        <p class="mb-0">
            © <?= date('Y') ?> Lupon Complaint Management System
        </p>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
