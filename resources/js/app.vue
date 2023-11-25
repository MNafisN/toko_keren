<template>
    <RouterView />
</template>

<script>
export default {
    name: "app",
    created() {
        this.$store.dispatch('pullUserData')
    }
};
</script>
