<template>
    <div class="p-2 bg-white relative">
        <Swiper
        :pagination="{
            el: '.pagination',
            type: 'bullets'
        }"
        :modules="modules"
        >
            <SwiperSlide>
                <div class="w-full h-48 rounded-md bg-blue-400">Slide 1</div>
            </SwiperSlide>
            <SwiperSlide>
                <div class="w-full h-48 rounded-md bg-blue-400">Slide 2</div>
            </SwiperSlide>
            <SwiperSlide>
                <div class="w-full h-48 rounded-md bg-blue-400">Slide 3</div>
            </SwiperSlide>
            <div class="pagination flex justify-center gap-2 mt-2"></div>
        </Swiper>
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