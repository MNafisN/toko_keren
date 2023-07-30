<template>
    <div class="mt-3 p-4 bg-white">
        <p>Rekomendasi baru</p>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
            <ProductCard />
            <ProductCard />
            <ProductCard />
            <ProductCard />
        </div>
    </div>
</template>
<script>
import ProductCard from './ProductCard.vue';
export default {
    name: "rekomendasi",
    components: {
        ProductCard
    }
}
</script>