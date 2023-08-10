<template>
    <div class="relative">
        <Header />
        <div class="h-[68px]"></div>
        <Breadcrumb />
        <PhotoProduct />
        <ProductTitle />
        <ProductDetail />
        <ProductDescription />
        <ProductSeller />
        <ProductId />
        <BuyButton />
    </div>
    <Footer />
</template>

<script>
import Header from '../components/Header.vue';
import Breadcrumb from '../components/product/Breadcrumb.vue';
import PhotoProduct from '../components/product/PhotoProduct.vue';
import ProductTitle from '../components/product/ProductTitle.vue';
import ProductDetail from '../components/product/ProductDetail.vue';
import ProductDescription from '../components/product/ProductDescription.vue';
import ProductSeller from '../components/product/ProductSeller.vue';
import ProductId from '../components/product/ProductId.vue';
import BuyButton from '../components/product/BuyButton.vue';
import Footer from '../components/Footer.vue';

export default {
    name: 'product-detail',
    components: {
        Header,
        Breadcrumb,
        PhotoProduct,
        ProductTitle,
        ProductDetail,
        ProductDescription,
        ProductSeller,
        ProductId,
        BuyButton,
        Footer
    }
}
</script>