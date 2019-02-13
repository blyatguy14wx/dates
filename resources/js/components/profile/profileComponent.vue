<template>

<userOne v-if="id!=null" :userIn="id" :fromOther=true></userOne>

</template>

<script>
export default {
    data(){
        return{
            id:null
        }   
    },
    methods:{
        getUser(){
            axios.get('/api/api/profile',{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`}}).then((resolve)=>{
                this.id=JSON.parse(JSON.stringify(resolve.data.id));
            }).catch((reject)=>{
                
            })
        }
    },
    created(){
        this.getUser();
    }
}
</script>
