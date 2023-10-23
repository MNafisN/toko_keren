<template>
    <RouterView />
</template>
<script>
import axios from "axios";

export default {
    name: "app",
    mounted() {
        axios.get("/api/user/data").then((res) => {
            if(!res.data.user_data.full_name) this.$router.push("/app/register")
            console.log(res.data.user_data);
            this.$store.commit("setUserData", res.data.user_data);
        });
    },
};
</script>
