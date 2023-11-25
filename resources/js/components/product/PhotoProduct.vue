<template>
    <Swiper
    :modules="modules"
    :pagination="true"
    >
        <SwiperSlide v-for="foto in list">
            <div class="w-full h-48 sm:h-56 md:h-64 lg:h-72 xl:h-80 rounded-md bg-white">
                <img class="w-full h-full object-contain" :src="`/api/produk/download_photo/${foto.file_name}`" alt="">
            </div>
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
    props: {
        list: Array
    },
    setup() {
        return {
            modules: [Pagination]
        }
    }
}
</script>