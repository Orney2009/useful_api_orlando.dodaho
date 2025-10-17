<template>    
    <h3>Registration Form</h3>
    <label for="original">Original Url</label><br/>
    <input name="original" v-model="data.original_url" /><br/>
    <label for="custom">Custom</label><br/>
    <input name="custom" v-model="data.custom_code" /><br/>
    
    <button @click="shorten()"> Shorten Url </button><br/>
</template>


<script setup>
import { useUrlShortenerStore } from '@/stores/urlShortenerStore';
import { ref } from 'vue';

const urlShortenerStore = useUrlShortenerStore();
const data = ref({
    original_url: "",
    custom_code: "",
})
const shorten = async () => {
    
    await urlShortenerStore.shorten(data)
}

</script>