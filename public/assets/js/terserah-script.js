
document.addEventListener("DOMContentLoaded", function () {
    let desktopSelectedCategory = null;

    const desktopStepChoose = document.getElementById("desktopStepChoose");
    const desktopStepLoading = document.getElementById("desktopStepLoading");
    const desktopStepResult = document.getElementById("desktopStepResult");

    const desktopCards = document.querySelectorAll(".desktop-category-card");
    const desktopAcakBtn = document.querySelector(".desktop-acak-btn");
    const desktopUlangBtn = document.getElementById("desktopUlangBtn");

    const desktopLoadingImage = document.getElementById("desktopLoadingImage");
    const desktopLoadingName = document.getElementById("desktopLoadingName");

    const desktopFinalImage = document.getElementById("desktopFinalImage");
    const desktopFinalName = document.getElementById("desktopFinalName");
    const desktopFinalCategory = document.getElementById("desktopFinalCategory");

    const desktopRestaurantName = document.getElementById("desktopRestaurantName");
    const desktopRestaurantAddress = document.getElementById("desktopRestaurantAddress");

    function showDesktopStep(step) {
        desktopStepChoose.classList.add("hidden");
        desktopStepChoose.classList.remove("flex");

        desktopStepLoading.classList.add("hidden");
        desktopStepLoading.classList.remove("flex");

        desktopStepResult.classList.add("hidden");
        desktopStepResult.classList.remove("flex");

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
        });
    });

    desktopAcakBtn.addEventListener("click", async function () {
        if (!desktopSelectedCategory) {
            alert("Pilih kategori dulu bro 😭");
            return;
        }

        showDesktopStep(desktopStepLoading);

        try {
            const response = await fetch(`/terserah/random/${desktopSelectedCategory}`);

            if (!response.ok) {
                const error = await response.json();
                alert(error.message || "Data belum ada bro 😭");
                showDesktopStep(desktopStepChoose);
                return;
            }

            const result = await response.json();

            desktopLoadingImage.src = result.image;
            desktopLoadingName.innerText = result.name;

            setTimeout(() => {
                desktopFinalImage.src = result.image;
                desktopFinalName.innerText = result.name;
                desktopFinalCategory.innerText = "Makanan Berat";

                desktopRestaurantName.innerText = result.restaurant.name;
                desktopRestaurantAddress.innerText = result.restaurant.address;

                showDesktopStep(desktopStepResult);
            }, 5000);

        } catch (error) {
            console.error(error);
            alert("Gagal ambil data dari server 😭");
            showDesktopStep(desktopStepChoose);
        }
    });

    desktopUlangBtn.addEventListener("click", function () {
        desktopSelectedCategory = null;

        desktopCards.forEach(card => {
            card.style.borderColor = "transparent";
            card.style.backgroundColor = "#FDFDFD";
            card.style.transform = "scale(1)";
        });

        showDesktopStep(desktopStepChoose);
    });
});
// mobile js //
document.addEventListener("DOMContentLoaded", function () {
    let selectedCategory = null;

    const stepChoose = document.getElementById("stepChoose");
    const stepLoading = document.getElementById("stepLoading");
    const stepResult = document.getElementById("stepResult");

    const categoryCards = document.querySelectorAll(".category-card");
    const acakBtn = document.querySelector(".acak-btn");
    const ulangBtn = document.getElementById("ulangBtn");

    const loadingImage = document.getElementById("loadingImage");
    const loadingName = document.getElementById("loadingName");

    const finalImage = document.getElementById("finalImage");
    const finalName = document.getElementById("finalName");
    const finalCategory = document.getElementById("finalCategory");

    const restaurantImage1 = document.getElementById("restaurantImage1");
    const restaurantImage2 = document.getElementById("restaurantImage2");

    const restaurantName1 = document.getElementById("restaurantName1");
    const restaurantAddress1 = document.getElementById("restaurantAddress1");

    const restaurantName2 = document.getElementById("restaurantName2");
    const restaurantAddress2 = document.getElementById("restaurantAddress2");

    function showStep(step) {
        stepChoose.classList.add("hidden");
        stepChoose.classList.remove("flex");

        stepLoading.classList.add("hidden");
        stepLoading.classList.remove("flex");

        stepResult.classList.add("hidden");
        stepResult.classList.remove("flex");

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
        });
    });

    acakBtn.addEventListener("click", async function () {

        if (!selectedCategory) {
            alert("Pilih kategori dulu bro 😭");
            return;
        }

        showStep(stepLoading);

        loadingName.innerText = "KUMAR lagi mikir...";

        let loadingInterval = setInterval(() => {
            loadingImage.style.transform = "scale(1.04)";

            setTimeout(() => {
                loadingImage.style.transform = "scale(1)";
            }, 90);

        }, 180);

        try {

            const response = await fetch(`/terserah/random/${selectedCategory}`);

            if (!response.ok) {
                const error = await response.json();

                clearInterval(loadingInterval);

                alert(error.message || "Data belum ada bro 😭");

                showStep(stepChoose);

                return;
            }

            const result = await response.json();

            loadingImage.src = result.image;
            loadingName.innerText = result.name;

            setTimeout(() => {

                clearInterval(loadingInterval);

                finalImage.src = result.image;
                finalName.innerText = result.name;

                // INI BUAT TEXT KATEGORI
                finalCategory.innerText = "Makanan Berat";

                restaurantImage1.src = result.restaurant.image;
                restaurantImage2.src = result.restaurant.image;

                restaurantName1.innerText = result.restaurant.name;
                restaurantAddress1.innerText = result.restaurant.address;

                restaurantName2.innerText = result.restaurant.name;
                restaurantAddress2.innerText = result.restaurant.address;

                showStep(stepResult);

            }, 5000);

        } catch (error) {

            console.error(error);

            clearInterval(loadingInterval);

            alert("Gagal ambil data dari server 😭");

            showStep(stepChoose);
        }
    });

    ulangBtn.addEventListener("click", function () {

        selectedCategory = null;

        categoryCards.forEach(card => {
            card.style.borderColor = "transparent";
            card.style.backgroundColor = "#FFFFFF";
            card.style.transform = "scale(1)";
        });

        showStep(stepChoose);
    });
});