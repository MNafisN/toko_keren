<template>
    <div @click="goToPost" :class="`relative cursor-pointer ${header? 'hidden md:block' : 'md:hidden jual-btn'}`">
        <div class="i-jual"></div>
        <div :class="`${header ? 'jual-text' : 'jual-text'} absolute flex justify-center items-center gap-2`">
            <div class="i-plus"></div>
            <span class="font-medium">JUAL</span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'jual-btn',
    props: {
        header: Boolean
    },
    methods: {
        goToPost() {
            this.$router.push('/app/post')
        }
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
.jual-text{
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>