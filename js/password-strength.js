document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('pass');
    if(passwordInput) {
        const strengthMeter = document.getElementById('password-strength');
        const strengthBar = strengthMeter.querySelector('.strength-bar');
        const strengthText = strengthMeter.querySelector('.strength-text');
        
        passwordInput.addEventListener('input', function() {
            const strength = calcularFortalezaContraseña(this.value);
            
            // Actualizar barra visual
            strengthBar.style.width = strength.porcentaje + '%';
            strengthBar.style.backgroundColor = strength.color;
            
            // Actualizar texto accesible
            strengthText.textContent = 'Fortaleza: ' + strength.texto;
            strengthMeter.setAttribute('data-strength', strength.nivel);
            
            // Actualizar atributos ARIA
            strengthMeter.setAttribute('aria-valuenow', strength.nivel);
            strengthMeter.setAttribute('aria-valuetext', strength.texto);
            strengthMeter.setAttribute('aria-valuemin', 0);
            strengthMeter.setAttribute('aria-valuemax', 4);
        });
        
        // Función para calcular fortaleza
        function calcularFortalezaContraseña(password) {
            let strength = 0;
            let messages = [];
            
            // Longitud mínima
            if (password.length >= 8) strength += 1;
            else messages.push('Muy corta');
            
            // Contiene números
            if (/\d/.test(password)) strength += 1;
            else messages.push('Falta número');
            
            // Contiene mayúsculas
            if (/[A-Z]/.test(password)) strength += 1;
            else messages.push('Falta mayúscula');
            
            // Contiene caracteres especiales
            if (/[\W_]/.test(password)) strength += 1;
            else messages.push('Falta símbolo');
            
            // Niveles de fortaleza
            const niveles = [
                { texto: "Muy débil", color: "#e53e3e" },
                { texto: "Débil", color: "#dd6b20" },
                { texto: "Moderada", color: "#d69e2e" },
                { texto: "Fuerte", color: "#38a169" },
                { texto: "Muy fuerte", color: "#2f855a" }
            ];
            
            return {
                nivel: strength,
                porcentaje: (strength / 4) * 100,
                texto: niveles[strength].texto,
                color: niveles[strength].color,
                messages: messages
            };
        }
    }
});