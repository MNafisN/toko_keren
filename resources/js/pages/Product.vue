<template>
    <Header page="product" />
    <div class="h-[68px]"></div>
    <Breadcrumb />
    <PhotoProduct />
    <ProductTitle />
    <ProductDetail />
    <ProductDescription />
</template>

<script>
import Header from '../components/Header.vue';
import Breadcrumb from '../components/product/Breadcrumb.vue';
import PhotoProduct from '../components/product/PhotoProduct.vue';
import ProductTitle from '../components/product/ProductTitle.vue';
import ProductDetail from '../components/product/ProductDetail.vue';
import ProductDescription from '../components/product/ProductDescription.vue';
export default {
    name: 'product-detail',
    components: {
        Header,
        Breadcrumb,
        PhotoProduct,
        ProductTitle,
        ProductDetail,
        ProductDescription
    }
}
</script>