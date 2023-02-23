<template>
    <div class="relative box-border ml-3 min-w-0 bg-white shadow-xl rounded-md flex-grow font-mono">
        <div class="flex flex-col relative min-h-full ">
            <div class="contents">
                <div class="flex flex-col">
                    <div class="p-5 box-border border-b-[1px] border-neutral-200 flex items-center">
                        <div class="flex-1">
                            <div class="font-semibold text-2xl text-black">My profile</div>
                        </div>                
                    </div>
                    <div class="flex flex-col gap-4 p-4">
                        <div class="flex gap-3">
                            <label class="w-[20%] flex justify-end text-neutral-500">Tên đăng nhập: </label>
                            <span v-if="isEditingName" class="w-[80%] flex items-center gap-5">
                                <input type="text" class="w-full" name="" id="" v-model="profileCustomer.last_name" placeholder="Last Name">
                                <input type="text" class="w-full" name="" id="" v-model="profileCustomer.first_name" placeholder="First Name">
                            </span>
                            <span v-else class="w-[80%]">{{ profileCustomer.last_name}} {{ profileCustomer.first_name}}
                                <a class="text-amber-600 underline cursor-pointer" @click="startEditingName">sửa đổi</a>
                            </span>
                        </div>
                        <div class="flex gap-3">
                            <label class="w-[20%] flex justify-end text-neutral-500">Số điện thoại: </label>
                            <span v-if="isEditingSdt" class="w-[80%]">
                                <input type="text" class="w-full" name="" id="" v-model="profileCustomer.telephone">
                            </span>
                            <span v-else  class="w-[80%] flex items-center gap-7">
                                {{ profileCustomer.telephone }}
                                <a class="text-amber-600 underline cursor-pointer" @click="startEditSdt">sửa đổi</a>
                            </span> 
                        </div>
                        <div class="flex gap-3">
                            <label class="w-[20%] flex justify-end text-neutral-500">Email: </label>
                            <span v-if="isEditing" class="w-[80%]">
                                <input type="email" class="w-full" name="" id="" v-model="profileCustomer.email">
                            </span> 
                            <span v-else  class="w-[80%] flex items-center gap-7">
                                {{ profileCustomer.email }}
                                <a class="text-amber-600 underline cursor-pointer" @click="startEdit">sửa đổi</a>
                            </span> 
                        </div>
                        <div class="flex gap-3">
                            <label class="w-[20%] flex justify-end text-neutral-500">Giới tính: </label>
                            <span class="w-[80%]">
                                <input type="radio" v-model="profileCustomer.gioitinh" :value="'Nam'">
                                     Nam
                                <input type="radio" v-model="profileCustomer.gioitinh" :value="'Nữ'">
                                     Nữ
                                <input type="radio" v-model="profileCustomer.gioitinh" :value="'Khác'">
                                     Khác
                            </span> 
                        </div>
                        <div class="flex gap-3">
                            <label class="w-[20%] flex justify-end text-neutral-500">Ngày Sinh: </label>
                            <span class="w-[80%]"> 
                                <VueDatePicker v-model="profileCustomer.ngaysinh" :auto-position="false" :enable-time-picker="false" placeholder="Select Date"/>
                            </span>
                        </div>
                        <div class="text-center">
                            <button @click="updateProfile(profileCustomer)" class="px-7 py-2 bg-amber-400">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import {computed,onMounted, onUpdated, ref, watch} from 'vue'
import Modal from './Modal_Address.vue'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import store from '../../store';
import Swal from 'sweetalert2';
import router from "../../router";
onMounted( () => {
    getProfile();
})
const profileCustomer = ref({})
function getProfile() {
    store.dispatch('getCurrentCustomer').
    then( response => {
        profileCustomer.value = response.data;
        console.log(response.data);
    })
}
const isEditing = ref(false);
const isEditingSdt = ref(false);
const isEditingName = ref(false);
function startEditingName () {
    isEditingName.value = true;
}
function startEdit() {
      isEditing.value = true;
}
function startEditSdt() {
    isEditingSdt.value = true;
}
const gioitinh = ref('Nam');
function updateProfile(data) {
    store.dispatch('updateProfile', data).
    then(async response => {
        await Swal.fire({
                title: 'Cập nhật hồ sơ',
                icon: 'success',
                preConfirm: () => {
                     router.push({name: 'customer.profile'}).then(() => {
                    location.reload();
                    });
             }
        });
        getProfile();
      console.log(response.data);
    });
}
</script>
<style scoped>

</style>