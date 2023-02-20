<template>
     <transition name="fade-in-down">
             <div v-if="showButtonScroll" class="right-[1.5rem] top-[40rem] text-[40px] fixed hover:translate-y-[-4px]
            transition-all duration-200 ease-in">
                <button @click="scrollToTop"><i class="bi bi-arrow-up-square-fill"></i></button>
              </div>
    </transition>
</template>

<script setup>
import {computed, onMounted,onUnmounted, onUpdated, ref, reactive,  watch} from "vue";

const showButtonScroll = ref(false);
onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});
onUnmounted(() => {
      window.removeEventListener('scroll', handleScroll);
      
    });
/* hàm xử lý cho nút button scrollTop biến `showButton` sẽ được 
  thay đổi theo vị trí của thanh cuộn (dùng `window.pageYOffset` 
  để lấy vị trí hiện tại). Nếu thanh cuộn đang ở vị trí `top > 0`, biến `showButton`
  sẽ được thiết lập thành `true` và nút sẽ hiển thị. Nếu thanh cuộn đang ở vị trí `top = 0`, 
  biến `showButton` sẽ được thiết lập thành `false` */ 
function handleScroll() {
      if (window.pageYOffset > 200) {
        showButtonScroll.value = true;
      } else {
        showButtonScroll.value = false;
      }
    }
function scrollToTop() {
      window.scroll({
        top: 0,
        left: 0,
        behavior: 'smooth'
      });
}
</script>

<style scoped>
.fade-in-down-enter-active {
  animation: fadeInDown 0.4s;
}
@keyframes fadeInDown {
  from {
    transform: translate3d(0, -13%, 0);
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