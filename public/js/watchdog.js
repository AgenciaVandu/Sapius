/**
 * Sapius MAC Detector Watchdog
 * Ensures the Electron app is running during the student session.
 */

(function() {
    const HEARTBEAT_INTERVAL = 30000; // 30 seconds
    const GRACE_PERIOD = 60; // 60 seconds countdown
    const BRIDGE_URL = 'http://127.0.0.1:3005/mac';
    
    let watchdogTimer = null;
    let countdownInterval = null;
    let isWarningActive = false;
    let currentCountdown = GRACE_PERIOD;

    // Create the overlay UI
    const overlay = document.createElement('div');
    overlay.id = 'watchdog-overlay';
    overlay.style = `
        display: none;
        position: fixed;
        top: 0; left: 0; 
        width: 100%; height: 100%;
        background-color: rgba(0, 33, 70, 0.98);
        color: white;
        z-index: 100000;
        text-align: center;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: 'Nunito', sans-serif;
    `;
    overlay.innerHTML = `
        <div style="max-width: 500px; padding: 20px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 80px; color: #ed6a5a; margin-bottom: 20px;"></i>
            <h2 style="font-weight: 800; color: #ed6a5a;">¡DETECTOR DESCONECTADO!</h2>
            <p style="font-size: 1.2rem; margin: 20px 0;">
                Se ha perdido la conexión con el <strong>Detector Sapius</strong>.<br>
                Es obligatorio mantener la aplicación abierta para continuar navegando.
            </p>
            <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 15px; margin: 20px 0;">
                <p style="margin: 0; font-size: 0.9rem; opacity: 0.8;">Cerrando sesión en:</p>
                <div id="watchdog-timer" style="font-size: 3rem; font-weight: 900; color: #25D366;">60</div>
                <p style="margin: 0; font-size: 0.9rem; opacity: 0.8;">segundos</p>
            </div>
            <p style="font-size: 1rem; color: #ffeb3b;">
                Por favor, abre nuevamente el <strong>Sapius Detector</strong> en tu equipo para restaurar el acceso.
            </p>
        </div>
    `;
    document.body.appendChild(overlay);

    const timerDisplay = document.getElementById('watchdog-timer');

    async function checkDetector() {
        try {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 5000);
            
            const response = await fetch(BRIDGE_URL, { signal: controller.signal });
            clearTimeout(timeoutId);

            if (response.ok) {
                if (isWarningActive) {
                    stopCountdown();
                }
                return true;
            }
        } catch (error) {
            if (!isWarningActive) {
                startCountdown();
            }
            return false;
        }
    }

    function startCountdown() {
        isWarningActive = true;
        currentCountdown = GRACE_PERIOD;
        overlay.style.display = 'flex';
        
        if (countdownInterval) clearInterval(countdownInterval);
        
        countdownInterval = setInterval(() => {
            currentCountdown--;
            timerDisplay.innerText = currentCountdown;
            
            // Try to recover every 5 seconds during countdown
            if (currentCountdown % 5 === 0) {
                checkDetector();
            }

            if (currentCountdown <= 0) {
                clearInterval(countdownInterval);
                logout();
            }
        }, 1000);
    }

    function stopCountdown() {
        isWarningActive = false;
        overlay.style.display = 'none';
        if (countdownInterval) clearInterval(countdownInterval);
        console.log('[WATCHDOG] Conexión restaurada.');
    }

    function logout() {
        // Find logout form or just redirect
        const logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
            logoutForm.submit();
        } else {
            window.location.href = '/logout';
        }
    }

    // Start the heartbeat
    watchdogTimer = setInterval(checkDetector, HEARTBEAT_INTERVAL);
    
    // Initial check
    setTimeout(checkDetector, 5000);

})();
