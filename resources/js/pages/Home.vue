<template>
    <Header />
    <div class="h-32"></div>
    <Banner />
    <Kategori/>
    <Rekomendasi />
    <div class="jual-btn">
        <div class="i-jual"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex justify-center items-center gap-2">
            <div class="i-plus"></div>
            <span class="font-medium">JUAL</span>
        </div>
    </div>
</template>

<script>
import Header from '../components/Header.vue';
import Banner from '../components/Banner.vue';
import Kategori from '../components/Kategori.vue';
import Rekomendasi from '../components/Rekomendasi.vue'
export default {
    name: "home-page",
    components: {
        Header,
        Banner,
        Kategori,
        Rekomendasi
    }
}
</script>

<style scoped>
.jual-btn{
    position: fixed;
    z-index: 10;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
}
</style>