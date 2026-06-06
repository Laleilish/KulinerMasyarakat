<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('splitBill', () => ({
            rawInput: '',
            totalInput: 0,
            jumlahOrang: 0,
            customValues: {},
            activeTab: 'bagi',

            get totalTerkumpul() {
                if (this.activeTab === 'bagi') {
                    return (this.jumlahOrang > 0 && this.totalInput > 0) ? this.totalInput : 0;
                } else {
                    return Object.values(this.customValues).reduce((sum, val) => sum + (val || 0), 0);
                }
            },

            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                }).format(angka);
            },

            handleNominalInput(e) {
                let val = e.target.value.replace(/\D/g, '');
                this.totalInput = parseInt(val) || 0;
                this.rawInput = this.totalInput || '';
            },

            handleCustomInput(i, e) {
                let val = e.target.value.replace(/\D/g, '');
                this.customValues[i] = parseInt(val) || 0;
                e.target.value = this.customValues[i] || '';
            },

            resetAll() {
                this.rawInput = '';
                this.totalInput = 0;
                this.jumlahOrang = 0;
                this.customValues = {};
                this.activeTab = 'bagi';
            }
        }));
    });
</script>
