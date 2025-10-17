import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useModulesStore = defineStore('modulesStore', () => {    
  const modules = ref([])
  const user_modules = ref([])

  async function getModules() {   
    try {       
        
      const response = await fetch('http://127.0.0.1:8000/api/modules', {
        method: "get",        

        headers: {            
            "Content-Type": "application/json",
            Authorization : `Bearer ${localStorage.getItem("token")}`
        }
      })

      if (response.status == 200) {
        const result = await response.json();        
        modules.value =  result     
      }
    } catch (error) {
      return error
    }
  }
  



  async function activate(id) {   
    try {    
        const module = modules.value.filter(module => id == module.id)[0]           
        if (user_modules.value.indexOf(module) == -1){

            const response = await fetch(`http://127.0.0.1:8000/api/modules/${id}/activate`, {
              method: "post",        
      
              headers: {            
                  "Content-Type": "application/json",
                  Authorization : `Bearer ${localStorage.getItem("token")}`
              }
            })
      
            if (response.status == 200) {                            
                user_modules.value.push(module)                                                    
            }
        }
    } catch (error) {
      return error
    }
  }

  async function desactivate(id) {   
    try {       
        const module = modules.value.filter(module => id == module.id)[0]           
        if (user_modules.value.indexOf(module) != -1){

            const response = await fetch(`http://127.0.0.1:8000/api/modules/${id}/desactivate`, {
              method: "post",        
      
              headers: {            
                  "Content-Type": "application/json",
                  Authorization : `Bearer ${localStorage.getItem("token")}`
              }
            })
      
            if (response.status == 200) {
              user_modules.value = user_modules.value.filter(activatedModule => activatedModule.id != id)                            
            }
        }
    } catch (error) {
      return error
    }
  }



  return { getModules, activate, desactivate, modules, user_modules }
},
{
    persist:true
})