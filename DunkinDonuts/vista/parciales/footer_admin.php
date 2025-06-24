</main>
    </div>

    <?php if (isset($_SESSION['admin_tipo']) && $_SESSION['admin_tipo'] === 'encargado'): ?>
        <script src="../js/admin.js"></script>
    <?php else: ?>
        <script src="../js/empleado.js"></script>
    <?php endif; ?>
</body>
</html>