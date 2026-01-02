// Student Global Security Script

(function () {
    // 1. Disable Right Click
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        return false;
    });

    // 2. Disable Cut, Copy, Paste
    document.addEventListener('copy', function (e) { e.preventDefault(); });
    document.addEventListener('cut', function (e) { e.preventDefault(); });
    document.addEventListener('paste', function (e) { e.preventDefault(); });

    // 3. Disable Text Selection
    function disableSelect(e) { return false; }

    document.onselectstart = function () { return false; };
    document.onmousedown = disableSelect;

    // 4. Warning Overlay & Restricted Keys
    let intentos = parseInt(localStorage.getItem('security_strikes')) || 0;
    const maxIntentos = 3;
    const overlay = document.getElementById('warning-overlay');
    const contador = document.getElementById('contador-intentos');
    let isWarningActive = false; // Debounce flag

    // Check if already blocked on load
    if (intentos >= maxIntentos) {
        if (!window.location.href.includes('cuenta-bloqueada')) {
            window.location.href = '/alumno/cuenta-bloqueada';
        }
        return;
    }

    window.addEventListener('keydown', function (event) {
        const restrictedKeys = ['PrintScreen', 'F12', 'F11'];
        const isRestricted = event.ctrlKey || restrictedKeys.includes(event.key);

        if (!isRestricted) return;

        event.preventDefault();
        event.stopPropagation();

        if (isWarningActive) return; // Prevent multiple counts for same event duration

        isWarningActive = true;
        intentos++;
        localStorage.setItem('security_strikes', intentos); // Persist strikes

        const restantes = maxIntentos - intentos;

        if (overlay && contador) {
            contador.textContent = `Intento ${intentos} de ${maxIntentos} — ${restantes > 0 ? `Te quedan ${restantes}` : '⚠️ Cuenta Bloqueada'}`;
            overlay.style.display = 'flex';

            // Hide after 5 seconds and reset debounce
            if (intentos < maxIntentos) {
                setTimeout(() => {
                    overlay.style.display = 'none';
                    isWarningActive = false;
                }, 5000);
            } else {
                // 3rd Strike - Immediate Block
                setTimeout(() => {
                    if (!window.location.href.includes('cuenta-bloqueada')) {
                        window.location.href = '/alumno/cuenta-bloqueada';
                    }
                }, 1500);
            }
        }
    });

    // CSS for unselectable text as backup
    const style = document.createElement('style');
    style.innerHTML = `
        body {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    `;
    document.head.appendChild(style);

})();
