<template>
    <v-dialog v-model="dialog" persistent scrollable max-width="800px" >
        <template v-slot:activator="{ on, attrs }">
            <v-icon small color="primary" v-bind="attrs" v-on="on" @click="getUserBulltin()">
            fas fa-list
            </v-icon>
        </template>
    <v-card>
        <v-card-title>
            <span class="headline">{{userData.name}} bulltin</span>
        </v-card-title>
    <v-divider></v-divider>
        <v-card-text style="height: 600px;">
        <v-container>
        <v-list two-line>
            <v-list-item-group  multiple>
                <template v-for="(answer, index) in user_Answers">
                <v-list-item >
                    <template>
                    <v-list-item-content>
                        <v-list-item-title><b>{{answer.question.Qst}}</b></v-list-item-title>

                        <v-list-item-subtitle class="text-success" v-if="answer.answer">Correct</v-list-item-subtitle>
                            <v-list-item-subtitle class="text-danger" v-else>Faux</v-list-item-subtitle>

                        <v-list-item-subtitle v-bind:class="{ active: reponse.vrai, 'text-success': reponse.vrai}" v-for="(reponse, index) in answer.question.responses" :key="reponse.id">
                        {{reponse.rps}}
                        <v-icon v-if="checkReponse(answer.reponses,reponse.id)">fas fa-check</v-icon>
                        </v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-action>
                        <v-list-item-action-text v-if="answer.answer" class="red--success">
                        <v-icon color="success">fas fa-plus</v-icon>
                        </v-list-item-action-text>
                    </v-list-item-action>
                    </template>
                </v-list-item>

                <v-divider
                    v-if="index < user_Answers.length - 1"
                    :key="index"
                ></v-divider>
                </template>
            </v-list-item-group>
        </v-list>
        <v-divider></v-divider>
                        <div style="text-align:center">
                         <h3>Vous resultats finale</h3>
                         <v-list>
                             <v-list-item>Nombre de question répondus : <b>{{user_Answers.length}}</b></v-list-item>
                             <v-list-item>Votre score finale : <b>{{user_score}}</b></v-list-item>
                         </v-list>
                        </div>
        </v-container>
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
    </v-card-actions>
    </v-card>
    </v-dialog>
</template>
<script>
export default {
   data() {
       return {
           dialog: false,
           user_Answers:[],
           user_score:'',
       }
   },
   props: {
       userData:Object,
   },
   methods: {

       checkReponse(answers,id){
            const onlineUserIndex = answers.findIndex(
                (data) => data.id === id
            );
            if (onlineUserIndex < 0) {
                return false;
            }
            return true;
        },

       getUserBulltin(){
            axios.post('getUsersAnswers',{'id':this.userData.id}).then((res)=>{
                this.user_Answers = res.data
                this.user_score = this.user_Answers.filter((item)=>{return item.answer}).length;
            })
       }
   },
   mounted() {
   },

  }
</script>
