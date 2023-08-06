<template>
    <div class="fixed z-10 p-2 w-full bg-white">
        <header class="flex justify-between items-center py-2">
            <div class="flex gap-2">
                <div class="w-9 h-9 rounded-full bg-[#C8F8F6] flex justify-center items-center">
                    <label class="burger" for="burger">
                        <input type="checkbox" id="burger" />
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>
                </div>
                <h1 class="font-extrabold text-2xl">Fake Olx</h1>
            </div>
            <div v-if="page !== 'product'" class="flex items-center gap-1">
                <span class="font-bold">Demak Kab, Jawa Tengah</span>
                <div class="i-location"></div>
            </div>
        </header>
        <div v-if="page !== 'product'" class="border-black border-2 rounded-md w-full h-10 my-2 flex items-center gap-2 px-4">
            <div class="i-search"></div>
            <span class="text-slate-600">Temukan Mobil, Handphone, dan lainnya</span>
        </div>
    </div>
</template>

<script>
export default {
  name: 'header',
  props: {
    page: String
  }
}
</script>

<style scoped>
.burger {
  position: relative;
  width: 40px;
  height: 30px;
  background: transparent;
  cursor: pointer;
  display: block;
}

.burger input {
  display: none;
}

.burger span {
  display: block;
  position: absolute;
  height: 4px;
  width: 100%;
  background: black;
  border-radius: 9px;
  opacity: 1;
  left: 0;
  transform: rotate(0deg);
  transition: .25s ease-in-out;
}

.burger span:nth-of-type(1) {
  top: 0px;
  transform-origin: left center;
}

.burger span:nth-of-type(2) {
  top: 50%;
  transform: translateY(-50%);
  transform-origin: left center;
}

.burger span:nth-of-type(3) {
  top: 100%;
  transform-origin: left center;
  transform: translateY(-100%);
}

.burger input:checked ~ span:nth-of-type(1) {
  transform: rotate(45deg);
  top: 1px;
  left: 5px;
}

.burger input:checked ~ span:nth-of-type(2) {
  width: 0%;
  opacity: 0;
}

.burger input:checked ~ span:nth-of-type(3) {
  transform: rotate(-45deg);
  top: 27px;
  left: 5px;
}
.burger{
    scale: 0.5;
}
</style>
