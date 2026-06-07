<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Kalian Lupon iPortal
        - Barangay Dispute Resolution</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3c00 0%, #2d5a27 25%, #3d7a3d 50%, #2d5a27 75%, #1e3c00 100%);
            --accent-color: #4ade80;
            --dark-green: #1e3c00;
            --light-green: #3d7a3d;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #1f2937;
            scroll-behavior: smooth;
        }

        .bg-primary-gradient {
            background: var(--primary-gradient);
        }

        .text-accent {
            color: var(--accent-color) !important;
        }

        .btn-accent {
            background: var(--accent-color);
            color: var(--dark-green);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-accent:hover {
            background: #22c55e;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(74, 222, 128, 0.3);
        }

        .btn-outline-accent {
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            background: transparent;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-accent:hover {
            background: var(--accent-color);
            color: var(--dark-green);
            transform: translateY(-2px);
        }

        /* Navbar */
        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(30, 60, 0, 0.95) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        /* Hero Section */
        .hero {
            background: var(--primary-gradient);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            animation: fadeInUp 0.8s ease;
        }

        .hero p {
            font-size: 1.25rem;
            animation: fadeInUp 1s ease;
        }

        .hero .btn {
            animation: fadeInUp 1.2s ease;
        }

        .hero-img {
            animation: float 6s ease-in-out infinite;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Features */
        .feature-card {
            border: none;
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(45, 90, 39, 0.15);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: var(--primary-gradient);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: rotate(5deg) scale(1.1);
        }

        .feature-icon i {
            font-size: 2rem;
            color: white;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* CTA Section */
        .cta-section {
            background: var(--primary-gradient);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -150px;
            right: -150px;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }

        /* Footer */
        footer {
            background: #0f1f0a;
        }

        footer a {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--accent-color);
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: var(--accent-color);
            color: var(--dark-green);
            transform: translateY(-3px);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero {
                min-height: auto;
                padding: 120px 0 60px;
            }

            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-geo-alt fs-3 me-2 text-accent"></i>
                <span>Kalian Lupon iPortal</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="#home">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="#features">Features</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a class="btn btn-accent px-4 py-2 rounded-pill" href="login.php">
                            <i class="bi bi-pencil-square me-1"></i> File Complaint
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center hero-content">
                <div class="col-lg-6 text-white">
                    <span class="badge bg-white bg-opacity-10 text-white px-3 py-2 rounded-pill mb-3">
                        <i class="bi bi-shield-check me-1"></i> Brgy. Kalian Margosatubig, Zamboanga del Sur
                    </span>
                    <h1 class="mb-4"> Kalian<span class="text-accent"> Lupon</span> <br> iPortal</h1>
                    <p class="lead mb-4 opacity-90">Digital platform for filing complaints, tracking cases, and
                        mediation management..</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="login.php" class="btn btn-accent btn-lg px-5 py-3 rounded-pill">
                            <i class="bi bi-send-fill me-2"></i>Get Started
                        </a>
                        <a href="#features" class="btn btn-outline-accent btn-lg px-5 py-3 rounded-pill">
                            <i class="bi bi-play-circle me-2"></i>Learn More
                        </a>
                    </div>
                    <div class="d-flex gap-4 mt-5">
                        <div>
                            <h3 class="text-white fw-bold mb-0">300+</h3>
                            <small class="opacity-75">Cases Resolved</small>
                        </div>
                        <div>
                            <h3 class="text-white fw-bold mb-0">98%</h3>
                            <small class="opacity-75">Satisfaction Rate</small>
                        </div>
                        <div>
                            <h3 class="text-white fw-bold mb-0">24/7</h3>
                            <small class="opacity-75">Access</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <div class="hero-img">
                        <svg width="500" height="400" viewBox="0 0 500 400" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="50" y="80" width="400" height="280" rx="20" fill="white" fill-opacity="0.1"
                                stroke="white" stroke-opacity="0.2" stroke-width="2" />
                            <rect x="80" y="110" width="340" height="40" rx="8" fill="white" fill-opacity="0.15" />
                            <rect x="80" y="170" width="160" height="25" rx="6" fill="white" fill-opacity="0.1" />
                            <rect x="260" y="170" width="160" height="25" rx="6" fill="white" fill-opacity="0.1" />
                            <rect x="80" y="210" width="340" height="25" rx="6" fill="white" fill-opacity="0.1" />
                            <rect x="80" y="250" width="220" height="25" rx="6" fill="white" fill-opacity="0.1" />
                            <rect x="80" y="290" width="120" height="40" rx="8" fill="#4ade80" />
                            <circle cx="380" cy="300" r="30" fill="#4ade80" fill-opacity="0.8" />
                            <path d="M370 300L376 306L390 292" stroke="white" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-4 col-4">
                    <div class="stat-card">
                        <div class="stat-number" data-count="150">0</div>
                        <p class="text-muted mb-0">Active Cases</p>
                    </div>
                </div>
                <div class="col-md-4 col-4">
                    <div class="stat-card">
                        <div class="stat-number" data-count="19">0</div>
                        <p class="text-muted mb-0">Mediators</p>
                    </div>
                </div>
                <div class="col-md-4 col-4">
                    <div class="stat-card">
                        <div class="stat-number" data-count="320">0</div>
                        <p class="text-muted mb-0">Resolved Disputes</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 py-lg-6">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <span class="badge bg-primary-gradient text-white px-3 py-2 rounded-pill mb-3">Core Features</span>
                    <h2 class="display-5 fw-bold mb-3">Everything You Need for <br>Barangay Justice</h2>
                    <p class="lead text-muted">Kalian Lupon iPortal – Complaint Management System</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card p-4">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Complaint Filing</h4>
                        <p class="text-muted mb-4">Submit complaints online 24/7 with our intuitive form. Upload
                            evidence, add witnesses, and receive instant confirmation with case number.</p>
                        <a href="#" class="text-accent fw-semibold text-decoration-none">
                            Learn More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card p-4">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Case Tracking</h4>
                        <p class="text-muted mb-4">Monitor your case status in real-time. Get email
                            notifications for hearing schedules, mediations, and case resolutions.</p>
                        <a href="#" class="text-accent fw-semibold text-decoration-none">
                            Learn More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card p-4">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Barangay Mediation</h4>
                        <p class="text-muted mb-4">Schedule mediation sessions with certified Lupon members. Access
                            forms, generate agreements, and manage the entire conciliation process.</p>
                        <a href="#" class="text-accent fw-semibold text-decoration-none">
                            Learn More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card p-4">
                        <div class="feature-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Secure & Confidential</h4>
                        <p class="text-muted mb-4">Bank-level encryption ensures all case details remain private.
                            Role-based access control protects sensitive information.</p>
                        <a href="#" class="text-accent fw-semibold text-decoration-none">
                            Learn More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card p-4">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Scheduling System</h4>
                        <p class="text-muted mb-4">Automated hearing calendar with conflict detection. Send invitations
                            to parties and sync with barangay officials' calendars.</p>
                        <a href="#" class="text-accent fw-semibold text-decoration-none">
                            Learn More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card p-4">
                        <div class="feature-icon">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Document Generation</h4>
                        <p class="text-muted mb-4">Auto-generate Forms, summons, minutes, and settlement agreements.
                            Export to PDF with digital signatures included.</p>
                        <a href="#" class="text-accent fw-semibold text-decoration-none">
                            Learn More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <span class="badge bg-primary-gradient text-white px-3 py-2 rounded-pill mb-3">Process</span>
                    <h2 class="display-5 fw-bold mb-3">How It Works</h2>
                    <p class="lead text-muted">Simple 3-step process to resolve disputes efficiently</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="text-center p-4">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 100px; height: 100px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <span class="display-4 fw-bold text-accent">1</span>
                            </div>
                            <h4 class="fw-bold mb-3">File Complaint</h4>
                            <p class="text-muted">Submit your complaint online. Provide
                                details and supporting documents.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-center p-4">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 100px; height: 100px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <span class="display-4 fw-bold text-accent">2</span>
                            </div>
                            <h4 class="fw-bold mb-3">Mediation Session</h4>
                            <p class="text-muted">Attend mediation via Zoom with a Lupon member to reach an amicable
                                settlement.</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-center p-4">
                            <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 100px; height: 100px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <span class="display-4 fw-bold text-accent">3</span>
                            </div>
                            <h4 class="fw-bold mb-3">Resolution</h4>
                            <p class="text-muted">Sign the agreement and receive official documentation. Case closed
                                with digital records maintained.</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- CTA Section -->
    <section id="file-complaint" class="cta-section py-5">
        <div class="container py-5 position-relative" style="z-index: 2;">
            <div class="row justify-content-center text-center text-white">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold mb-4">Ready to File a Complaint?</h2>
                    <p class="lead mb-5 opacity-90">Start your dispute resolution process today. Our system makes it
                        easy, secure, and efficient.</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="#" class="btn btn-accent btn-lg px-5 py-3 rounded-pill">
                            <i class="bi bi-pencil-square me-2"></i>File New Complaint
                        </a>
                        <a href="#" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill">
                            <i class="bi bi-search me-2"></i>Track Existing Case
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="py-5 text-center">
        <div class="container">

            <!-- Brand -->
            <div class="mb-3">
                <i class="bi bi-bank2 fs-2 text-accent d-block mb-2"></i>
                <h5 class="text-white mb-0">Kalian Lupon iPortal</h5>
            </div>

            <!-- Description -->
            <p class="text-white mb-4">
                Kalian Lupon iPortal: Digital Dispute Resolution System
            </p>

            <!-- Social Links -->
            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="#" class="social-icon">
                    <i class="bi bi-facebook text-white"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="bi bi-twitter-x text-white"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="bi bi-envelope text-white"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="bi bi-phone text-white"></i>
                </a>
            </div>

            <hr class="border-secondary">

            <!-- Copyright -->
            <p class="text-white mb-0">
                © <span class="text-accent" id="year">2026</span> Kalian Lupon iPortal. All rights reserved.
            </p>

        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.padding = '0.5rem 0';
            } else {
                navbar.style.padding = '1rem 0';
            }
        });

        // Animated counter for stats
        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.stat-number');
                    counters.forEach(counter => {
                        const target = parseInt(counter.getAttribute('data-count'));
                        const duration = 2000;
                        const increment = target / (duration / 16);
                        let current = 0;

                        const updateCounter = () => {
                            current += increment;
                            if (current < target) {
                                counter.textContent = Math.floor(current).toLocaleString();
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.textContent = target.toLocaleString();
                            }
                        };
                        updateCounter();
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    const offset = 80;
                    const elementPosition = document.querySelector(href).offsetTop;
                    window.scrollTo({
                        top: elementPosition - offset,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    <script>(function () { document.addEventListener("click", function (e) { var a = e.target.closest("[data-product-id]"); if (!a) return; e.preventDefault(); var pid = a.getAttribute("data-product-id"); if (pid) parent.postMessage({ type: "ecto-artifact-link-click", productId: pid }, "*") }) })();</script>
</body>

</html>
