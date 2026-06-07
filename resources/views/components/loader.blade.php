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

    // Sembunyikan saat DOM siap (lebih cepat dari load, cocok untuk halaman dengan map/gambar banyak)
    document.addEventListener('DOMContentLoaded', hideLoader);
    
    // Fallback darurat: Sembunyikan paksa setelah 2 detik untuk jaga-jaga
    setTimeout(hideLoader, 2000);
    
    window.addEventListener('load', hideLoader);
</script>
