<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="relative overflow-hidden py-24 sm:py-32">
    <!-- Background Gradient -->
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.blue.100),theme(colors.white))] opacity-20"></div>
    <div class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white shadow-xl shadow-blue-600/10 ring-1 ring-blue-50 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center"></div>

    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-3 fw-bold text-slate-900 mb-4 animate__animated animate__fadeInLeft">
                    Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-emerald-500">NID Management</span> System
                </h1>
                <p class="lead text-slate-600 mb-5 fs-4 animate__animated animate__fadeInLeft animate__delay-1s">
                    Secure National Identity Registration and Verification. Your identity, protected and accessible with just a few clicks.
                </p>
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 animate__animated animate__fadeInUp animate__delay-2s">
                    <a href="find-nid-form.php" class="btn btn-primary-custom btn-lg shadow-lg">
                        <i class="fas fa-search me-2"></i>Find NID Card
                    </a>
                    <a href="registration.php" class="btn btn-outline-dark btn-lg px-4 py-2 rounded-lg font-semibold hover:bg-slate-900 hover:text-white transition-all">
                        <i class="fas fa-user-plus me-2"></i>Register Now
                    </a>
                </div>
            </div>
            <div class="col-lg-6 animate__animated animate__fadeInRight">
                <div class="glass-card p-4 p-md-5 text-center transform hover:scale-105 transition-transform duration-500">
                    <img src="https://img.freepik.com/free-vector/security-concept-illustration_114360-497.jpg" alt="Security Illustration" class="img-fluid rounded-3 mb-4 shadow-sm">
                    <div class="d-flex justify-content-center gap-4 mt-2">
                        <div class="text-center">
                            <h3 class="fw-bold text-blue-600 mb-0">10k+</h3>
                            <p class="small text-slate-500">Users</p>
                        </div>
                        <div class="vr"></div>
                        <div class="text-center">
                            <h3 class="fw-bold text-emerald-500 mb-0">100%</h3>
                            <p class="small text-slate-500">Secure</p>
                        </div>
                        <div class="vr"></div>
                        <div class="text-center">
                            <h3 class="fw-bold text-blue-600 mb-0">24/7</h3>
                            <p class="small text-slate-500">Support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-white">
    <div class="container">
        <div class="text-center mb-16">
            <h2 class="display-5 fw-bold text-slate-900 mb-3">Our Key Features</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
        </div>
        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 rounded-4 hover:shadow-xl transition-shadow border-t-4 border-blue-500">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl d-flex align-items-center justify-content-center mb-4 text-blue-600 fs-2">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Fast Search</h4>
                    <p class="text-slate-600">Instantly locate your National ID information using our high-speed database search engine.</p>
                </div>
            </div>
            <!-- Feature 2 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 rounded-4 hover:shadow-xl transition-shadow border-t-4 border-emerald-500">
                    <div class="w-16 h-16 bg-emerald-100 rounded-2xl d-flex align-items-center justify-content-center mb-4 text-emerald-600 fs-2">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Secure Registration</h4>
                    <p class="text-slate-600">Advanced encryption ensures your personal data remains private and protected during registration.</p>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 rounded-4 hover:shadow-xl transition-shadow border-t-4 border-purple-500">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl d-flex align-items-center justify-content-center mb-4 text-purple-600 fs-2">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Admin Control</h4>
                    <p class="text-slate-600">Powerful administrative dashboard for managing user records and system configurations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-emerald-500 text-white">
    <div class="container text-center">
        <h2 class="display-6 fw-bold mb-4">Ready to get your digital NID?</h2>
        <p class="lead mb-5 opacity-90">Join thousands of citizens who have already registered for a smarter future.</p>
        <a href="registration.php" class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold text-blue-600 shadow-lg hover:scale-105 transition-transform">
            Start Registration <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
