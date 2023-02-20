<template>
<div class="flex items-center space-x-5 p-4 border-b-[1px] border-neutral-100">
    <div class="avatar-customer">
        <!-- <img src="" alt=""> -->
        <i class="bi bi-person-circle text-xl"></i>
    </div>
    <div class="name-customer">
        <h1>Phạm Duy long</h1>
        <div class="text-neutral-400 flex items-center space-x-1"><i class="bi bi-pencil-square"></i><h1>Sửa hồ sơ</h1></div>
    </div>
</div>
<div class="options-profile">
    <div class="my-account">
        <div class="profile flex items-center space-x-3 px-3 cursor-pointer" @click="dropProfile = !dropProfile">
        <i class="bi bi-person text-2xl text-teal-400"></i>
        <h1>Tài khoản của tôi</h1>
        </div>    
        <transition name="fade-in-down">          
        <div v-if="dropProfile" class="dropdown-profile flex flex-col gap-2 pl-[25px] pb-[10px]">
            <router-link :to="{name: 'customer.profile'}">
            <div class="flex items-center space-x-2 ml-[3px]">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-person-vcard-fill text-orange-500" viewBox="0 0 16 16">
                 <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z"/>
            </svg>
                <span class="block">Hồ Sơ</span>        
            </div>
        </router-link>
            <router-link :to="{name: 'customer.address'}">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-geo-alt-fill text-red-600" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                </svg>
                <span class="block">Địa chỉ</span>
            </div>
            </router-link>
        </div>  
        </transition>
    </div>
    <div class="purchased">
       
        <div class="profile flex items-center space-x-3 px-3 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-clipboard-data-fill ml-[2px] text-red-600" viewBox="0 0 16 16">
            <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"/>
            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1ZM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V8Zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1Zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"/>
            </svg>
        <h1>Đơn Mua</h1>
        </div> 
   
    </div>
</div>
</template>

<script setup>
import store from '../../store';
import ButtonScroll from '../../views/button/buttonScroll.vue'
import {computed, onMounted, ref, watch , toRefs} from "vue";

const dropProfile = ref(false);

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

</style>