<template>
    <v-app>
        <v-toolbar max-height="60">
            <v-img  src="unnamed.png" max-width="50" ></v-img>
            <v-toolbar-title><b>ASCREA</b><br><span class="title">SONDAGES</span></v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn text color="primary" href="/sondage" target="_blank">
                Commancer
            <v-icon right dark>
                fas fa-arrow-right
            </v-icon>
            </v-btn>
        </v-toolbar>
        <v-row >
            <v-col align="center">
                <h1> Bienvenue aux sondages ascrea </h1>
            </v-col>
        </v-row>
        <v-container grid-list-xs>
        <v-row v-if="!user.watchresult">
            <v-col align="center">
                <v-card class="attente" v-if='questions.length==0'>
                    <v-card-text>
                    <b>En attente de la question suivante ...</b>
                    </v-card-text>
                </v-card>
                <v-card v-if='questions.length>=0' v-for='(question , i) of questions' :key="i">
                <v-progress-circular
                    id="demo"
                    v-if='question.time && starCount'
                    :rotate="360"
                    :size="100"
                    :width="15"
                    :value="seconds*1.6666666666666"
                    color="teal"
                    >
                    {{ seconds }}
                </v-progress-circular>
                <p id="demo" v-if='question.time && !starCount'><b>le temps est écoulé</b></p>
                        <v-card-title>
                            <h2><b>{{question.Qst}} :</b></h2>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text >
                            <div v-for='reponse of question.responses'>
                            <div class='rep'>
                                <h4><b> {{reponse.rps}}</b> : {{reponse.stat.toFixed(2)}}%</h4>
                                <div class="progress">
                                    <div v-if="reponse.vrai" class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" v-bind:style="{ width: reponse.stat + '%' }" aria-valuemax="100" >
                                    </div>
                                    <div v-if="!reponse.vrai" class="progress-bar progress-bar-striped bg-danger" role="progressbar" aria-valuenow="50"
                                    aria-valuemin="0" v-bind:style="{ width: reponse.stat + '%' }" aria-valuemax="100" >
                                    </div>
                                </div>
                            </div>
                            </div>
                        </v-card-text>
                </v-card>
                </v-col>
        </v-row>
        <v-row v-if="user.watchresult">
            <v-col>
                 <v-card>
                    <v-tabs color="deep-purple accent-4" min-height="600"  lift >
                    <v-tab>Affichage</v-tab>
                    <v-tab-item>
                      <h2>L'affichage</h2>
                      <v-divider></v-divider>
                        <v-list two-line>
                            <v-list-item-group  multiple>
                                <template v-for="(condidat, index) in allUsers" >
                                <v-list-item>
                                    <template>
                                    <v-list-item-content>
                                        <v-list-item-title><b>{{condidat.name}}</b></v-list-item-title>
                                        <v-list-item-subtitle>
                                         Score finale
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                    <v-list-item-action>
                                        <v-list-item-action-text>
                                        <h3 class="mr-2">{{condidat.score}}</h3>
                                        </v-list-item-action-text>
                                    </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-divider
                                    v-if="index < allUsers.length - 1"
                                    :key="index"
                                ></v-divider>
                                </template>
                            </v-list-item-group>
                        </v-list>
                    </v-tab-item>
                    </v-tabs>
                </v-card>
            </v-col>
        </v-row>
        </v-container>
    </v-app>
</template>
<script>
export default {
    data() {
        return {
            starCount:false,
            seconds:'',
            user:[],
            questions:[],
            allUsers:[],
            timer:'',

        }
    },

    methods: {
       getData(){
            axios.get('getPublicUser').then((res) =>{ this.user = res.data
                if(!this.user.watchresult)
                {axios.get('getQuestionPublic').then((res) =>{ this.questions = res.data
                this.questions.forEach((e)=>{
                    if(e.time){
                        this.startCount(e.time)
                    }
                })
                this.countStat()
                })}
                if(this.user.watchresult){
                    this.getDataResult()
                }

            })


        },

         getDataResult(){
            axios.get('getAllUsersPublicScore').then((res) =>{ this.allUsers = res.data
               this.allUsers.forEach((q)=>{
                  q.score = q.user_answers.filter(function(item){ return item.answer; }).length;
               })
               this.allUsers.sort(function (a, b) {
                   if(b.score == a.score){
                    a.Timer = 0
                    b.Timer = 0
                   a.user_answers.forEach((elm)=>{
                       var date = new Date(elm.created_at).getTime()
                       a.Timer = a.Timer + date
                   })
                   b.user_answers.forEach((elm)=>{
                       var date = new Date(elm.created_at).getTime()
                       b.Timer = b.Timer + date
                   })
                     return a.Timer - b.Timer;
                   }
                  else { return b.score - a.score;}
               })
                   

             })
        },

        countStat(){
            this.questions.forEach((q)=>{
                this.visible=true
                q.responses.forEach((e)=>{
                    e.stat = (e.vote*100)/q.QstVote ;
                })
            })
        },



        startCount(time){
            var countDownDate = new Date(time).getTime();
            var self = this

            // Update the count down every 1 second
            this.timer = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            self.starCount = true
            self.seconds=seconds

           /* document.getElementById("demo").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";*/

            // If the count down is over, write some text
            if (distance < 1) {
                clearInterval(this.timer);
                self.starCount = false;
            }
            }, 1000);

        },


    },

    mounted() {
        this.getData()

        clearInterval(this.timer);

         window.Echo.channel('diffuserVote')
         .listen('DiffuserVoteEvent', (e) => {
              this.getData()
              clearInterval(this.timer);
            });

        window.Echo.channel('diffuser')
           .listen('DiffuserEvent', (e) => {
               this.getData()
               clearInterval(this.timer);
              });

        window.Echo.channel('diffuserResult')
         .listen('DiffuserResult', (e) => {
               this.getData()
         });
    },

}
</script>
<style>
.title{
     font-family: 'Imbue', serif;
     color:green
 }
 h1{
     font-family: 'Imbue', serif;
 }


.attente{
  width: 50%;
  margin: auto;
  border-radius: 5px;
  padding-top: 50px;
  padding-right: 50px;
  padding-bottom: 50px;
  padding-left: 50px;
  font-style: italic;
}
@media screen and (max-width: 1280px){
.attente {
  width: 100%;
}
}

#demo{
    font-size:2em;
}
</style>
