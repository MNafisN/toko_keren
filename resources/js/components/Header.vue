<template>
    <div class="fixed z-30 w-full bg-white shadow px-2">

        <header class="flex justify-between items-center py-2">
            <div class="flex gap-2">
                <div @click="toggleMenu" class="w-9 h-9 rounded-full bg-[#C8F8F6] flex justify-center items-center">
                  <div :class="isActive ? 'i-x' : 'i-menu'"></div>
                </div>
                <h1 @click="goToHome" class="font-extrabold text-2xl">Fake Olx</h1>
            </div>
            <div v-if="page === 'home' && isActive === false" class="flex items-center gap-1">
                <span class="font-bold">Demak Kab, Jawa Tengah</span>
                <div class="i-location"></div>
            </div>
        </header>

        <!-- toggle menu -->
        <div :class="`w-full box-border overflow-hidden relative bg-white transition-all ${isActive ? 'h-screen p-2' : 'h-0 px-2'}`">
          <div class="flex gap-4 items-center py-4">
            <div class="w-[60px] h-[60px] rounded-full overflow-hidden bg-blue-500">
            </div>
            <span class="font-bold text-xl">Username</span>
          </div>
          <button @click="goToProfile" class="w-full h-11 rounded-md bg-buy-button text-white font-bold">Lihat dan edit profil</button>
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
          <div class="flex gap-4 py-3">
            <div class="i-logout"></div>
            <span>Logout</span>
          </div>
          <!-- ///list menu -->

        </div>
        <!-- ///toggle menu/// -->

        <div v-if="page === 'home'" class="border-black border-2 rounded-md w-full h-10 my-2 flex items-center gap-2 px-4">
            <div class="i-search"></div>
            <span class="text-slate-600">Temukan Mobil, Handphone, dan lainnya</span>
        </div>
    </div>
</template>

<script>
export default {
  name: 'header',
  data() {
    return {
      isActive: false
    }
  },
  props: {
    page: String
  },
  methods: {
    toggleMenu() {
      this.isActive ? this.isActive = false : this.isActive = true
    },
    goToHome() {
      this.$router.push('/app')
    },
    goToProfile() {
      this.$router.push('/app/profile')
    }
  }
}
</script>
