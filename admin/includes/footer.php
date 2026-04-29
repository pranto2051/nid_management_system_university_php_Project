    <footer class="mt-auto py-4 text-center text-slate-500 small">
        &copy; <?php echo date('Y'); ?> NID Management System Admin Panel.
    </footer>
</div> <!-- End main-right -->
</div> <!-- End body-row -->
</div> <!-- End dashboard-container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar toggle
    document.getElementById('sidebarToggle')?.addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('sidebar').classList.toggle('show');
    });
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebarToggle');
        
        if (sidebar && window.innerWidth <= 991.98) {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
    
    // Close sidebar when a nav link is clicked
    document.querySelectorAll('.nav-link-admin').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 991.98) {
                document.getElementById('sidebar').classList.remove('show');
            }
        });
    });
</script>
</body>
</html>
