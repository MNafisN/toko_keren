<template>
    <div class="relative">
        <Header />
        <div class="h-[52px]"></div>
        <Breadcrumb />
        <PhotoProduct />
        <ProductTitle :harga="product.harga" :title="product.produk_judul" />
        <ProductDetail :data="{merek: product.merek, model: product.model, tahun_keluaran: product.tahun_keluaran, jarak_tempuh: product.jarak_tempuh}" />
        <ProductDescription :description="product.produk_deskripsi" />
        <ProductSeller :seller="product.produk_pemasang" />
        <ProductId :id="product.produk_id" />
        <BuyButton />
    </div>
    <Footer />
</template>

<script>
import Header from "../components/Header.vue";
import Breadcrumb from "../components/product/Breadcrumb.vue";
import PhotoProduct from "../components/product/PhotoProduct.vue";
import ProductTitle from "../components/product/ProductTitle.vue";
import ProductDetail from "../components/product/ProductDetail.vue";
import ProductDescription from "../components/product/ProductDescription.vue";
import ProductSeller from "../components/product/ProductSeller.vue";
import ProductId from "../components/product/ProductId.vue";
import BuyButton from "../components/product/BuyButton.vue";
import Footer from "../components/Footer.vue";

import axios from "axios";

export default {
    name: "product-detail",
    data() {
        return {
            product: {}
        }
    },
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
        Footer,
    },
    mounted() {
        axios.get("/api/produk/detail/" + this.$route.params.id).then((res) => {
            console.log(res.data.data);
            this.product = res.data.data
        });
    },
};
</script>
