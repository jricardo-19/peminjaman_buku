    </div>
    <!-- Main Content End -->
</div>
<!-- App Wrapper End -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar')?.classList.toggle('active');
    });

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.closest('.input-icon').querySelector('input');
            var icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'ti ti-eye-off';
            } else {
                input.type = 'password';
                icon.className = 'ti ti-eye';
            }
        });
    });
</script>
</body>

</html>