<!-- resources/views/components/loader.blade.php -->
<div id="global-loader" class="fixed inset-0 z-[99999] flex items-center justify-center bg-[#FDF8F0] transition-opacity duration-500">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <lottie-player 
        src="/assets/img/Loading/Loading.json" 
        background="transparent" 
        speed="1" 
        style="width: 150px; height: 150px;" 
        loop 
        autoplay>
    </lottie-player>
</div>

<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('global-loader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }
    });
</script>
