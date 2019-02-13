<template>

   <tr class="text-center animated fadeIn" v-bind:style="sty" @click="showThis">
                                        	<td>{{this.citaV.id}}</td>
                                            <td><img :src="this.citaV.img" alt="" width="60px" height="60px" class="img-circle"></td>
                                        	<td v-if="!this.showButton">{{this.citaV.paciente}}</td>
                                        	<td>{{momentDate}}</td>
                                        	<td v-if="!this.showButton">{{createMomentDate}}</td>
                                            <td><div class="pe-7s-graph2" :title="addTit" :class="classtoadd"></div></td>
                                            <td> <router-link class="btn btn-primary" v-if="this.showButton" :to="{name:'citas',params:{id:this.citaV.id,show:2}}">VER CITA</router-link> </td>
   </tr>
</template>


<script>
export default {
    data(){
        return{
            classtoadd:
                {
                    "alert-danger":this.citaV.status == 0 ? true:false,
                    "alert-success":this.citaV.status == 1 ? true:false,
                    "alert-warning":this.citaV.status == 2 ? true:false,
            },
             
            sty:{
                "color":"black"
            }
        }
    },
    methods:{
        showThis(){
            this.$emit('showUp');
        }
    },
    computed:{
        momentDate(){
            moment.locale('es');
            return moment(this.citaV.fechaCita).format('dddd DD MMMM HH:mm A')
        },
        createMomentDate(){
            return moment(this.citaV.creted_at).format('dddd DD MMMM HH:mm A');
        },
        addTit(){
            switch (this.citaV.status) {
                case 1:
                    return "activa"
                    break;
                case 0:
                    return "inactiva"
                    break;
                    case 2:
                    return "pendiente"
                    break;
                default:
                    break;
            }
        }
    },
    props:['citaV','showButton']
}
</script>

