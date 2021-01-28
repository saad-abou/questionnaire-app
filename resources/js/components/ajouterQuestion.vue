<template>

         <v-dialog
                v-model="dialog"
                persistent
                scrollable
                max-width="600px"
                >
                <template v-slot:activator="{ on, attrs }">
                   <v-btn
                        class="ma-2"
                        outlined
                        large
                        fab
                        color="indigo"
                        v-bind="attrs"
                        v-on="on"
                        >
                        <v-icon>create</v-icon>
                        </v-btn>
                </template>
                <v-card>
                    <v-card-title>
                    <span class="headline">Ajouter Question</span>
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
                            item-text="type"
                            item-value="idtype"
                            v-model="select"
                            :hint="`${select.type}, ${select.idtype}`"
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
                            label="Question*"
                            v-model='Qst'
                            :rules="questionRule"
                            required
                            ></v-textarea>
                        </v-col>
                        <v-col cols="12">
                        <v-card v-for="(reponse , index) in reponses" :key="index" width="100%">
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
                            counter="250"
                            :rules="[v => !!v || 'Reponse vide',v => v.length <= 250 || 'Max 250 characters']"
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
                        @click="dialog = false"
                    >
                        Fermer
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        :disabled="!valid"
                        @click="checkForm()"
                    >
                        Ajouter
                    </v-btn>
                    </v-card-actions>
                </v-card>
                </v-dialog>

</template>
<script>
export default {
   data() {
       return {
           select:{  type: '', idtype: ''},
           types: [
                { type: 'Unique', idtype: 'uniq' },
                { type: 'Multiple', idtype: 'multi' },],
           valid: true,
           Qst:'',
           dialog: false,
           errors: [],
           questionRule: [v => !!v || 'Question vide',],
           reponses:[
                {
                    rps:'',
                    vrai:false,
                }
            ]
       }
   },
   methods: {
       ajouterReponse(){
            this.reponses.push({
                index:'',
                rps:'',
                vrai:'',
            })

        },
        reload(){
            this.$root.$emit('questions')
           },
        supReponse(index){
            this.reponses.splice(index,1)

        },
        checkForm(){
            this.$refs.form.validate()
            const find = this.reponses.find(element => !element.rps)
            if (this.Qst && this.reponses.length>1 && this.select.idtype && !find) {
                 this.dialog=false
                 this.saveData()
                 this.reload()
           }
             this.errors = []
            if (find) { this.errors.push('remplis les reponses');}
            if (this.reponses.length<2) { this.errors.push('entrer deux choix');}
            if (!this.select.idtype) { this.errors.push('entrer le type');}



       },
       saveData(){axios.post('addquestions', {'Qst':this.Qst ,'type':this.select.idtype}).then((res)=>{
            axios.post('addreponses', {'reponses':this.reponses}).then((e)=>{
                this.Qst='',
                this.select='',
                this.reponses=[
                {
                    rps:'',
                    vrai:false,
                }
            ]
            })
            })},

   },

  }
</script>
