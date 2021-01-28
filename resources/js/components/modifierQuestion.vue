<template>

         <v-dialog
                v-model="dialog"
                persistent
                scrollable
                max-width="600px"
                >
                <template v-slot:activator="{ on, attrs }">
               <v-btn
                        x-small
                       color="primary"
                        v-bind="attrs"
                        v-on="on" >
                        Modifier
                        </v-btn>
                </template>
                <v-card>
                    <v-card-title>
                    <span class="headline">Modifier Question</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text style="height: 600px;">
                    <p v-if="errors.length!=0" class="text-danger">
                                            <b>error(s):</b>
                                            <ul>
                                            <li v-for="error in errors">{{ error }}</li>
                                            </ul>
                    </p>
                    <v-container>
                    <v-form
                            ref="form"
                            v-model="valid"
                            lazy-validation
                        >
                        <v-row>
                        <v-col
                            class="d-flex"
                            cols="12"
                            sm="6"
                        >
                            <v-select
                            :items="types"
                            v-model="questionUpdate.type"
                            :hint="`${questionUpdate.type}`"
                            label="Type"
                            persistent-hint
                            return-object
                            single-line
                            :rules="[v => !!v || 'Entrer le type']"
                            required
                            ></v-select>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea
                            counter="200"
                            label="Question*"
                            v-model='questionUpdate.Qst'
                            :rules="questionRule"
                            required
                            ></v-textarea>
                        </v-col>
                        <v-col cols="12">
                        <v-card v-for="(reponse , index) in questionUpdate.responses" :key="index" width="100%">
                        <v-card-title>
                        <span class="float-right">
                                <v-btn
                                color="error"
                                fab
                                x-small
                                dark
                                @click='supReponse(index)'
                                >
                                <b>X</b>
                                </v-btn></span>
                        </v-card-title>
                        <v-card-text>
                        <v-row>
                        <v-col cols="12"
                                sm="6"
                                md="8"
                                >
                            <v-text-field
                            label="Reponse*"
                            v-model='reponse.rps'
                            counter="50"
                            :rules="[v => !!v || 'Reponse vide',v => v.length <= 50 || 'Max 50 characters']"
                            required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6"
                               md="4">
                        <v-switch
                            v-model="reponse.vrai"
                            ></v-switch>
                        </v-col>
                        </v-row>
                        </v-card-text>
                         <v-divider></v-divider>
                        </v-card>
                        </v-col>
                        <v-col>
                        <v-btn
                            tile
                            color="success"
                            @click='ajouterReponse'
                            >
                            <v-icon >
                                control_point
                            </v-icon>
                        </v-btn>
                        </v-col>
                        </v-row>
                    </v-form>
                    </v-container>
                    <small>*indicates required field</small>
                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="close()"
                    >
                        Fermer
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        :disabled="!valid"
                        @click="checkForm()"
                    >
                        Modifier
                    </v-btn>
                    </v-card-actions>
                </v-card>
                </v-dialog>

</template>
<script>
export default {
   data() {
       return {
           types: [ 'Unique' , 'Multiple' ,],
           valid: true,
           dialog: false,
           errors: [],
           questionRule: [v => !!v || 'Question vide',v => v.length <= 200 || 'Max 200 characters'],
           questionUpdate:[
                {
                    rps:'',
                    vrai:false,
                }
            ]
       }
   },
   props: {
       question:Object,

   },
   methods: {
       ajouterReponse(){
            this.questionUpdate.responses.push({
                rps:'',
                vrai:'',
            })

        },
        reload(){
            this.$root.$emit('questions')
           },
        supReponse(index){
            this.questionUpdate.responses.splice(index,1)

        },
        checkForm(){
            this.$refs.form.validate()
            const find = this.questionUpdate.responses.find(element => !element.rps)
            if (this.questionUpdate.Qst && this.questionUpdate.responses.length>1 && this.questionUpdate.type && !find) {
                 this.dialog=false
                 this.saveData()
           }
             this.errors = []
            if (find) { this.errors.push('remplis les reponses');}
            if (this.questionUpdate.responses.length<2) { this.errors.push('entrer deux choix');}
            if (!this.questionUpdate.type) { this.errors.push('entrer le type');}



       },
       close(){
          this.dialog=false
          this.reload()
       },
       saveData(){axios.post('updateQuestion', {'id':this.questionUpdate.id,'Qst':this.questionUpdate.Qst ,'type':this.questionUpdate.type}).then((res)=>{
            axios.post('updatReponses', {'reponses':this.questionUpdate.responses,'id':this.questionUpdate.id}).then((e)=>{this.reload() })
            })},
        reload(){
            this.$root.$emit('questions')
           },

   },
   mounted() {
       this.questionUpdate =this.question
   },

  }
</script>
