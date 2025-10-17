import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useUrlShortenerStore = defineStore(
  'urlShortenerStore',
  () => {
    const urls = ref([])

    async function getUrls() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/links', {
          method: 'get',

          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })

        if (response.status == 200) {
          const result = await response.json()
          urls.value = result
        }
      } catch (error) {
        return error
      }
    }

    async function shorten(data) {
      try {
          //https://example.com
          const url = urls.value.filter((Url) => Url.original_url == data.value.original_url)[0]
          console.log(data.value.custom_code)
        if (urls.value.indexOf(url) == -1) {
           
          const response = await fetch(`http://127.0.0.1:8000/api/shorten`, {
            method: 'post',
            body: JSON.stringify({
                original_url : data.value.original_url,
                custom_code : data.value.custom_code
            }),
            headers: {
              'Content-Type': 'application/json',
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          })

          if (response.status == 200) {
            urls.value.push(data)
            console.log(urls)
          }
        }
      } catch (error) {
        return error
      }
    }

    return { getUrls, shorten }
  },
  {
    persist: true,
  },
)
