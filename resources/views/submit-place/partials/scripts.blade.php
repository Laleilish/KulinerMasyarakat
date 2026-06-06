<script>
function submitPlaceForm() {
    return {
        step: 1,
        photoPreview: null,
        landmarkPreview: null,
        reviewPreviews: [],
        reviewFiles: [],
        errors: {},
        timeOptions: [],
        selectOpen: false,
        selectableItems: [
            { title: 'Makanan Berat', value: 'makanan_berat', disabled: false },
            { title: 'Jajanan', value: 'jajanan', disabled: false },
            { title: 'Minuman', value: 'minuman', disabled: false }
        ],
        selectableItemActive: null,
        selectId: 'category-select',
        selectKeydownValue: '',
        selectKeydownTimeout: 1000,
        selectKeydownClearTimeout: null,
        selectDropdownPosition: 'bottom',

        isLocating: false,
        map: null,
        marker: null,

        form: {
            name: '{{ old("name", "") }}',
            category: '{{ old("category", "") }}',
            food_type: '{{ old("food_type", "") }}',
            description: '{{ old("description", "") }}',
            address: '{{ old("address", "") }}',
            open_time: '{{ old("open_time", "") }}',
            close_time: '{{ old("close_time", "") }}',
            price_min: '{{ old("price_min", "") }}',
            price_max: '{{ old("price_max", "") }}',
            gmaps_link: '{{ old("gmaps_link", "") }}',
            latitude: '{{ old("latitude", "") }}',
            longitude: '{{ old("longitude", "") }}',
            landmark: '{{ old("landmark", "") }}',
            rating: {{ old('initial_rating', 0) }},
            review: '{{ old("initial_review", "") }}',
        },

        // Photo Handlers
        handlePhoto(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            if (file.size > 2 * 1024 * 1024) {
                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'File Terlalu Besar', message: 'Ukuran foto maksimal 2MB!' } }));
                e.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (ev) => this.photoPreview = ev.target.result;
            reader.readAsDataURL(file);
        },
        removePhoto() {
            this.photoPreview = null;
            document.getElementById('file-upload').value = '';
        },

        handleLandmark(e) {
            const file = e.target.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'File Terlalu Besar', message: 'Ukuran foto maksimal 2MB!' } }));
                e.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (ev) => this.landmarkPreview = ev.target.result;
            reader.readAsDataURL(file);
        },
        removeLandmark() {
            this.landmarkPreview = null;
            document.getElementById('landmark-upload').value = '';
        },

        handleReviewPhotos(e) {
            const files = Array.from(e.target.files);
            const remaining = 5 - this.reviewPreviews.length;
            const toAdd = files.slice(0, remaining);

            let hasOversized = false;

            toAdd.forEach(file => {
                if (file.size > 2 * 1024 * 1024) {
                    hasOversized = true;
                    return; // Skip this file
                }
                this.reviewFiles.push(file);
                const reader = new FileReader();
                reader.onload = (ev) => this.reviewPreviews.push(ev.target.result);
                reader.readAsDataURL(file);
            });

            if (hasOversized) {
                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Beberapa File Ditolak', message: 'Foto yang lebih dari 2MB tidak dimasukkan.' } }));
            }

            // Rebuild file input
            this.syncReviewFileInput();
        },
        removeReviewPhoto(idx) {
            this.reviewPreviews.splice(idx, 1);
            this.reviewFiles.splice(idx, 1);
            this.syncReviewFileInput();
        },
        syncReviewFileInput() {
            const dt = new DataTransfer();
            this.reviewFiles.forEach(f => dt.items.add(f));
            document.getElementById('review-upload').files = dt.files;
        },

        // Map Handlers
        initMap() {
            // Default center (e.g. Bandung)
            let initialLat = this.form.latitude ? parseFloat(this.form.latitude) : -6.914744;
            let initialLng = this.form.longitude ? parseFloat(this.form.longitude) : 107.609810;
            
            this.map = L.map('submit-map').setView([initialLat, initialLng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(this.map);

            const restoIcon = L.icon({
                iconUrl: '/assets/img/icon-loc.png',
                iconSize: [28],
                iconAnchor: [14, 28],
            });

            this.marker = L.marker([initialLat, initialLng], { 
                icon: restoIcon, 
                draggable: true 
            }).addTo(this.map);

            this.marker.on('dragend', (e) => {
                const position = e.target.getLatLng();
                this.updateLocation(position.lat, position.lng, true);
            });
            
            // Allow clicking map to place marker
            this.map.on('click', (e) => {
                this.marker.setLatLng(e.latlng);
                this.updateLocation(e.latlng.lat, e.latlng.lng, true);
            });
        },

        updateLocation(lat, lng, fetchAddress = true) {
            this.form.latitude = lat;
            this.form.longitude = lng;
            this.form.gmaps_link = `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;
            
            if (fetchAddress) {
                this.isLocating = true;
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=id`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.display_name) {
                            // Extract relevant parts for a cleaner address
                            const parts = data.display_name.split(', ');
                            this.form.address = parts.slice(0, 3).join(', ');
                        }
                    })
                    .finally(() => {
                        this.isLocating = false;
                    });
            }
        },

        detectLocation() {
            if (!navigator.geolocation) {
                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Error', message: 'Browser Anda tidak mendukung deteksi lokasi.' } }));
                return;
            }

            this.isLocating = true;
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    if (this.map) {
                        this.map.setView([lat, lng], 16);
                    }
                    if (this.marker) {
                        this.marker.setLatLng([lat, lng]);
                    }
                    this.updateLocation(lat, lng, true);
                },
                (error) => {
                    this.isLocating = false;
                    window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Tidak dapat mendeteksi lokasi. Pastikan izin lokasi aktif.' } }));
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        },

        // Validation
        validateStep(stepNum) {
            this.errors = {};
            let valid = true;

            if (stepNum === 1) {
                if (!this.form.name.trim()) { this.errors.name = 'Nama restoran wajib diisi'; valid = false; }
                if (!this.form.category) { this.errors.category = 'Kategori wajib dipilih'; valid = false; }
                if (!this.form.food_type.trim()) { this.errors.food_type = 'Jenis makanan wajib diisi'; valid = false; }
                if (!this.photoPreview) { this.errors.photo = 'Foto restoran wajib diupload'; valid = false; }
            }

            if (stepNum === 2) {
                if (!this.form.address.trim()) { this.errors.address = 'Alamat wajib diisi'; valid = false; }
                if (!this.form.open_time || !this.form.close_time) { this.errors.open_hours = 'Jam buka dan tutup wajib diisi'; valid = false; }
                if (!this.form.price_min || !this.form.price_max) { this.errors.price_range = 'Range harga wajib diisi'; valid = false; }
                if (!this.form.gmaps_link.trim()) { this.errors.gmaps_link = 'Link Google Maps wajib diisi'; valid = false; }
                if (!this.landmarkPreview) { this.errors.landmark_photo = 'Foto patokan wajib diupload'; valid = false; }
            }

            if (stepNum === 3) {
                if (this.form.rating < 1) { this.errors.rating = 'Rating wajib dipilih'; valid = false; }
            }

            return valid;
        },

        nextStep(currentStep) {
            if (this.validateStep(currentStep)) {
                this.step = currentStep + 1;
            }
        },

        submitForm() {
            if (this.validateStep(3)) {
                window.dispatchEvent(new CustomEvent('confirm-modal', {
                    detail: {
                        title: 'Kirim Ulasan?',
                        message: 'Ulasan kamu akan membantu pengguna lain mengetahui pengalaman dan kualitas tempat ini. Pastikan ulasan sudah sesuai sebelum dikirim.',
                        variant: 'confirm',
                        confirmText: 'Ya, Kirimkan',
                        cancelText: 'Kembali',
                        onConfirm: () => {
                            this.$refs.submitForm.submit();
                        }
                    }
                }));
            }
        },

        init() {
            // Generate timeOptions (every 15 minutes)
            this.timeOptions = [];
            for (let hour = 0; hour < 24; hour++) {
                const hourStr = String(hour).padStart(2, '0');
                for (let minute = 0; minute < 60; minute += 15) {
                    const minuteStr = String(minute).padStart(2, '0');
                    this.timeOptions.push(`${hourStr}:${minuteStr}`);
                }
            }

            this.$watch('step', (newStep) => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                
                // Initialize map if switching to step 2
                if (newStep === 2) {
                    setTimeout(() => {
                        if (!this.map) {
                            this.initMap();
                        } else {
                            this.map.invalidateSize(); // Fix Leaflet rendering issue in hidden divs
                        }
                    }, 200);
                }
            });

            this.$watch('selectOpen', (value) => {
                if (value) {
                    const currentItem = this.selectableItems.find(i => i.value === this.form.category);
                    this.selectableItemActive = currentItem || this.selectableItems[0];
                    setTimeout(() => {
                        this.selectScrollToActiveItem();
                    }, 10);
                    this.selectPositionUpdate();
                }
            });
            window.addEventListener('resize', () => { this.selectPositionUpdate(); });
        },

        selectableItemIsActive(item) {
            return this.selectableItemActive && this.selectableItemActive.value == item.value;
        },

        selectableItemActiveNext() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index < this.selectableItems.length - 1) {
                this.selectableItemActive = this.selectableItems[index + 1];
                this.selectScrollToActiveItem();
            }
        },

        selectableItemActivePrevious() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index > 0) {
                this.selectableItemActive = this.selectableItems[index - 1];
                this.selectScrollToActiveItem();
            }
        },

        selectScrollToActiveItem() {
            if (this.selectableItemActive && this.$refs.selectableItemsList) {
                const activeElement = document.getElementById(this.selectableItemActive.value + '-' + this.selectId);
                if (activeElement) {
                    const newScrollPos = (activeElement.offsetTop + activeElement.offsetHeight) - this.$refs.selectableItemsList.offsetHeight;
                    this.$refs.selectableItemsList.scrollTop = newScrollPos > 0 ? newScrollPos : 0;
                }
            }
        },

        selectKeydown(event) {
            if (event.keyCode >= 65 && event.keyCode <= 90) {
                this.selectKeydownValue += event.key;
                const selectedItemBestMatch = this.selectItemsFindBestMatch();
                if (selectedItemBestMatch) {
                    if (this.selectOpen) {
                        this.selectableItemActive = selectedItemBestMatch;
                        this.selectScrollToActiveItem();
                    } else {
                        this.form.category = selectedItemBestMatch.value;
                        this.selectableItemActive = selectedItemBestMatch;
                    }
                }
                if (this.selectKeydownValue != '') {
                    clearTimeout(this.selectKeydownClearTimeout);
                    this.selectKeydownClearTimeout = setTimeout(() => {
                        this.selectKeydownValue = '';
                    }, this.selectKeydownTimeout);
                }
            }
        },

        selectItemsFindBestMatch() {
            const typedValue = this.selectKeydownValue.toLowerCase();
            let bestMatch = null;
            let bestMatchIndex = -1;
            for (let i = 0; i < this.selectableItems.length; i++) {
                const title = this.selectableItems[i].title.toLowerCase();
                const index = title.indexOf(typedValue);
                if (index > -1 && (bestMatchIndex == -1 || index < bestMatchIndex) && !this.selectableItems[i].disabled) {
                    bestMatch = this.selectableItems[i];
                    bestMatchIndex = index;
                }
            }
            return bestMatch;
        },

        selectPositionUpdate() {
            if (this.$refs.selectButton && this.$refs.selectableItemsList) {
                const selectDropdownBottomPos = this.$refs.selectButton.getBoundingClientRect().top + this.$refs.selectButton.offsetHeight + parseInt(window.getComputedStyle(this.$refs.selectableItemsList).maxHeight || '224');
                if (window.innerHeight < selectDropdownBottomPos) {
                    this.selectDropdownPosition = 'top';
                } else {
                    this.selectDropdownPosition = 'bottom';
                }
            }
        }
    }
}
</script>
