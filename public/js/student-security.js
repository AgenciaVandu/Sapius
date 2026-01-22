// Student Global Security Script

// Student Global Security Script

(function () {
    // Use injected routes or fallbacks (fallbacks mainly for dev/local if variable missing)
    const registerStrikeEndpoint = window.sapiusRoutes?.registerStrike || '/alumno/register-strike';
    const lockedUrl = window.sapiusRoutes?.locked || '/alumno/cuenta-bloqueada';
    let isWarningActive = false;
    const maxStrikes = 3;

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    }

    function registerGlobalPanelStrike(reason) {
        if (isWarningActive) return;
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
                    // If the element is specifically the counter (contador-intentos)
                    if (msg.id === 'contador-intentos') {
                        const restantes = maxStrikes - (data.strikes || 0);
                        msg.textContent = `Intento ${data.strikes} de ${maxStrikes} — ${restantes > 0 ? `Te quedan ${restantes}` : '⚠️ Cuenta Bloqueada'}`;
                    } else {
                        // Generic message element
                        msg.textContent = `Advertencia ${data.strikes} de ${maxStrikes}`;
                    }

                    overlay.style.display = 'flex';
                }

                if (data.status === 'blocked') {
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
        const tagName = target.tagName.toUpperCase();
        return (tagName === 'INPUT' || tagName === 'TEXTAREA'); // || (tagName === 'DIV' && target.isContentEditable)
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

    // 3. Disable Text Selection
    function disableSelect(e) {
        if (isAllowedInput(e.target)) return true;
        return false;
    }

    // Modern browsers use selectstart
    document.addEventListener('selectstart', function (e) {
        if (isAllowedInput(e.target)) return true;
        e.preventDefault();
        return false;
    });

    document.onmousedown = disableSelect;

    // 4. Restricted Keys
    function handleGlobalKey(e) {
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

        // DevTools Ctrl+Shift+I/J/C - logic redundant due to Shift block but kept for clarity
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
