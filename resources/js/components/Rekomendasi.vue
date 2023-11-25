<template>
    <div class="mt-3 p-4 bg-white">
        <p class="container mx-auto">Rekomendasi baru</p>
        <div class="container mx-auto grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
            <ProductCard v-for="item in list" page="home" :produk="item" />
        </div>
    </div>
</template>
<script>
import ProductCard from './ProductCard.vue';
export default {
    name: "rekomendasi",
    components: {
        ProductCard
    },
    props: {
        list: Array
    }
}
</script>