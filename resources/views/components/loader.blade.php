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

    const minimumLoadingTime = 500; // 0.5 detik
    const startTime = Date.now();

    document.addEventListener('DOMContentLoaded', () => {
        const elapsedTime = Date.now() - startTime;
        const remainingTime = Math.max(0, minimumLoadingTime - elapsedTime);
        setTimeout(hideLoader, remainingTime);
    });
    
    // Fallback darurat
    setTimeout(hideLoader, 3000);

</script>
