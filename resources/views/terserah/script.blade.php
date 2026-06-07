<script>
/* =============================================
   TERSERAH FEATURE — Mobile & Desktop Script
   Flow:
   1. User pilih kategori
   2. Klik "Acak Sekarang" → fetch data dari server
   3. Animasi cycling gambar (loading step) ~5 detik
   4. Tampilkan hasil food + daftar restoran
   ============================================= */

/* ---- HELPERS ---- */
function categoryLabel(cat) {
    const map = { makanan: 'Makanan Berat', minuman: 'Minuman', jajanan: 'Jajanan' };
    return map[cat] || cat;
}

function buildRestaurantCard(r, isMobile) {
    return `
        <a href="${r.url}" class="flex items-center gap-3 rounded-xl bg-white p-3 shadow-[0_3px_8px_rgba(0,0,0,0.12)] transition hover:shadow-md">
            <img src="${r.image}"
                 onerror="this.src='/assets/img/terserah/makanan.png'"
                 alt="${r.name}"
                 class="${isMobile ? 'h-[52px] w-[52px]' : 'h-[48px] w-[48px]'} rounded-lg object-cover shrink-0">
            <div class="text-left overflow-hidden">
                <h4 class="truncate ${isMobile ? 'text-[14px]' : 'text-[13px]'} font-extrabold text-dark">${r.name}</h4>
                <p class="truncate ${isMobile ? 'text-[12px]' : 'text-[11px]'} text-[#8A9AB5]">${r.address}</p>
            </div>
        </a>`;
}

/* =============================================
   DESKTOP
   ============================================= */
