<template>
  <div class="fixed z-30 w-full bg-white shadow px-2">

    <header class="flex justify-between items-center py-2">
      <div class="flex gap-2">
        <div @click="toggleMenu" class="w-9 h-9 rounded-full bg-[#C8F8F6] flex justify-center items-center">
          <div :class="isActive ? 'i-x' : 'i-menu'"></div>
        </div>
        <h1 @click="goToHome" class="font-extrabold text-2xl">Fake Olx</h1>
      </div>
      <div v-if="searchable" class="flex items-center gap-1">
        <span class="font-bold">Demak Kab, Jawa Tengah</span>
        <div class="i-location"></div>
      </div>
    </header>

    <!-- toggle menu -->
    <div
      :class="`w-full box-border overflow-hidden relative bg-white transition-all ${isActive ? 'h-screen p-2' : 'h-0 px-2'}`">
      <div class="flex gap-4 items-center py-4">
        <div class="w-[60px] h-[60px] rounded-full overflow-hidden bg-blue-500">
        </div>
        <span v-if="isLogged" class="font-bold text-xl">Username</span>
        <div v-else>
          <p class="text-sm text-subTitle">Masuk ke akun Anda</p>
          <RouterLink to="/app/login" class="text-sm underline">Login ke akun anda</RouterLink>
        </div>
      </div>
      <button v-if="isLogged" @click="goToProfile" class="w-full h-11 rounded-md bg-buy-button text-white font-bold">Lihat
        dan edit profil</button>
      <div class="w-full h-px bg-[rgba(0,0,0,0.5)] mt-4"></div>

      <!-- list menu -->
      <div class="flex gap-4 py-3">
        <div class="i-camera-black"></div>
        <span>Pasang Iklan</span>
      </div>
      <div class="flex gap-4 py-3">
        <div class="i-love"></div>
        <span>Iklan Saya</span>
      </div>
      <div v-if="isLogged" class="flex gap-4 py-3">
        <div class="i-logout"></div>
        <span>Logout</span>
      </div>
      <div class="w-full h-px bg-[rgba(0,0,0,0.5)] mt-4"></div>
      <button v-if="!isLogged" @click="goToLogin"
        class="w-full h-11 rounded-md bg-buy-button text-white font-bold">Login/daftar</button>

      <!-- ///list menu/// -->

    </div>
    <!-- ///toggle menu/// -->

    <div v-if="searchable" class="border-black border-2 rounded-md w-full h-10 my-2 flex items-center gap-2 pl-4">
      <div class="i-search"></div>
      <!-- <span class="text-slate-600">Temukan Mobil, Handphone, dan lainnya</span> -->
      <input
        @focusin="typing"
        @focusout="typing"
        @input="e => search = e.target.value"
        :value="search"
        type="text"
        placeholder="Temukan Mobil, Handphone, dan lainnya"
        class="w-full h-full placeholder:text-slate-600 focus:outline-0"
      >
    </div>
  </div>
</template>

<script>
import { RouterLink } from 'vue-router'

export default {
  name: 'header',
  data() {
    return {
      isActive: false,
      isLogged: false,
      isTyping: false,
      search: ''
    };
  },
  props: {
    page: String
  },
  components: { RouterLink },
  computed: {
    searchable() {
      const listPage = [
        'home',
        'list-product'
      ];
      if (!this.isActive) {
        return listPage.includes(this.page);
      }
      else {
        return false;
      }
    }
  },
  methods: {
    toggleMenu() {
      this.isActive ? this.isActive = false : this.isActive = true;
    },
    goToHome() {
      this.$router.push('/app');
    },
    goToProfile() {
      this.$router.push('/app/profile');
    },
    goToLogin() {
      this.$router.push('/app/login')
    },
    typing() {
      this.isTyping ? this.isTyping = false : this.isTyping = true
    },
    onkeydown(e) {
      if (e.key === "Enter" && this.isTyping) {
        this.$router.push('/app/search/'+this.search)
      }
    }
  },
  mounted() {
    document.addEventListener("keydown", this.onkeydown)
  }
}
</script>
