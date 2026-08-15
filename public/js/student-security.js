// Student Global Security Script

// Student Global Security Script

(function () {
    // Use injected routes or fallbacks (fallbacks mainly for dev/local if variable missing)
    const registerStrikeEndpoint = window.sapiusRoutes?.registerStrike || '/alumno/register-strike';
    const lockedUrl = window.sapiusRoutes?.locked || '/alumno/cuenta-bloqueada';
    let isWarningActive = false;
    const maxStrikes = 100;

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    }

    let isBlocked = false;

    function registerGlobalPanelStrike(reason) {
        if (isWarningActive || isBlocked) return;
        isWarningActive = true;

        const overlay = document.getElementById('warning-overlay');
        const contador = document.getElementById('contador-intentos');
        const msg = document.getElementById('strike-msg') || (contador ? contador : null); // Fallback to contador if generic msg missing

        fetch(registerStrikeEndpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ action: reason })
        })
            .then(response => {
                // Check if response is actually JSON
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json();
                } else {
                    return response.text().then(text => {
                        throw new Error("Server response was not JSON: " + text.substring(0, 100)); // Log first 100 chars of HTML
                    });
                }
            })
            .then(data => {
                console.log(`Global Strike registered: ${reason}`, data);

                if (msg && overlay) {
                    // Update UI to show Risk Level instead of attempt count
                    // Using Math.min to cap at 100 for display
                    const currentScore = Math.min(data.strikes || 0, 100);

                    if (msg.id === 'contador-intentos') {
                        msg.textContent = `Nivel de Riesgo: ${currentScore}% — ${currentScore < 100 ? 'Evite acciones indebidas' : '⚠️ Cuenta Bloqueada'}`;
                    } else {
                        // Generic message element
                        msg.textContent = `Advertencia: Nivel de Riesgo ${currentScore}%`;
                    }

                    overlay.style.display = 'flex';
                }

                if (data.status === 'blocked' || (data.strikes && data.strikes >= maxStrikes)) {
                    isBlocked = true; // Stop further local processing
                    setTimeout(() => {
                        window.location.href = lockedUrl;
                    }, 2000);
                } else {
                    setTimeout(() => {
                        if (overlay) overlay.style.display = 'none';
                        isWarningActive = false;
                    }, 4000);
                }
            })
            .catch(err => {
                console.error('Error registering strike', err);
                isWarningActive = false;
            });
    }

    // Helper to check if target is an allowed input
    function isAllowedInput(target) {
        if (!target) return false;
        const el = target.nodeType === 3 ? target.parentElement : target;
        if (!el || !el.tagName) return false;
        const tag = el.tagName.toUpperCase();
        if (tag === 'INPUT' || tag === 'TEXTAREA' || el.isContentEditable) return true;
        if (el.closest && el.closest('input, textarea, [contenteditable="true"], .interactive-input, .f3d-page-number')) return true;
        return false;
    }

    function isAllowedStrictKey(e) {
        if (/^[0-9]$/.test(e.key)) return true;
        if (e.code && e.code.startsWith('Numpad') && /^[0-9]$/.test(e.key)) return true;
        if (['Backspace', 'Delete', 'Enter'].includes(e.key)) return true;
        return false;
    }

    // 1. Disable Right Click
    document.addEventListener('contextmenu', function (e) {
        if (isAllowedInput(e.target)) return true; // Allow context menu on inputs
        e.preventDefault();
        registerGlobalPanelStrike('Right Click');
        return false;
    });

    // 2. Disable Cut, Copy, Paste
    document.addEventListener('copy', function (e) {
        if (isAllowedInput(e.target)) return true;
        e.preventDefault();
        registerGlobalPanelStrike('Copy');
    });

    document.addEventListener('cut', function (e) {
        if (isAllowedInput(e.target)) return true;
        e.preventDefault();
        registerGlobalPanelStrike('Cut');
    });

    document.addEventListener('paste', function (e) {
        // Always allow paste in inputs
        if (isAllowedInput(e.target)) return true;
        e.preventDefault();
        registerGlobalPanelStrike('Paste');
    });

    // Modern browsers use selectstart
    document.addEventListener('selectstart', function (e) {
        if (isAllowedInput(e.target)) return true;
        e.preventDefault();
        return false;
    });

    // 4. Restricted Keys
    function handleGlobalKey(e) {
        // Si la tecla se presiona dentro de un input de salto de página o campo de texto
        if (isAllowedInput(e.target)) {
            // Permitir únicamente números 0-9, Backspace, Delete y Enter
            if (isAllowedStrictKey(e)) {
                return true;
            }
            // Bloquear cualquier otra tecla (Tab, flechas, letras, Shift, Ctrl, Alt, Cmd) sin registrar strike
            e.preventDefault();
            e.stopPropagation();
            return false;
        }

        // Volume Keys - Handled as Low Severity
        if (['AudioVolumeUp', 'AudioVolumeDown', 'AudioVolumeMute'].includes(e.key)) {
            e.preventDefault();
            registerGlobalPanelStrike('Volume Key');
            return;
        }

        // Windows PrintScreen
        if (e.key === 'PrintScreen' || e.keyCode === 44) {
            e.preventDefault();
            registerGlobalPanelStrike('PrintScreen');
            return;
        }

        const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
        const isCtrlOfTheOS = isMac ? e.metaKey : e.ctrlKey;
        const isShift = e.shiftKey;

        // Shift Key Restriction (Any use of Shift)
        if (e.key === 'Shift' || isShift) {
            e.preventDefault();
            registerGlobalPanelStrike("Restricted Key / Modifier");
            return;
        }

        // Mac Screenshots: Cmd+Shift+3, 4, 5
        if (isMac && e.metaKey && e.shiftKey && ['3', '4', '5'].includes(e.key)) {
            e.preventDefault();
            registerGlobalPanelStrike("Mac Screenshot");
            return;
        }

        // Windows Snipping Tool (Win + Shift + S)
        if (!isMac && e.metaKey && e.shiftKey && (e.key === 's' || e.key === 'S')) {
            e.preventDefault();
            registerGlobalPanelStrike("Snipping Tool");
            return;
        }

        // Block Ctrl/Cmd + P (Print), S (Save), C (Copy), U (View Source)
        if (isCtrlOfTheOS && ['p', 's', 'c', 'u'].includes(e.key.toLowerCase())) {
            e.preventDefault();
            registerGlobalPanelStrike(`Shortcut ${e.key}`);
            return;
        }

        // DevTools F12
        if (e.key === 'F12') {
            e.preventDefault();
            registerGlobalPanelStrike("F12");
            return;
        }

        // DevTools Ctrl+Shift+I/J/C
        if (isCtrlOfTheOS && isShift && ['i', 'j', 'c'].includes(e.key.toLowerCase())) {
            e.preventDefault();
            registerGlobalPanelStrike("DevTools");
            return;
        }
    }

    document.addEventListener('keydown', handleGlobalKey);
    document.addEventListener('keyup', (e) => {
        if (e.key === 'PrintScreen' || e.keyCode === 44) {
            e.preventDefault();
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
