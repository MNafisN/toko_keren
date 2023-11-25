<template>
    <div class="bg-white">
        <div class="container mx-auto p-2 relative">
            <Swiper
            :pagination="{
                el: '.pagination',
                type: 'bullets'
            }"
            :modules="modules"
            >
                <SwiperSlide>
                    <div class="w-full h-48 sm:h-56 md:h-64 lg:h-72 xl:h-80 rounded-md bg-blue-400 flex justify-center items-center">
                        <span class="text-white text-6xl font-bold">Promosi 1</span>
                    </div>
                </SwiperSlide>
                <SwiperSlide>
                    <div class="w-full h-48 sm:h-56 md:h-64 lg:h-72 xl:h-80 rounded-md bg-blue-400 flex justify-center items-center">
                        <span class="text-white text-6xl font-bold">Promosi 2</span>
                    </div>
                </SwiperSlide>
                <SwiperSlide>
                    <div class="w-full h-48 sm:h-56 md:h-64 lg:h-72 xl:h-80 rounded-md bg-blue-400 flex justify-center items-center">
                        <span class="text-white text-6xl font-bold">Promosi 3</span>
                    </div>
                </SwiperSlide>
                <div class="pagination flex justify-center gap-2 mt-2"></div>
            </Swiper>
        </div>
</div>
</template>

<script>
import {Swiper, SwiperSlide} from 'swiper/vue'
import {Pagination} from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/pagination'
export default {
    name: "banner",
    components: {
        Swiper,
        SwiperSlide
    },
    setup() {
        return {
            modules: [Pagination]
        }
    }
}
</script>