<template>
    <aside>
        <SideBar/>
    </aside>
  <main>    
    <ModuleComponent v-for="module in modulesStore.modules" :key="module.id" :module="module" @desactivate="desactivate" @activate="activate"/>
  </main>
</template>


<script setup>
import ModuleComponent from '@/components/ModuleComponent.vue';
import SideBar from '@/components/SideBar.vue';
import { onMounted } from 'vue';
import { useModulesStore } from '@/stores/modulesStore';

const modulesStore = useModulesStore()

onMounted( async() => {
    modulesStore.getModules()
})

const activate = async(id) =>{
    console.log(id)
    modulesStore.activate(id)
}

const desactivate = async(id) =>{
    modulesStore.desactivate(id)
}
</script>
