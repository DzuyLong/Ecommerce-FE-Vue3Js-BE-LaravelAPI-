<template>
<div class="container px-10 py-10">
    <table class="w-full">
      <thead>
        <tr class="font-mono text-xl">
          <th>Hình Ảnh</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Unit Price</th>
          <th>Total Price</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(cart, index) in carts" :key="index" class="text-center font-mono text-xl  ">
            <td><img class="w-36 h-[8rem] object-fill inline" :src="`http://localhost:8000/uploads/images/${cart.image}`"  :alt="cart.title"></td>
            <td>{{ cart.title }}</td>
            <td>{{ cart.pivot.quantity }}</td>
            <td> {{ $filters.currencyUSD(cart.price) }}</td>
            <td class="text-red-600"> {{ $filters.currencyUSD(cart.price * cart.pivot.quantity) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import store from '../../../store';
import {computed, onMounted, ref} from "vue";
// const cart = ref({});
const carts = computed(() => store.state.customer.cartData);
onMounted(() => {
    // getCart();
    store.dispatch('getCart');
});

// function getCart() {
//             store.dispatch('getCart').
//             then(response => {
//                 cart.value = response.data;
//                 console.log(cart.value);
//             }).catch(error => {
//           console.error(error);
//         });
//         }
// const productCount = computed(() => {
//   const uniqueProducts = new Set(cart.value.map(item => item.id))
//   return uniqueProducts.size
// });

</script>