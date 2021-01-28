<template>

         <v-dialog
                v-model="dialog"
                persistent
                scrollable
                max-width="800px"
                >
                <template v-slot:activator="{ on, attrs }">
               <v-btn
                        x-small
                       color="primary"
                        v-bind="attrs"
                        v-on="on" >
                        Detail
                        </v-btn>
                </template>
                <v-card>
                    <v-card-title>
                    <span class="headline">Question details</span>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text style="height: 600px;">
                    <v-container>
                    <v-card>
                    <v-card-title>
                    <span class="headline">{{question.Qst}}</span>
                    </v-card-title>
                    <v-card-text>
                    <b>Type : </b>{{question.type}}
                    </v-card-text>
                    <v-card-text>
                    <v-list-item v-for='(reponse, index)  of question.responses' :key='index'>
                    <v-list-item-content>
                    <v-list-item v-text="reponse.rps"></v-list-item>
                    </v-list-item-content>
                    <v-list-item-action>
                        <v-icon v-if='reponse.vrai' color="success">
                        done
                        </v-icon>
                        <v-icon v-if='!reponse.vrai' color="deep-orange accent-4">
                        clear
                        </v-icon>
                    </v-list-item-action>
                    </v-list-item>
                    </v-card-text>
                    </v-card>
                    </v-container>
                    <v-container v-if='question.QstVote'>
                     <v-card>
                    <v-card-title>
                    <span class="headline">Statistique</span>
                    </v-card-title>
                    <v-card-text>
                   <div v-for='reponse of question.responses'>
                              <div class='rep'>
                                  <h4><b> {{reponse.rps}}</b> : {{reponse.vote}}</h4>
                              <div class="progress">
                              <div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="50"
                             aria-valuemin="0" v-bind:style="{ width: reponse.stat + '%' }" aria-valuemax="100" >
                          <b>{{reponse.stat.toFixed(2)}}%</b>
                         </div>
                       </div>
                     </div>
                   </div>
                    </v-card-text>
                    </v-card>
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
       }
   },
   props: {
       question:Object,

   },
   methods: {
       countStat(){
            this.question.forEach((q)=>{
                q.responses.forEach((e)=>{
                    e.stat = (e.vote*100)/q.QstVote ;
                })
            })
        },
   },
   mounted() {


   },

  }
</script>
