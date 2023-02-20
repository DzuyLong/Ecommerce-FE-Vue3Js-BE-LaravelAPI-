<template>
<Navbar />
<div class="w-[1000px] m-auto flex p-1">
<div class="block w-[250px] bg-white font-mono">
<SidebarProfile />
</div>
 <router-view></router-view>
</div>
</template>

<script setup>
import Navbar from '../views/WebHomePage/Navbar.vue'
import SidebarProfile from '../views/Customer_profile/SideBar_profile.vue'
</script>