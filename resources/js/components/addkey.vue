<template>
    <div>
        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  une cle
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Admine key</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p v-if="errors.length!=0" class="text-danger">
                                    <b>error(s):</b>
                                    <ul>
                                    <li v-for="error in errors">{{ error }}</li>
                                    </ul>
                                </p>
        <input id="addKey" v-model='addKey' type="text" name="addKey" class="form-control" placeholder="Key">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" @click="checkKey()" class="btn btn-primary">Enregistrer</button>
      </div>
    </div>
  </div>
</div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            addKey:'',
            ab:'',
            addAdmin:false,
            errors: [],


        }
    },
    methods: {
        checkKey(){
            this.errors = []
            if (!this.addKey) {
            this.errors.push('entrer un clé');
            this.addAdmine=false}
            if (this.addKey!='azer' && this.addKey) {
            this.errors.push('clé incorrecte');
            this.addAdmine=false}
            if (this.addKey=='azer'){
                this.addAdmine=true;
                 $('#button').submit(function(e) {e.preventDefault();
                 $('#IDModal').modal('toggle'); return false;});
            }

       },
    },
}
</script>
