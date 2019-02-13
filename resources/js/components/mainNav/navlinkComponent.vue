<template>
  <li><a @click="showUp" :class="classs" @blur="lose">{{links+plus}}</a></li>
</template>

<script>
export default {
    props:["links","plus","last"],
    data(){
      return{
          classs:"",

      }
    },
    methods:{
      showUp(){
        this.$emit('pag',((this.links+this.plus)-1)*10);
        this.classs="active"
      },
      lose(){
        this.classs="";
      }
    }
}
</script>

