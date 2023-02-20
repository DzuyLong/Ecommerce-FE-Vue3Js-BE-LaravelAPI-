<template>
  <transition name="modal">
     <div  class="modal" v-show="showModal">
    <div class="modal__overlay" @click="closeModal"></div>
    <div class="modal__content">
      <div class="modal__header">
        <h2 class="text-xl font-bold">{{ title }}</h2>
        <button class="modal__close" @click="closeModal">×</button>
      </div>
      <div class="modal__body">
        <slot></slot>
      </div>
    </div>
  </div>
</transition>
  </template>
  
  <script setup>
   import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
    import { ref ,computed ,onMounted, onUpdated, onBeforeUnmount} from 'vue'
    import { getCurrentInstance } from 'vue';
    const props = defineProps({
      showModal: Boolean,
      title: String,
  })
  const emit = defineEmits(['close-modal'])
  function closeModal() {
    emit('close-modal');
  }


  </script>

  <style scoped>
  /* Hiệu ứng cho modal mở */
.modal-enter-active {
  transition: all 0.3s ease;
  transform: translateY(-50px);
  opacity: 0;
}

.modal-enter-to {
  transform: translateY(0);
  opacity: 1;
}

/* Hiệu ứng cho modal đóng */
.modal-leave-active {
  transition: all 0.3s ease;
  transform: translateY(0);
  opacity: 1;
}

.modal-leave-to {
  transform: translateY(-50px);
  opacity: 0;
}
  .modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal__overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: transparent;
}

.modal__content {
  position: relative;
  max-width: 600px;
  width: 100%;
  padding: 1rem;
  background-color: #fff;
  border-radius: 0.25rem;
}

.modal__header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.modal__close {
  font-size: 2rem;
  font-weight: bold;
  color: #000;
  background-color: transparent;
  border: none;
  cursor: pointer;
}

.modal__body {
  margin-bottom: 1rem;
}
</style>