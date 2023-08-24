<template>
    <Swiper
    :modules="modules"
    :pagination="true"
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
    </Swiper>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination'
export default {
    name: 'photo-product',
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