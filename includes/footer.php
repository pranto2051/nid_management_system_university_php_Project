<footer class="bg-slate-900 text-white pt-12 pb-6 mt-20">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-id-card text-blue-400 text-2xl me-2"></i>
                    <span class="fw-bold text-xl">NID Management</span>
                </div>
                <p class="text-slate-400">Secure and efficient National Identity registration and management system for citizens.</p>
            </div>
            <div class="col-lg-2 offset-lg-1">
                <h5 class="fw-bold mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="index.php" class="text-slate-400 text-decoration-none hover:text-white transition-colors">Home</a></li>
                    <li class="mb-2"><a href="about.php" class="text-slate-400 text-decoration-none hover:text-white transition-colors">About Us</a></li>
                    <li class="mb-2"><a href="find-nid-form.php" class="text-slate-400 text-decoration-none hover:text-white transition-colors">Find NID</a></li>
                    <li class="mb-2"><a href="registration.php" class="text-slate-400 text-decoration-none hover:text-white transition-colors">Registration</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h5 class="fw-bold mb-4">Admin</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="admin/login.php" class="text-slate-400 text-decoration-none hover:text-white transition-colors">Admin Login</a></li>
                    <li class="mb-2"><a href="admin/dashboard.php" class="text-slate-400 text-decoration-none hover:text-white transition-colors">Dashboard</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5 class="fw-bold mb-4">Contact Us</h5>
                <p class="text-slate-400 mb-2"><i class="fas fa-envelope me-2"></i> info@nid-system.com</p>
                <p class="text-slate-400 mb-4"><i class="fas fa-phone me-2"></i> +1 234 567 890</p>
                <div class="d-flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 d-flex align-items-center justify-content-center text-white hover:bg-blue-600 transition-colors"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 d-flex align-items-center justify-content-center text-white hover:bg-blue-400 transition-colors"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 d-flex align-items-center justify-content-center text-white hover:bg-pink-600 transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 d-flex align-items-center justify-content-center text-white hover:bg-blue-800 transition-colors"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <hr class="border-slate-800 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-slate-500 mb-0">&copy; <?php echo date('Y'); ?> NID Management System. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <p class="text-slate-500 mb-0">Developed for University Project</p>
            </div>
        </div>
    </div>
</footer>

</footer>

<script>
    // Mobile menu auto-close on link click
    document.addEventListener('DOMContentLoaded', function() {
        const navbarCollapse = document.querySelector('.navbar-collapse');
        const navbarToggler = document.querySelector('.navbar-toggler');
        
        if (navbarCollapse && navbarToggler) {
            document.querySelectorAll('.navbar-collapse .nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (navbarCollapse.classList.contains('show')) {
                        navbarToggler.click();
                    }
                });
            });
        }
    });
</script>

<!-- Custom JS -->
<script src="assets/js/main.js"></script>
</body>
</html>
