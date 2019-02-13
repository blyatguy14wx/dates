<template>
        <tr class="text-center animated fadeIn" v-bind:style="{'color':'black'}" 
                @click="showEsp()">
                                        	<td>{{this.esp.id}}</td>
                                        	<td>{{this.esp.name}}</td>
   </tr>
</template>

<script>
export default {
    props:["esp"],
    data(){
        return{
        }
    },
    methods:{
        showEsp(){
            this.$emit("showO");
        },
    }
}
</script>
