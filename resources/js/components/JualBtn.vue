<template>
    <div @click="goToPost" class="jual-btn">
        <div class="i-jual"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex justify-center items-center gap-2">
            <div class="i-plus"></div>
            <span class="font-medium">JUAL</span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'jual-btn',
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
</style>