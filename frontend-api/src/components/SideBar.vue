<template>
    <div v-if="modulesStore.user_modules.length ==0">
        No module activated
    </div>
    <div v-else v-for="activeModule in modulesStore.user_modules" :key="activeModule.id">
        <span>{{ activeModule.name }}</span>
    </div>
    

</template>


<script setup>

import { useModulesStore } from '@/stores/modulesStore';

const modulesStore = useModulesStore()



</script>
