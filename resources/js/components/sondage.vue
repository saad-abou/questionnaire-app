<template>
<v-app>
    <vue-confirm-dialog></vue-confirm-dialog>
    <div class="text-center" v-if=' (user && !visible)'>
        <v-progress-circular :size="50" color="primary" indeterminate ></v-progress-circular>
    </div>
    <div v-if='user && visible'>
        <v-container v-if='!user.admin_key && !user.watchresult' grid-list-xs>
            <div v-if='questions.length==0'>
                <v-card class="attente">
                    <v-card-text>
                    <b>En attente de la question suivante ...</b>
                    </v-card-text>
                </v-card>
            </div>
            <div v-if='questions.length>0'>
                <div v-if='!user.voted'>
                    <v-card v-for='(question , i) of questions' :key="i" class="vote_section">
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
                    <div v-if='question.type=="uniq"'>
                        <v-card-title>
                            <h2><b>{{question.Qst}} :</b></h2>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text >
                            <v-list>
                            <v-list-item-group >
                            <v-list-item v-for='(reponse , index) of question.responses' :key="index" class="reponseText" color="indigo" @click="vote(reponse,question.id)">
                            <v-list-item-content>
                            {{reponse.rps}}
                            </v-list-item-content>
                            </v-list-item>
                            </v-list-item-group>
                            </v-list>
                        </v-card-text>
                        <v-card-actions>
                            <v-col align="right">
                            <v-btn outlined color="yellow darken-4" @click='notVote()'>Ignorer cette Question</v-btn>
                            </v-col>
                        </v-card-actions>
                    </div>
                    <v-container v-if='question.type=="multi"' >
                        <v-card-title>
                            <h2><b>{{question.Qst}} :</b></h2>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text >
                            <div v-for='(reponse , index) of question.responses' :key="index">
                            <label class="form-check-label">
                            <input type="checkbox" class="form-check-input"  v-model="selectedReps" :value="reponse"/>
                            <h4>{{reponse.rps}}</h4>
                            </label>
                            </div>
                        </v-card-text>
                        <v-card-actions>
                            <v-col align="lift">
                            <v-btn rounded color="primary" dark @click='voteSelect(question.id)'>
                            Select
                            </v-btn>
                            </v-col>
                            <v-col align="right">
                            <v-btn outlined color="yellow darken-4" @click='notVote()'>Ignorer cette Question</v-btn>
                            </v-col>
                        </v-card-actions>
                    </v-container>
                    </v-card>
                </div>
                <div v-if='user.voted'>
                    <v-card class='stats_section'>
                    <div  v-for='question of questions'>
                        <h2><b>{{question.Qst}} :</b></h2>
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
                    </div>
                    </v-card>
                </div>
            </div>
        </v-container>
        <div v-if='user.admin_key' grid-list-xs>
            <v-row>
            <v-col align="right">
                <v-btn :loading="loading" :disabled="loading" color="blue-grey" class="ma-2 white--text"
                @click="refresh()" >
                Reprendre
                <v-icon right dark>
                    fas fa-sync
                </v-icon>
                </v-btn>
            </v-col>
            </v-row>
            <v-row>
                <v-col sm="12" md="6">
                    <v-card  class="mx-auto"  max-width="400px" min-width="300px">
                    <v-card-title class="white--text orange darken-4">
                    les Questions
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-list  class="overflow-y-auto" max-height="300">
                    <v-list-item v-for="element in mesQuestions" :key="element.id" class="ml-2">
                    <v-row>
                        <v-col class="col-md-10">
                        <v-icon small :color="getQuestionStatus(element.situation)" @click="showQuestion(element)" class="float-right" >fas fa-broadcast-tower</v-icon>
                            <b style='font-size: 0.75em;'>{{element.Qst}} </b>
                        </v-col>
                    </v-row>
                    </v-list-item>
                    </v-list>
                    </v-card>
                </v-col>
                <v-col sm="12" md="6">
                    <v-card  class="mx-auto"  max-width="400px" min-width="300px">
                    <v-card-title class="white--text deep-purple">
                    les utilisateurs
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-list  class="overflow-y-auto" max-height="300">
                    <v-list-item v-for="user in allUsersStatus" :key="user.id" v-if="!user.admin_key" class="ml-2">
                    <v-row>
                        <v-col class="col-md-10">
                        <v-icon small :color="getUserOnlineStatus(user.id)" class="float-right" >fas fa-globe</v-icon>
                            <b style='font-size: 0.75em;'>{{user.email}} </b>
                        </v-col>
                    </v-row>
                    </v-list-item>
                    </v-list>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col aling="center">
                    <v-card class='stats_section'>
                    <div  v-for='question of questions'>
                        <h2><b>{{question.Qst}} :</b></h2>
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
                    </div>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
            <v-col align="center">
                <v-btn rounded color="primary" @click="afficheResult()" v-if="!user.watchresult"  dark>
                  Afficher les resultats
                </v-btn>
            </v-col>
            </v-row>
        </div>
        <v-container v-if='user.watchresult' grid-list-xs>
            <v-row>
            <v-col>
                 <v-card>
                    <v-tabs color="deep-purple accent-4" min-height="600"  lift >
                    <v-tab v-if="!user.admin_key" class="noprint">Mon bulletin</v-tab>
                    <v-tab class="noprint">Affichage</v-tab>
                    <v-tab-item v-if="!user.admin_key">
                         <v-list two-line>
                            <v-list-item-group  multiple>
                                <template v-for="(answer, index) in userAnswers">
                                <v-list-item :key="answer.id">
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
                                    v-if="index < userAnswers.length - 1"
                                    :key="index"
                                ></v-divider>
                                </template>
                            </v-list-item-group>
                        </v-list>
                        <v-divider></v-divider>
                        <div style="text-align:center">
                         <h3>Vous resultats finale</h3>
                         <v-list>
                             <v-list-item>Nombre de question répondus : <b>{{userAnswers.length}}</b></v-list-item>
                             <v-list-item>Votre score finale : <b>{{userscore}}</b></v-list-item>
                         </v-list>
                        </div>
                    </v-tab-item>
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
                                        <usersBulltin v-if="user.admin_key" :userData="condidat" ></usersBulltin>
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
            <v-row>
                <v-col v-if='user.admin_key' align="center">
                     <v-btn color="green darken-1" class="ma-2 white--text"
                    @click="exportResults()" >
                    Exporter les resultats
                    <v-icon right dark>
                        fas fa-download
                    </v-icon>
                    </v-btn>
                </v-col>
                <v-col align="center" v-if='!user.admin_key' class="noprint">
                    <v-btn color="green darken-1" class="ma-2 white--text"
                    @click="print" >
                    Imprimer
                    </v-btn>
                </v-col>
                <v-col v-if='user.admin_key' align="center">
                     <v-btn color="green darken-1" class="ma-2 white--text"
                    @click="exportQuestions()" >
                    Exporter les questions
                    <v-icon right dark>
                        fas fa-download
                    </v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </div>
