<template>
  <div class="fixed z-30 w-full bg-white shadow px-2">

    <header class="flex justify-between items-center gap-10 py-2 container mx-auto">
      <!-- logo and toggle -->
      <div class="flex gap-2">
        <div @click="toggleMenu" class="md:hidden w-9 h-9 rounded-full bg-[#C8F8F6] flex justify-center items-center">
          <div :class="isActive ? 'i-x' : 'i-menu'"></div>
        </div>
        <h1 @click="goToHome" class="font-extrabold text-2xl cursor-pointer">Toko Keren</h1>
      </div>

      <!-- desktop only -->
      <div class="flex-1 hidden md:flex border-2 border-buy-button rounded-md overflow-hidden">
        <input
          @focusin="typing"
          @focusout="typing"
          @input="e => search = e.target.value"
          :value="search"
          type="text"
          placeholder="Temukan Mobil, Handphone, dan lainnya"
          class="w-full h-10 px-4"
        >
        <div @click="searchBtn" class="w-20 h-10 bg-buy-button flex justify-center items-center cursor-pointer">
          <div class="i-search-white"></div>
        </div>
      </div>
      <div class="flex items-center">
        <div v-if="isLogged" class="w-10 h-10 bg-blue-600 rounded-full overflow-hidden hidden md:block">
          <img v-if="infoUser.profile_picture" class="w-full h-full object-cover" :src="'/api/user/download_photo/'+infoUser.username" alt="photo profile">
          <span v-else class="text-white text-3xl">{{ initialName }}</span>
        </div>
        <div v-if="isLogged" @click="bubbleToggle" class="relative w-4 h-4 hidden md:block">
          <svg class="cursor-pointer" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m16.843 10.211c.108-.141.157-.3.157-.456 0-.389-.306-.755-.749-.755h-8.501c-.445 0-.75.367-.75.755 0 .157.05.316.159.457 1.203 1.554 3.252 4.199 4.258 5.498.142.184.36.29.592.29.23 0 .449-.107.591-.291 1.002-1.299 3.044-3.945 4.243-5.498z"/></svg>
          <div v-if="bubbleMenu" class="absolute w-max h-max bg-white shadow-lg border top-10 right-6 rounded-md rounded-tr-none lancip">
            <ul class="w-full p-5 text-sm text-subTitle">
              <li @click="goToProfile" class="hover:text-black cursor-pointer pb-1 border-b">Lihat & Edit Profile</li>
              <li @click="goToPost" class="hover:text-black cursor-pointer pt-1">Pasang iklan</li>
              <li @click="goToProfile" class="hover:text-black cursor-pointer pb-1 border-b">Iklan saya</li>
              <li @click="logOut" class="hover:text-black cursor-pointer pt-1">Logout</li>
            </ul>
          </div>
        </div>
        <p v-else @click="goToLogin" class="font-extrabold text-lg underline hidden md:block">Login/Register</p>
        <JualBtn header class="ml-5" />
      </div>
    </header>

    <!-- toggle menu -->
    <div
      :class="`w-full box-border overflow-hidden relative bg-white transition-all ${isActive ? 'h-screen p-2' : 'h-0 px-2'}`">
      <div class="flex gap-4 items-center py-4">
        <div class="w-[60px] h-[60px] rounded-full overflow-hidden bg-blue-500 flex justify-center items-center">
          <img v-if="infoUser.profile_picture" :src="'/api/user/download_photo/'+infoUser.username" alt="photo profile">
          <span v-else class="text-white text-3xl">{{ initialName }}</span>
        </div>
        <span v-if="isLogged" class="font-bold text-xl">{{ infoUser.username }}</span>
        <div v-else>
          <p class="text-sm text-subTitle">Masuk ke akun Anda</p>
          <RouterLink to="/app/login" class="text-sm underline">Login ke akun anda</RouterLink>
        </div>
      </div>
      <button v-if="isLogged" @click="goToProfile" class="w-full h-11 rounded-md bg-buy-button text-white font-bold">Lihat
        dan edit profil</button>
      <div class="w-full h-px bg-[rgba(0,0,0,0.5)] mt-4"></div>

      <!-- list menu -->
      <div @click="goToPost" class="flex gap-4 py-3">
        <div class="i-camera-black"></div>
        <span>Pasang Iklan</span>
      </div>
      <div @click="goToProfile" class="flex gap-4 py-3">
        <div class="i-love"></div>
        <span>Iklan Saya</span>
      </div>
      <div v-if="isLogged" @click="logOut" class="flex gap-4 py-3">
        <div class="i-logout"></div>
        <span>Logout</span>
      </div>
      <div class="w-full h-px bg-[rgba(0,0,0,0.5)] mt-4"></div>
      <button v-if="!isLogged" @click="goToLogin"
        class="w-full h-11 rounded-md bg-buy-button text-white font-bold">Login/daftar</button>

      <!-- ///list menu/// -->

    </div>
    <!-- ///toggle menu/// -->

    <div v-if="searchable" class="md:hidden container mx-auto border-black border-2 rounded-md w-full h-10 my-2 flex items-center gap-2 pl-4">
      <div class="i-search"></div>
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
import axios from 'axios';
import { RouterLink } from 'vue-router'
import JualBtn from './JualBtn.vue';

export default {
  name: 'header-component',
  data() {
    return {
      isActive: false,
      isTyping: false,
      bubbleMenu: false,
      search: ''
    };
  },
  props: {
    page: String
  },
  components: { RouterLink, JualBtn },
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
    },
    infoUser() {
      return this.$store.getters.getUserData
    },
    initialName() {
      return this.infoUser.username.split("")[0]
    },
    isLogged() {
      return this.$store.getters.getIsLogged
    }
  },
  methods: {
    toggleMenu() {
      this.isActive ? this.isActive = false : this.isActive = true;
    },
    bubbleToggle() {
      this.bubbleMenu ? this.bubbleMenu = false : this.bubbleMenu = true
    },
    goToHome() {
      this.$router.push('/app');
    },
    goToProfile() {
      this.$router.push('/app/profile');
    },
    goToPost() {
      this.$router.push('/app/post')
    },
    goToLogin() {
      this.$router.push('/app/login')
    },
    typing() {
      this.isTyping ? this.isTyping = false : this.isTyping = true
    },
    onkeydown(e) {
      if (e.key === "Enter" && this.isTyping && this.search) {
        this.$router.push('/app/search/'+this.search)
      }
    },
    searchBtn() {
      if (this.search) {
        this.$router.push('/app/search/'+this.search)        
      }
    },
    logOut() {
      axios
        .post('/api/user/logout')
        .then((res)=>{
          console.log(res.data)
          this.$store.commit('deleteUserData')
          this.$router.push('/app/login')
        })
    }
  },
  mounted() {
    document.addEventListener("keydown", this.onkeydown)
    }

}
</script>

<style scoped>
  .lancip::before{
    content: '';
    width: 15px;
    height: 15px;
    position: absolute;
    top: -8px;
    right: 2px;
    background-color: white;
    border-width: 1px;
    border-right-width: 0;
    border-bottom-width: 0;
    border-radius: 3px;
    transform: rotate(45deg);
  }
</style>