document.addEventListener("DOMContentLoaded", function () {
    let desktopSelectedCategory = null;
    let desktopCycleInterval = null;
    let desktopPrefetchedImages = [];

    const desktopStepChoose  = document.getElementById("desktopStepChoose");
    const desktopStepLoading = document.getElementById("desktopStepLoading");
    const desktopStepResult  = document.getElementById("desktopStepResult");

    const desktopCards    = document.querySelectorAll(".desktop-category-card");
    const desktopAcakBtn  = document.querySelector(".desktop-acak-btn");
    const desktopUlangBtn = document.getElementById("desktopUlangBtn");

    const desktopLoadingImage    = document.getElementById("desktopLoadingImage");
    const desktopFinalImage      = document.getElementById("desktopFinalImage");
    const desktopFinalName       = document.getElementById("desktopFinalName");
    const desktopFinalCategory   = document.getElementById("desktopFinalCategory");
    const desktopRestaurantList  = document.getElementById("desktopRestaurantList");

    function showDesktopStep(step) {
        [desktopStepChoose, desktopStepLoading, desktopStepResult].forEach(s => {
            s.classList.add("hidden");
            s.classList.remove("flex");
        });
        step.classList.remove("hidden");
        step.classList.add("flex");
    }

    desktopCards.forEach(card => {
        card.addEventListener("click", function () {
            desktopCards.forEach(item => {
                item.style.borderColor = "transparent";
                item.style.backgroundColor = "#FDFDFD";
                item.style.transform = "scale(1)";
            });
            desktopSelectedCategory = this.dataset.category;
            this.style.borderColor = "#EF950F";
            this.style.backgroundColor = "#FFF3E0";
            this.style.transform = "scale(1.01)";

            // Aktifkan tombol acak
            desktopAcakBtn.style.backgroundColor = "#EF950F";
            desktopAcakBtn.style.color = "#FFFFFF";

            // Kosongkan cache sebelumnya
            desktopPrefetchedImages = [];

            // Prefetch gambar loading agar langsung siap
            fetch(`/terserah/loading-images/${desktopSelectedCategory}`)
                .then(res => res.json())
                .then(data => {
                    desktopPrefetchedImages = data.images || [];
                    // Preload ke cache browser
                    desktopPrefetchedImages.forEach(src => {
                        const img = new Image();
                        img.src = src;
                    });
                }).catch(e => console.error(e));
        });
    });

    desktopAcakBtn.addEventListener("click", async function () {
        if (!desktopSelectedCategory) {
            alert("Pilih kategori dulu bro");
            return;
        }

        showDesktopStep(desktopStepLoading);

        let cycleImages = desktopPrefetchedImages.length > 0 ? [...desktopPrefetchedImages] : [];
        let cycleIdx = 0;

        const startDesktopCycle = () => {
            if (desktopCycleInterval) return;
            if (cycleImages.length === 0) return;

            desktopLoadingImage.src = cycleImages[0];
            desktopLoadingImage.style.display = "block";

            desktopCycleInterval = setInterval(() => {
                cycleIdx = (cycleIdx + 1) % cycleImages.length;
                desktopLoadingImage.style.opacity = "0.6";
                setTimeout(() => {
                    desktopLoadingImage.src = cycleImages[cycleIdx];
                    desktopLoadingImage.style.opacity = "1";
                }, 150);
            }, 400);
        };

        if (cycleImages.length > 0) {
            startDesktopCycle();
        }

        try {
            const [randomRes, imagesRes] = await Promise.all([
                fetch(`/terserah/random/${desktopSelectedCategory}`),
                desktopPrefetchedImages.length === 0 
                    ? fetch(`/terserah/loading-images/${desktopSelectedCategory}`)
                    : Promise.resolve({ ok: true, json: () => ({ images: desktopPrefetchedImages }) })
            ]);

            if (!randomRes.ok) {
                const err = await randomRes.json();
                clearInterval(desktopCycleInterval);
                desktopCycleInterval = null;
                alert(err.message || "Data belum ada bro");
                showDesktopStep(desktopStepChoose);
                return;
            }

            const result = await randomRes.json();
            const imagesData = imagesRes.ok ? await imagesRes.json() : { images: [] };

            if (cycleImages.length === 0) {
                cycleImages = [...(imagesData.images || [])].filter(Boolean);
            }

            if (!cycleImages.includes(result.image)) {
                cycleImages.push(result.image);
            }

            if (cycleImages.length === 0) cycleImages = [result.image];

            startDesktopCycle();

            // Setelah 5 detik tampilkan hasil
            setTimeout(() => {
                clearInterval(desktopCycleInterval);
                desktopCycleInterval = null;

                desktopFinalImage.src = result.image;
                desktopFinalName.innerText = result.name;
                desktopFinalCategory.innerText = result.category_label || categoryLabel(result.category);

                // Render daftar restoran
                desktopRestaurantList.innerHTML = "";
                if (result.restaurants && result.restaurants.length > 0) {
                    result.restaurants.forEach(r => {
                        desktopRestaurantList.innerHTML += buildRestaurantCard(r, false);
                    });
                } else {
                    desktopRestaurantList.innerHTML = `<p class="text-sm text-muted">Belum ada restoran ditemukan.</p>`;
                }

                showDesktopStep(desktopStepResult);
            }, 5000);

        } catch (error) {
            console.error(error);
            clearInterval(desktopCycleInterval);
            desktopCycleInterval = null;
            alert("Gagal ambil data dari server");
            showDesktopStep(desktopStepChoose);
        }
    });

    desktopUlangBtn.addEventListener("click", function () {
        clearInterval(desktopCycleInterval);
        desktopCycleInterval = null;
        desktopSelectedCategory = null;

        desktopCards.forEach(card => {
            card.style.borderColor = "transparent";
            card.style.backgroundColor = "#FDFDFD";
            card.style.transform = "scale(1)";
        });

        desktopAcakBtn.style.backgroundColor = "";
        desktopAcakBtn.style.color = "";
        desktopLoadingImage.style.display = "none"; // Sembunyikan untuk percobaan berikutnya

        showDesktopStep(desktopStepChoose);
    });
});

/* =============================================
   MOBILE
   ============================================= */
