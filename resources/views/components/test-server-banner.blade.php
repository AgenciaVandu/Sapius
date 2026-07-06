@if(config('app.is_test_server'))
<div id="test-server-banner" style="
    background-color: #ff9800;
    color: #000;
    text-align: center;
    padding: 8px 10px;
    font-size: 14px;
    font-weight: bold;
    position: sticky;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 10000;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    border-bottom: 2px solid #e68a00;
">
    <span class="banner-text">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        ENTORNO DE PRUEBAS: El contenido en este sitio no es real y puede eliminarse en cualquier momento.
    </span>
    <a href="{{ config('app.real_site_url') }}" class="banner-link" style="
        background-color: #000;
        color: #fff;
        padding: 6px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 12px;
        transition: all 0.3s;
        white-space: nowrap;
    " onmouseover="this.style.backgroundColor='#333'; this.style.transform='scale(1.05)';" onmouseout="this.style.backgroundColor='#000'; this.style.transform='scale(1)';">
        IR AL SITIO REAL <i class="fas fa-external-link-alt ml-1"></i>
    </a>
</div>

<style>
    @media (max-width: 768px) {
        #test-server-banner {
            flex-direction: column;
            gap: 8px;
            padding: 10px;
        }
        .banner-text {
            font-size: 12px;
        }
    }
</style>
@endif
