<template>
   <tr class="text-center animated fadeIn" v-bind:style="sty" @click="showThis">
                                        	<td>{{this.userV.id}}</td>
                                        	<td>{{this.userV.name}}</td>
                                            <td>{{this.userV.email}}</td>
                                            <td>{{this.userV.contacto}}</td>
                                             <td>{{this.userV.isAdmin ? 'Administrador':'Normal'}}</td><!--FOR THE ROL ISADMIN-->
                                              <td>{{this.userV.isDoctor ? 'Doctor':'Paciente'}}</td><!--FOR THE TYPE ISDOCTOR-->
                                            <td>{{this.userV.age}}</td>
                                            <td>{{this.userV.dui}}</td>
                                            <td><div class="pe-7s-graph2" :title="{'Activa':this.userV.isAllow,'Inactiva':this.userV.isAllow}" :class="classtoadd"></div></td><!--Estado-->
   </tr>
</template>

<script>
export default {
    props:['userV'],
    data(){
        return{
            classtoadd:{
                "btn-danger":!this.userV.isAllow,
                "btn-success":this.userV.isAllow,
                
            },
            sty:null
        }
    },
    methods:{
        showThis(){
            this.$emit('showUp')
        },
    }
}
</script>
