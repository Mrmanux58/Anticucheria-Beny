document.addEventListener('DOMContentLoaded', function() {
    // Alternar visibilidad de contraseña
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            // Cambiar ícono y texto ARIA
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
            
            const label = type === 'password' ? 'Mostrar contraseña' : 'Ocultar contraseña';
            this.setAttribute('aria-label', label);
        });
    });

    // Validación en tiempo real del nombre
    const nameInput = document.getElementById('name');
    if(nameInput) {
        nameInput.addEventListener('input', function() {
            const helpText = document.getElementById('name-help');
            if(this.validity.patternMismatch) {
                helpText.style.color = '#e53e3e';
            } else {
                helpText.style.color = '';
            }
        });
    }

    // Validación en tiempo real del email
    const emailInput = document.getElementById('email');
    if(emailInput) {
        emailInput.addEventListener('input', function() {
            const helpText = document.getElementById('email-help');
            if(this.validity.typeMismatch) {
                helpText.style.color = '#e53e3e';
            } else {
                helpText.style.color = '';
            }
        });
    }

    // Enfoque en el primer campo con error al enviar
    const form = document.getElementById('registerForm');
    if(form) {
        form.addEventListener('submit', function(event) {
            const invalidFields = Array.from(this.elements).filter(field => !field.validity.valid);
            
            if(invalidFields.length > 0) {
                event.preventDefault();
                invalidFields[0].focus();
                
                // Asegurar que los mensajes de error sean accesibles
                const errorContainer = document.querySelector('.message-container');
                if(errorContainer) {
                    errorContainer.setAttribute('role', 'alert');
                    errorContainer.setAttribute('aria-live', 'assertive');
                }
            }
        });
    }

    // Mejorar navegación por teclado en formularios
    document.querySelectorAll('input, button, select, textarea').forEach(element => {
        element.addEventListener('keydown', function(e) {
            if(e.key === 'Enter' && this.tagName !== 'BUTTON' && this.tagName !== 'INPUT' && this.type !== 'submit') {
                e.preventDefault();
            }
        });
    });

    // Soporte para usuarios que prefieren reducir movimiento
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if(reduceMotion) {
        document.querySelectorAll('[data-animation]').forEach(element => {
            element.style.animation = 'none';
        });
    }
});