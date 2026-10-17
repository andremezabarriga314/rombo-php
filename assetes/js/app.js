
document.addEventListener('DOMContentLoaded', function () {
    // ==========================================
    // LOGIN
    // ==========================================
    // El inicio de sesión se valida mediante PHP.
    // No interceptamos el formulario para permitir
    // que AuthController procese las credenciales.


    // ==========================================
    // CÁLCULO DE CIRCUNFERENCIA
    // ==========================================
    function calcularCircunferencia() {
        const radioInput = document.getElementById('txtRadio');
        const areaInput = document.getElementById('txtA');
        const perimetroInput = document.getElementById('txtP');

        if (!radioInput || !areaInput || !perimetroInput) {
            return;
        }

        const radio = parseFloat(radioInput.value);

        if (
            radioInput.value.trim() === '' ||
            !Number.isFinite(radio) ||
            radio <= 0
        ) {
            areaInput.value = '';
            perimetroInput.value = '';
            return;
        }

        const area = Math.PI * radio * radio;
        const perimetro = 2 * Math.PI * radio;

        areaInput.value = area.toFixed(2);
        perimetroInput.value = perimetro.toFixed(2);
    }

    const radioInput = document.getElementById('txtRadio');

    if (radioInput) {
        radioInput.addEventListener('input', calcularCircunferencia);
    }

    const formulario = document.getElementById('frmFormulario');

    if (formulario && radioInput) {
        formulario.addEventListener('reset', function () {
            setTimeout(function () {
                calcularCircunferencia();
            }, 0);
        });
    }

    // ==========================================
    // COMPATIBILIDAD CON EL MÓDULO CUADRADO
    // ==========================================
    // Permite conservar el cálculo del cuadrado
    // si todavía utilizas su vista original.

    window.calcularCuadrado = function () {
        const ladoInput = document.getElementById('txtLado');
        const areaInput = document.getElementById('txtA');
        const perimetroInput = document.getElementById('txtP');

        if (!ladoInput || !areaInput || !perimetroInput) {
            return;
        }

        const lado = parseFloat(ladoInput.value);

        if (
            ladoInput.value.trim() === '' ||
            !Number.isFinite(lado) ||
            lado <= 0
        ) {
            alert('Ingrese un lado válido mayor a cero');
            ladoInput.focus();
            return;
        }

        areaInput.value = (lado * lado).toFixed(2);
        perimetroInput.value = (lado * 4).toFixed(2);
    };

    const ladoInput = document.getElementById('txtLado');

    if (ladoInput) {
        ladoInput.addEventListener('input', window.calcularCuadrado);
    }
});
