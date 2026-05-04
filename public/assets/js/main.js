// JavaScript para interacciones básicas del sistema
document.addEventListener('DOMContentLoaded', () => {
    // Autocierre de alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Confirmación para acciones críticas
    const deleteButtons = document.querySelectorAll('.btn-danger');
    // Ya implementado con onsubmit en los formularios
});
