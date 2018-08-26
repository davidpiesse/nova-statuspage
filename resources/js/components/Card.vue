<template>
    <card class="flex flex-col items-center justify-center">
        <a v-if="loaded" class="px-3 py-4 flex flex-col items-center no-underline text-80" :href="service_url" target="_blank">
            <h2 class="text-center text-3xl text-80 font-light">
                {{service_name}}              
            </h2>
            <svg v-if="indicator == 'none'" class="fill-current text-ok w-8 h-8 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"/></svg>
            <svg v-if="indicator == 'minor'" class="fill-current text-minor w-8 h-8 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
            <svg v-if="indicator == 'major'" class="fill-current text-major w-8 h-8 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
            <svg v-if="indicator == 'critical'" class="fill-current text-critical w-8 h-8 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>
          
            <p v-if="description" class="text-center mt-4">{{description}}</p>
            <p class="text-center font-light text-sm text-60">{{last_updated}}</p>
        </a>
        <div v-else class="flex flex-col text-center">
            <p v-if="error" class="font-medium text-lg">Whoops!</p>
            <p v-if="error" class="font-light">Cannot connect to StatusPage</p>
            <p v-if="error" class="font-light text-60">ID: {{card.page_id}}</p>
            <p v-else class="">Loading...</p>
        </div>
    </card>
</template>

<style scoped>
.text-ok{
    color: #21b978
}
.text-minor{
    color: #3490DC
}
.text-major{
    color: #F6993F
}
.text-critical{
    color: #e74444
}
</style>

<script>
export default {
    props: ['card'],
    data(){
        return {
            status: null,
            loaded: false,
            error: null,
        }
    },
    async mounted() {
        await this.getStatus()
    },
    methods:{
        async getStatus(){
            await Nova.request().get('https://'+this.card.page_id+'.statuspage.io/api/v2/status.json').then(response => {
                this.status = response.data
                this.loaded = true
            }).catch(response =>{
                this.error = response
            })
        },
    },
    computed:{
        indicator(){
            return this.status.status.indicator
        },

        description(){
            return this.status.status.description
        },

        service_name(){
            return this.status.page.name
        },

        last_updated(){
            return moment(this.status.page.updated_at).utcOffset(this.status.page.time_zone).fromNow()
        },

        service_url(){
            return this.status.page.url
        },
    }
}
</script>
