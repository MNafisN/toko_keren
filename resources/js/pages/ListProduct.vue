<template>
    <Header page="list-product" />
    <div class="h-28"></div>
    {{ router }}
    <div class="w-full bg-white py-4 px-2">
        <p class="text-subTitle text-xs">Beranda / {{ path1 }} / {{ path2 }}</p>
        <br>
        <p>Menampilkan hasil untuk <b>"{{ path2 }}"</b></p>
        <br>

        <!-- list product -->
        <div class="flex flex-col gap-4">
            <ProductCard />
            <ProductCard />
            <ProductCard />
            <ProductCard />
        </div>
        <!-- //// list product /// -->
        <div class="flex justify-center">
            <button class="h-12 px-[10px] border-2 border-buy-button rounded-md font-bold mt-4 mx-auto">Muat lainnya</button>
        </div>
    </div>
    <JualBtn />
    <Footer />

</template>

<script>
import Header from '../components/Header.vue';
import ProductCard from '../components/ProductCard.vue';
import JualBtn from '../components/JualBtn.vue';
import Footer from '../components/Footer.vue';

export default {
    name: 'list-product',
    components: {
        Header,
        ProductCard,
        JualBtn,
        Footer
    },
    computed: {
        path1() {
            return this.$route.fullPath.split('/')[2]
        },
        path2() {
            return this.$route.fullPath.split('/')[3]
        }
    }
}
</script>