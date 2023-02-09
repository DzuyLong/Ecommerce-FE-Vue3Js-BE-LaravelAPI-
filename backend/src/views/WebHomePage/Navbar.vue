<template>
    <div class="bg-gray-900 text-gray-50 py-3.5 md:px-8 px-12 shadow-md md:flex justify-between relative  items-center">
      <div class="Navbar-left flex items-center justify-between">
       <div class="logo">
          <span class="text-amber-400 text-2xl mx-4">
            <i class="bi bi-basket3"></i>
          </span>
        </div>
        <div class="Menu">
          <ul class="md:flex z-50 md:items-center md:px-0 px-16 md:pb-0 pb-10 md:static absolute bg-slate-900 md:w-auto w-full 
       md:h-auto h-[250px] top-[52px] left-0 transition-all duration-500 ease-in-out" :class="[openNavbar ? 'left-0' : 'left-[-100%]']">
        <li class="md:mx-5 md:my-0  my-2" v-for="item in navigation" :key="item.name" >
           <router-link :to="item.to" class="relative inline-block leading-8 text-xl hover:after:w-full 
           after:bg-amber-400 after:transition-all after:duration-300 
           after:block after:w-0 after:h-[1px] hover:text-amber-500 
           hover:text-navbar-font ease-in-out transition-all duration-300 
           " 
           >{{ item.name }}</router-link>
        </li>
        <Button>
          Buy Now
        </Button>
       </ul>
      </div>
    
    </div>
       <span @click="ToggleMenuOpen" class="absolute md:hidden right-10 text-amber-400 top-[15px] cursor-pointer text-2xl" >
        <i :class="[openNavbar ? 'bi bi-x-circle' : 'bi bi-menu-button-wide']"></i>  
      </span>
       <div  class="nav-right md:mr-16 md:static absolute z-50 top-[250px] transition-all duration-500 ease-in-out" :class="[openNavbar ? 'left-[64px]' : 'left-[-100%]']">
        <ul v-if="CurrentCustomer.id"  class="relative">
          <div class="user-section flex space-x-10 items-center cursor-pointer">
            <div @click="dropCustomer = !dropCustomer" ref="popup" class="flex items-center space-x-3">
            <div class="avatar">
              <i class="bi bi-person-circle text-xl"></i>
            </div>
            <div class="user-details"><h1 class="text-amber-400 font-semibold">{{ CurrentCustomer.last_name }} {{ CurrentCustomer.first_name }}</h1></div>
          </div>
          <router-link :to="{name:'cartDetails'}">
            <div class="cart-nav flex">
              <i class="bi bi-cart3 text-[23px] hover:text-[25px]"></i>
              <div class="w-8 h-5 leading-4  bg-amber-300 hover:leading-5 hover:w-10 hover:h-6 text-center rounded-full relative -top-1 right-2 border">
                <span class="text-black text-[15px]  font-mono  font-semibold">{{ getCountPd }}</span>
              </div>
            </div>
          </router-link>
          </div>
          <transition name="fade-in-down">
          <div v-if="dropCustomer" class="popover-inner bg-gray-100 rounded-sm absolute right-2 shadow-2xl top-9 z-50 ">
              <div class="user-dropdown min-w-[200px]  text-black">
                <div class="menu-item font-mono px-1 py-1 mx-1 my-1 hover:bg-neutral-300 hover:font-semibold transition-all duration-250 ease-in" role="button">Profile</div>
                <div class="border-b border-gray-300 px-1"></div>
                <div class="menu-item font-mono px-1 py-1 mx-1 my-1 hover:bg-neutral-300 hover:font-semibold transition-all duration-250 ease-in" @click="logoutCustomer" role="button">
                  Log out
                </div>
                
              </div>
          </div>
        </transition>
        </ul>
        <ul v-else class="flex items-center">
          <li class="mr-2 hover:-translate-y-[1px] hover:scale-105 hover:font-semibold hover:text-amber-400 transition-all duration-100 ease-in "><router-link to="login">Login</router-link></li>
          <li class="ml-2 hover:-translate-y-[1px] hover:scale-105 hover:font-semibold  transition-all duration-100 ease-in 
          bg-green-500 hover:bg-green-600 py-2 px-4 rounded-sm "><router-link to="register">Sign up</router-link></li>
        </ul>
       </div>
    </div>
</template>
  
  <script setup>
  import Button from '../WebHomePage/button.vue'
  import store from "../../store";
  import {ref, computed, onMounted ,onBeforeMount} from 'vue'
  import router from "../../router";
  import vueClickOutsideElement from 'vue-click-outside-element'
  const openNavbar = ref(false);
  const dropCustomer = ref(false);
  const popup = ref(null)
  const navigation = [
    { name: 'Home', to: {name: 'homepage'} },
    { name: 'About', to: {name: 'homepage'} },
    { name: 'Contract', to: {name: 'homepage'}},
  ]
  const getCountPd = computed(() => {
  return  store.getters.productCount
}
);
  // const CurrentCustomer = computed(() => store.state.customer.data);
  const  CurrentCustomer = ref({});
  onMounted (() => {
    if(store.state.customer.token){
      // store.dispatch('getCurrentCustomer');
      getCurrentCustomer();
    } 
 // Mouted sự kiện cho việc click outside phần drop down customer
    document.addEventListener('click', (event) => {
        if (!popup.value.contains(event.target)) {
          dropCustomer.value = false;
        }else{
          dropCustomer.value = true;
        }
      })
  })
  function getCurrentCustomer() { 
        store.dispatch("getCurrentCustomer").
        then(({data}) => {
          CurrentCustomer.value  = data;
          });
      }
  function logoutCustomer() {
  store.dispatch('logoutCustomer')
    .then(() => {   
      router.push({ name: 'login' });
    })
}
  function ToggleMenuOpen(){
    openNavbar.value  = !openNavbar.value;
  }
  </script>

  <style scoped>
.fade-in-down-enter-active {
  animation: fadeInDown 0.4s;
}

@keyframes fadeInDown {
  from {
    transform: translate3d(0, -5%, 0);
    /* scale: 0; */
    opacity: 0;
  }

  to {
    transform: translate3d(0, 0, 0);
    /* scale: 1; */
    opacity: 1;
  }
}
@media (max-width: 768px) {
  /* CSS rules for devices with screens less than 767px */
  .popover-inner {
    top: 35px;
    left: 20px ;
    right: auto;
  }
}
</style>