document.addEventListener("DOMContentLoaded", function () {
    let selectedCategory = null;
    let mobileInterval = null;
    let mobilePrefetchedImages = [];

    const stepChoose  = document.getElementById("stepChoose");
    const stepLoading = document.getElementById("stepLoading");
    const stepResult  = document.getElementById("stepResult");

    const categoryCards = document.querySelectorAll(".category-card");
    const acakBtn       = document.querySelector(".acak-btn");
    const ulangBtn      = document.getElementById("ulangBtn");

    const loadingImage   = document.getElementById("loadingImage");
    const finalImage     = document.getElementById("finalImage");
    const finalName      = document.getElementById("finalName");
    const finalCategory  = document.getElementById("finalCategory");
    const restaurantList = document.getElementById("restaurantList");

    function showStep(step) {
        [stepChoose, stepLoading, stepResult].forEach(s => {
            s.classList.add("hidden");
            s.classList.remove("flex");
        });
        step.classList.remove("hidden");
        step.classList.add("flex");
    }

    categoryCards.forEach(card => {
        card.addEventListener("click", function () {
            categoryCards.forEach(item => {
                item.style.borderColor = "transparent";
                item.style.backgroundColor = "#FFFFFF";
                item.style.transform = "scale(1)";
            });

            selectedCategory = this.dataset.category;

            this.style.borderColor = "#EF950F";
            this.style.backgroundColor = "#FFF3E0";
            this.style.transform = "scale(1.01)";

            // Aktifkan tombol acak
            acakBtn.style.backgroundColor = "#EF950F";
            acakBtn.style.color = "#FFFFFF";

            // Kosongkan cache sebelumnya
            mobilePrefetchedImages = [];

            // Prefetch gambar loading agar langsung siap
            fetch(`/terserah/loading-images/${selectedCategory}`)
                .then(res => res.json())
                .then(data => {
                    mobilePrefetchedImages = data.images || [];
                    // Preload ke cache browser
                    mobilePrefetchedImages.forEach(src => {
                        const img = new Image();
                        img.src = src;
                    });
                }).catch(e => console.error(e));
        });
    });

    acakBtn.addEventListener("click", async function () {
        if (!selectedCategory) {
            alert("Pilih kategori dulu bro");
            return;
        }

        showStep(stepLoading);

        let cycleImages = mobilePrefetchedImages.length > 0 ? [...mobilePrefetchedImages] : [];
        let cycleIdx = 0;

        const startMobileCycle = () => {
            if (mobileInterval) return;
            if (cycleImages.length === 0) return;

            loadingImage.src = cycleImages[0];
            loadingImage.style.display = "block";

            mobileInterval = setInterval(() => {
                cycleIdx = (cycleIdx + 1) % cycleImages.length;
                loadingImage.style.opacity = "0.5";
                loadingImage.style.transform = "scale(0.97)";
                setTimeout(() => {
                    loadingImage.src = cycleImages[cycleIdx];
                    loadingImage.style.opacity = "1";
                    loadingImage.style.transform = "scale(1)";
                }, 120);
            }, 350);
        };

        if (cycleImages.length > 0) {
            startMobileCycle();
        }

        try {
            const [randomRes, imagesRes] = await Promise.all([
                fetch(`/terserah/random/${selectedCategory}`),
                mobilePrefetchedImages.length === 0 
                    ? fetch(`/terserah/loading-images/${selectedCategory}`)
                    : Promise.resolve({ ok: true, json: () => ({ images: mobilePrefetchedImages }) })
            ]);

            if (!randomRes.ok) {
                const err = await randomRes.json();
                clearInterval(mobileInterval);
                mobileInterval = null;
                alert(err.message || "Data belum ada bro");
                showStep(stepChoose);
                return;
            }

            const result = await randomRes.json();
            const imagesData = imagesRes.ok ? await imagesRes.json() : { images: [] };

            if (cycleImages.length === 0) {
                cycleImages = [...(imagesData.images || [])].filter(Boolean);
            }

            if (!cycleImages.includes(result.image)) {
                cycleImages.push(result.image);
            }

            if (cycleImages.length === 0) cycleImages = [result.image];

            startMobileCycle();

            // Setelah 5 detik, tampilkan hasil
            setTimeout(() => {
                clearInterval(mobileInterval);
                mobileInterval = null;

                finalImage.src = result.image;
                finalName.innerText = result.name;
                finalCategory.innerText = result.category_label || categoryLabel(result.category);

                // Render daftar restoran
                restaurantList.innerHTML = "";
                if (result.restaurants && result.restaurants.length > 0) {
                    result.restaurants.forEach(r => {
                        restaurantList.innerHTML += buildRestaurantCard(r, true);
                    });
                } else {
                    restaurantList.innerHTML = `<p class="text-sm text-muted text-center py-2">Belum ada restoran ditemukan.</p>`;
                }

                showStep(stepResult);

            }, 5000);

        } catch (error) {
            console.error(error);
            clearInterval(mobileInterval);
            mobileInterval = null;
            alert("Gagal ambil data dari server");
            showStep(stepChoose);
        }
    });

    ulangBtn.addEventListener("click", function () {
        clearInterval(mobileInterval);
        mobileInterval = null;
        selectedCategory = null;

        categoryCards.forEach(card => {
            card.style.borderColor = "transparent";
            card.style.backgroundColor = "#FFFFFF";
            card.style.transform = "scale(1)";
        });

        acakBtn.style.backgroundColor = "";
        acakBtn.style.color = "";
        loadingImage.style.display = "none"; // Sembunyikan untuk percobaan berikutnya

        showStep(stepChoose);
    });
});
</script>