</v-app>
</template>
<script>
import usersBulltin from './usersBulltin.vue'

export default {
    data() {
        return {
            starCount:false,
            seconds:'',
            newdef:false,
            fixDate:'',
            user:[],
            questions:[],
            mesQuestions:[],
            stat:[],
            visible:true,
            selectedReps:[],
            timer:'',
            answer:false,
            numberOfCorrectRep:'',
            presenceChannel:'',
            usersInChannel:[],
            allUsers:[],
            allUsersStatus:[],
            userAnswers:[],
            userscore:"",
            loading:false,


        }
    },
    methods: {
        getData(){
            axios.get('getuser').then((res) =>{ this.user = res.data
             if(this.user.watchresult){
                 this.getDataResult()
             }
             if(this.user.admin_key){
                 axios.get('getAllUsers').then((res) =>{ this.allUsersStatus = res.data})
                 axios.get('getquestions').then((res) =>{
                    this.mesQuestions = res.data
                    this.mesQuestions.sort(function (a, b) {
                    return b.id - a.id;
                    })
                })
             }
            axios.get('getQuestionOn').then((res) =>{ this.questions = res.data
            this.questions.forEach((e)=>{
                if(e.time && !this.user.voted ){
                    this.startCount(e.time,this.user)
                }

                if(e.type=="multi"){
                    this.numberOfCorrectRep = e.responses.filter(function(item){ return item.vrai; }).length;
                }
            })
            this.countStat()
            })
            })

            this.selectedReps=[];
            this.answer = false;
            this.numberOfCorrectRep ='';

        },

         initializeChannel() {
          this.presenceChannel = window.Echo.join("presence-channel");
        },

        usersConnect(){
            this.presenceChannel.here((users) => {
                this.usersInChannel = users;
            });

            this.presenceChannel.joining((user) => {
                // check user availability
                const joiningUserIndex = this.usersInChannel.findIndex(
                (data) => data.id === user.id
                );
                if (joiningUserIndex < 0) {
                this.usersInChannel.push(user);
                }
            });

            this.presenceChannel.leaving((user) => {
                const leavingUserIndex = this.usersInChannel.findIndex(
                (data) => data.id === user.id
                );
                this.usersInChannel.splice(leavingUserIndex, 1);
            });
        },

        getDataVote(){
            axios.get('getuser').then((res) =>{ this.user = res.data
            axios.get('getQuestionOn').then((res) =>{ this.questions = res.data
            this.countStat()
            })
            })

            this.selectedReps=[]

        },

        getDataResult(){
            axios.get('getUserAnswers').then((res)=>{
                this.userAnswers = res.data
                this.userscore = this.userAnswers.filter((item)=>{return item.answer}).length;
            })

            axios.get('getAllUsersScore').then((res) =>{ this.allUsers = res.data
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

        vote(reponse,question_id){
            this.visible=false
            if(reponse.vrai){
                this.answer = true
            }
            axios.post('userVote').then((res)=>{
            axios.post('addVoteQuestion').then((res)=>{
                axios.post('addVoteReponse',{'id':reponse.id}).then((res)=>{
                    axios.post('addAnswer',{'answer':this.answer,
                                            'user_id':this.user.id,
                                            'question_id':question_id,
                                            'reponse_id':reponse.id,
                    }).then((res)=>{this.answer = false})
                    axios.get('diffuserVote').then((e)=>{this.getData()})
                })
            })
            })
        },

        voteSelect(question_id){
            this.visible=false

            if(this.selectedReps.length == this.numberOfCorrectRep){
               const resultat = this.selectedReps.find( elem => !elem.vrai)
               if(!resultat){
                   this.answer = true
               }
            }

            axios.post('userVote').then((res)=>{
              axios.post('addMultiVoteQuestion',{'nmb':this.selectedReps.length}).then((res)=>{
               axios.post('addMultivotes',{'select':this.selectedReps}).then((res)=>{
                   axios.post('addSelectAnswer',{'answer':this.answer,
                                        'user_id':this.user.id,
                                        'question_id':question_id,
                                        'reponses':this.selectedReps,
                   }).then((res)=>{this.answer == false})
                 axios.get('diffuserVote').then((e)=>{this.getData()})
               })
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


        notVote(){
            this.visible=false
         axios.post('userVote').then((e)=>{
             this.getData()
         })

        },

        startCount(time,user){
            var countDownDate = new Date(time).getTime();
            var self = this

            // Update the count down every 1 second
            this.timer = setInterval(function() {

            // Get today's date and time
            const now = new Date().getTime();

            // Find the distance between now and the count down date
            const distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"

            self.starCount = true
            self.seconds=seconds

            /*document.getElementById("demo").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";*/

            // If the count down is over, write some text
            if (distance < 1) {
                clearInterval(self.timer);
                self.starCount = false
                if(!user.voted){
                 self.notVote()
                }
            }
            }, 1000);

        },

        afficheResult(){
            axios.get('showResult').then((res)=>{
                       axios.get('diffuserResult')
            })
        },

        getUserOnlineStatus(id) {
            const onlineUserIndex = this.usersInChannel.findIndex(
                (data) => data.id === id
            );
            if (onlineUserIndex < 0) {
                return "red";
            }
            return "green";
        },
        getQuestionStatus(situation){
            if(!situation){
                return "yellow";
            }
            return "green";
        },

        checkReponse(answers,id){
            const onlineUserIndex = answers.findIndex(
                (data) => data.id === id
            );
            if (onlineUserIndex < 0) {
                return false;
            }
            return true;
        },

        refresh(){
            if(confirm("Tous les anciens statistique de cette question vont etre supprimer"))
            {
                this.loading=true
                axios.get('refreshUsers').then((res)=>{
                    axios.get('refreshQuestions').then((res)=>{
                        axios.get('diffuser').then((res)=>{
                            this.getData()
                        })
                        axios.get('refreshReponses').then((res)=>{
                            this.loading=false
                            axios.get('refreshAnswers').then((res)=>{

                            })
                        })
                    })
                })

            }
        },

        exportResults(){
            window.location.href = 'exportUsers'
        },
        exportQuestions(){
            window.location.href = 'export'
        },
        print(){
            window.print()
        },

        addNowTime(question){
            const now = new Date().getTime();
            const ms = Number(question.countdown.split(':')[0]) * 60 * 60 * 1000 + Number(question.countdown.split(':')[1]) * 60 * 1000+ Number(question.countdown.split(':')[2]) * 1000;
            const questionTime = ms + now + 10000;
            const questionCounter = new Date(questionTime);
            axios.post('setDate',{'questionCounter':questionCounter.toString(),'id':question.id})
        },

        showQuestion(question){
            if(question.countdown && question.countdown!="00:00:00" ){
                if(question.QstVote){
                    this.$confirm({
                        message: "Cette question est deja voté tu vas la rediffuser avec un compte à rebours de "+question.countdown+" Tous les anciens statistique de cette question vont etre supprimer êtes-vous sûr ",
                        button: {
                            no: 'Non',
                            yes: 'Oui'
                        },
                        /**
                        * Callback Function
                        * @param {Boolean} confirm
                        */
                        callback: confirm => {
                            if (confirm) {
                            this.addNowTime(question)
                            axios.post('updateSituation',{'id':question.id}).then((res)=>{
                            axios.post('updateReponses',{'id':question.id}).then((res)=>{
                                axios.get('updateUsersVote').then((res)=>{
                                    axios.get('diffuser').then((e)=>{this.getData()})
                                })
                            })
                            })
                            }
                        }
                    })
                }

                if(!question.QstVote){
                    this.$confirm({
                        message: "vous êtes en train de diffuser une nouvelle question avec un compte à rebours de "+ question.countdown
                        +" êtes-vous sûr ",
                        button: {
                            no: 'Non',
                            yes: 'Oui'
                        },
                        /**
                        * Callback Function
                        * @param {Boolean} confirm
                        */
                        callback: confirm => {
                            if (confirm) {
                                this.addNowTime(question)
                                axios.post('updateSituation',{'id':question.id}).then((res)=>{
                                axios.post('updateReponses',{'id':question.id}).then((res)=>{
                                    axios.get('updateUsersVote').then((res)=>{
                                        axios.get('diffuser').then((e)=>{this.getData()})
                                    })
                                })
                                })
                            }
                        }
                    })
                }
            }

            else{
                if(question.QstVote){
                    this.$confirm({
                        message: `Cette question est deja voté tu vas la rediffuser\n
                        Tous les anciens statistique de cette question vont etre supprimer\n
                        êtes-vous sûr`,
                        button: {
                            no: 'Non',
                            yes: 'Oui'
                        },
                        /**
                        * Callback Function
                        * @param {Boolean} confirm
                        */
                        callback: confirm => {
                            if (confirm) {
                                axios.post('setDate',{'questionCounter':null,'id':question.id})
                                axios.post('updateSituation',{'id':question.id}).then((res)=>{
                                axios.post('updateReponses',{'id':question.id}).then((res)=>{
                                    axios.get('updateUsersVote').then((res)=>{
                                        axios.get('diffuser').then((e)=>{this.getData()})
                                    })
                                })
                                })
                            }
                        }
                    })
                }

                if(!question.QstVote){
                    this.$confirm({
                        message: `Vous êtes en train de diffuser une nouvelle question\n
                        êtes-vous sûr`,
                        button: {
                            no: 'Non',
                            yes: 'Oui'
                        },
                        /**
                        * Callback Function
                        * @param {Boolean} confirm
                        */
                        callback: confirm => {
                            if (confirm) {
                                axios.post('setDate',{'questionCounter':null,'id':question.id})
                                axios.post('updateSituation',{'id':question.id}).then((res)=>{
                                axios.post('updateReponses',{'id':question.id}).then((res)=>{
                                    axios.get('updateUsersVote').then((res)=>{
                                        axios.get('diffuser').then((e)=>{this.getData()})
                                    })
                                })
                                })
                            }
                        }
                    })
                }
            }
        },
    },
    components:{
        usersBulltin,
    },

    mounted() {
        this.initializeChannel();
        this.getData();
        this.usersConnect();

        clearInterval(this.timer);
        window.Echo.channel('diffuser')
           .listen('DiffuserEvent', (e) => {
               this.questions=[]
               this.getData()
               clearInterval(this.timer);
              });

        window.Echo.channel('diffuserVote')
         .listen('DiffuserVoteEvent', (e) => {
              if(this.user.voted) {this.getDataVote();
              if(this.user.admin_key){
                   axios.get('getquestions').then((res) =>{
                    this.mesQuestions = res.data
                    this.mesQuestions.sort(function (a, b) {
                    return b.id - a.id;
                    })
                })
              }}
             });

        window.Echo.channel('diffuserResult')
         .listen('DiffuserResult', (e) => {
               this.getData()
         });
    },
}
</script>

<style lang="css">

.vote_section {
  width: 50%;
  margin: auto;
  border-radius: 5px;
  padding-top: 50px;
  padding-right: 50px;
  padding-bottom: 50px;
  padding-left: 50px;
  box-shadow: 5px 10px 18px #000000;
  font-size:2em;
}
.question{
  position: relative;
  font-family: "Times New Roman";
  text-shadow: 5px 10px 18px #000000;
}
@media screen and (max-width: 1280px){
 .vote_section {
  width: 100%;

}
.stats_section {
  width: 100%;

}
}

.reponses{
    display: flex;
    justify-content: space-around;
    margin-top:50px;
}

.stats_section{
  margin: auto;
  border-radius: 5px;
  padding-top: 50px;
  padding-right: 50px;
  padding-bottom: 50px;
  padding-left: 50px;
  font-family: "Times New Roman";
}

@media screen and (max-width: 1280px){
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
.rep{
    margin-top:20px
}
.v-progress-circular {
  margin: 1rem;
}

.reponseText{
  border: 2px solid;
  padding: 10px;
  border-radius: 15px;
  margin-bottom:3px
}
@media print {
   .noprint {
      visibility: hidden;
   }
}
</style>
