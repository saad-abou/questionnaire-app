<template>
   <div v-if="totalPage() > 0" class="pagination-wrapper">
   <span v-if="showPreviousLink()" class="pagination-btn" @click="updatePage(currentPage - 1)">
    <v-btn
      class="mx-2"
      fab
      dark
      small
      color="primary"
    >
      <v-icon dark>
       fast_rewind
      </v-icon>
    </v-btn>
    </span>
  <b> {{ currentPage + 1}} of {{totalPage()}} </b>
   <span v-if="showNextLink()" class="pagination-btn" @click="updatePage(currentPage + 1)">
   <v-btn
      class="mx-2"
      fab
      dark
      small
      color="primary"
    >
      <v-icon dark>
        fast_forward
      </v-icon>
    </v-btn>
    </span>
   </div>
</template>
<script>
export default {
    props: ['questions','currentPage','pageSize'],
    methods: {
        updatePage(pageNumber){
          this.$emit('page:update',pageNumber);
        },
        totalPage(){
            return Math.ceil(this.questions.length/this.pageSize);
        },
        showPreviousLink(){
            return this.currentPage == 0 ? false : true;
        },
        showNextLink(){
             return this.currentPage == (this.totalPage() - 1) ? false : true;
        }



    },
}
</script>
<style lang="css">
.pagination-btn{
    cursor: pointer;
}
</style>
