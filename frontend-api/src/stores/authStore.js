import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useAuthStore = defineStore('authStore', () => {
  const count = ref(0)
  const doubleCount = computed(() => count.value * 2)
  function increment() {
    count.value++
  }
  async function registration(data) {
    if (!(data.value.name.trim() || data.value.email.trim() || data.value.password.trim())) {
      return
    }

    try {
        /* const tokenSanctum = await fetch('http://127.0.0.1:8000/sanctum/csrf-cookie');   
        console.log(tokenSanctum.getCookie('XSRF-TOKEN'))
        const csrfToken =  tokenSanctum.getCookie('XSRF-TOKEN') */


        /* console.log(tokenSanctum) */
      const response = await fetch('http://127.0.0.1:8000/api/register', {
        method: "post",
        body: JSON.stringify({
          name: data.value.name,
          email: data.value.email,
          password: data.value.password.toString(),
        }),

        headers: {
            // 'X-XSRF-TOKEN': csrfToken
            "Content-Type": "application/json"
        }
      })
      console.log('response')
      console.log(response)
      if (response.status == 201) {
        console.log(response)
      }
    } catch (error) {
      return error
    }
  }

  async function login(data) {
    if (!(data.value.email.trim() || data.value.password.trim())) {
      return
    }

    try {

      const response = await fetch('http://127.0.0.1:8000/api/login', {
        method: "post",
        body: JSON.stringify({          
          email: data.value.email,
          password: data.value.password.toString(),
        }),

        headers: {            
            "Content-Type": "application/json"
        }
      })
      
      if (response.status == 200) {
        const result = await response.json();        
        const token =  result.token        
        localStorage.setItem("token", token)
      }
    } catch (error) {
      return error
    }
  }

  return { count, doubleCount, increment, registration, login }
})
