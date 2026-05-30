                    <!-- Progress Bar & Steps -->
                    <div class="relative flex justify-between items-center mb-8">
                        <div class="absolute left-0 right-0 top-5 transform -translate-y-1/2 h-1 bg-gray-200 z-0"></div>
                        <div class="absolute left-0 top-5 transform -translate-y-1/2 h-1 bg-emerald-500 transition-all duration-500 z-0"
                            :style="'width: calc(20px + ' + ((step - 1) / 2) + ' * (100% - 40px))'"></div>

                        <!-- Step 1 -->
                        <div class="relative z-10 flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300 shadow-sm"
                                :class="step >= 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'">
                                1
                            </div>
                            <span class="text-xs font-semibold" :class="step >= 1 ? 'text-emerald-500' : 'text-gray-400'">Info Dasar</span>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative z-10 flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300 shadow-sm"
                                :class="step >= 2 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'">
                                2
                            </div>
                            <span class="text-xs font-semibold" :class="step >= 2 ? 'text-emerald-500' : 'text-gray-400'">Detail & Lokasi</span>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative z-10 flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300 shadow-sm"
                                :class="step >= 3 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'">
                                3
                            </div>
                            <span class="text-xs font-semibold" :class="step >= 3 ? 'text-emerald-500' : 'text-gray-400'">Review</span>
                        </div>
                    </div>
