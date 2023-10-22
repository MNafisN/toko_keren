<template>
    <Header page="home" />
    <div class="h-28"></div>
    <Banner />
    <Kategori/>
    <Rekomendasi :list="listProduk" />
    <JualBtn />
    <Footer />

</template>

<script>
import Header from '../components/Header.vue';
import Banner from '../components/Banner.vue';
import Kategori from '../components/Kategori.vue';
import Rekomendasi from '../components/Rekomendasi.vue'
import JualBtn from '../components/JualBtn.vue';
import Footer from '../components/Footer.vue';

import axios from 'axios';

export default {
    name: "home-page",
    data() {
        return {
            listProduk: []
        }
    },
    components: {
        Header,
        Banner,
        Kategori,
        Rekomendasi,
        JualBtn,
        Footer
    },
    mounted() {
        axios.get('/api/produk')
        .then((res)=> {
            this.listProduk = res.data.data
        })
    }
}
</script>
