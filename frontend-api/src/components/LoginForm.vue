<template>    
    <h3>Login Form</h3>
    <label for="email">Email</label><br/>
    <input name="email" type="email" v-model="data.email" /><br/>
    <label for="password">Password</label><br/>
    <input name="password" type="password" v-model="data.password" /><br/>
    <button @click="register()"> Submit </button><br/>
</template>


<script setup>
import { useAuthStore } from '@/stores/authStore';
import { ref } from 'vue';

const authStore = useAuthStore();
const data = ref({    
    email: "",
    password: "",    
})
const register = () => {
    authStore.login(data)
}

</script>