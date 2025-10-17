<template>
    <div>
        <span>{{ props.module.name }}</span>
        <span> {{ props.module.description }}</span>   
        <span style="padding-left: 50px;">
            <button @click="activate()">ON</button>
            <button @click="desactivate()">OFF</button>
        </span>     
        
    </div>

</template>


<script setup>


const props = defineProps({
    module: Object
})

const emit = defineEmits(["activate", "desactivate"])

const activate = () => {    
    emit("activate", props.module.id)
}

const desactivate = () => {
    emit("desactivate", props.module.id)
}

</script>