<!-- resources/views/components/loader.blade.php -->
<div id="global-loader" class="fixed inset-0 z-[99999] flex items-center justify-center bg-black/50 transition-opacity duration-500">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <lottie-player 
        src="/assets/img/Loading/Loading.json" 
        background="transparent" 
        speed="1" 
        style="width: 300px; height: 300px;" 
        loop 
        autoplay>
    </lottie-player>
</div>

<script>
    function hideLoader() {
        const loader = document.getElementById('global-loader');
        if (loader && loader.style.display !== 'none') {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }
    }

    // Sembunyikan saat DOM siap
    document.addEventListener('DOMContentLoaded', hideLoader);
    
    // Fallback darurat
    setTimeout(hideLoader, 3000);

    // Tampilkan loader SECARA INSTAN saat user klik link pindah halaman
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        
        // Pastikan itu adalah link internal, bukan buka tab baru, dan bukan sekadar anchor link (#)
        if (link && link.href && !link.hasAttribute('download') && link.target !== '_blank' && link.href.startsWith(window.location.origin)) {
            
            const currentUrl = window.location.href.split('#')[0];
            const linkUrl = link.href.split('#')[0];
            
            // Jika pindah ke URL yang berbeda
            if (currentUrl !== linkUrl) {
                const loader = document.getElementById('global-loader');
                if (loader) {
                    loader.style.display = 'flex';
                    // Paksa browser me-render perubahan style sebelum pindah halaman
                    void loader.offsetWidth; 
                    loader.style.opacity = '1';
                }
            }
        }
    });
</script>
