<template>
    <v-app class="row">
        <vue-confirm-dialog></vue-confirm-dialog>

        <div class="d-flex">
            <ajouterQuestion class="p-2"></ajouterQuestion>
            <v-btn color="yellow" @click="stopShow()" class='mt-auto ml-auto'>
            Arreter la diffusion
            </v-btn>
            <pagination
                class="ml-auto p-2"
                v-bind:questions="questions"
                v-on:page:update="updatePage"
                v-bind:currentPage="currentPage"
                v-bind:pageSize="pageSize"
            ></pagination>
        </div>
       <div >
         <table id="questionTable" class="table table-dark table-sm table-hover">
                        <thead>
                                <tr>
                                        <th scope="col">Situation</th>
                                        <th scope="col" style="width: 50%">Question</th>
                                        <th class='d-lg-none d-xl-table-cell '></th>
                                        <th scope="col" class='d-none d-lg-table-cell d-xl-none'>Type</th>
                                        <th scope="col" class='d-none d-lg-table-cell d-xl-none'>Compte à rebours</th>
                                        <th class='d-none d-lg-table-cell d-xl-none'></th>

                                </tr>
                        </thead>
                        <tbody v-for='question of visibleQuestions' v-bind:visibleQuestions="visibleQuestions" v-bind:currentPage="currentPage">
                                <tr >
                                    <td><span v-if='question.situation' class="text-success">
                                    <v-icon color="success">rss_feed</v-icon>
                                    </span>
                                    <span v-if='!question.situation' class="text-danger">
                                    <v-icon color="yellow lighten-2">rss_feed</v-icon>
                                    </span>
                                    <button type="button" @click="showQuestion(question)" class="btn btn-outline-warning">
                                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-broadcast-pin" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 0 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM6 8a2 2 0 1 1 2.5 1.937V15.5a.5.5 0 0 1-1 0V9.937A2 2 0 0 1 6 8z"/>
                                    </svg>
                                    </button>
                                    </td>
                                    <td>{{question.Qst}}</td>
                                    <td class='d-lg-none d-xl-table-cell '>
                                          <v-menu offset-y
                                          >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                            color="primary"
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                            >
                                            Menu
                                            </v-btn>
                                        </template>
                                        <div style='background-color: #27282b'>
                                        <timer :question="question"></timer>
                                        <modifierQuestion :question="question"></modifierQuestion>
                                        <detail :question="question"></detail>
                                        <button type="button" class="btn btn-outline-danger" @click=" deletQuestion(question.id)">
                                        <v-icon color="black">delete_outline</v-icon>
                                        </button>
                                        </div>
                                        </v-menu>
                                    </td>
                                    <td class='d-none d-lg-table-cell d-xl-none'>{{question.type}} </td>
                                    <td class='d-none d-lg-table-cell d-xl-none'><timer :question="question"></timer></td>
                                    <td class='d-none d-lg-table-cell d-xl-none'>
                                    <div class='actions' >
                                    <modifierQuestion :question="question"></modifierQuestion>
                                    <detail :question="question"></detail>
                                    <button type="button" class="btn btn-outline-danger" @click=" deletQuestion(question.id)">
                                    <v-icon color="black">delete_outline</v-icon>
                                    </button>
                                    </div>
                                    </td>
                                </tr>
                        </tbody>
        </table>
        </div>
  </v-app>
</template>
<script>
import Pagination from './pagination.vue'
import ajouterQuestion from './ajouterQuestion.vue'
import modifierQuestion from './modifierQuestion.vue'
import detail from './detail.vue'
import timer from './timer.vue'


export default {
    data() {
        return {
             delete_id:'',
             Qst:'',
             add:'',
             showDetail:[],
             transitionName: 'fade',
             currentPage: 0,
             pageSize: 5,
             visibleQuestions:{},
            questions:[],
            reponses:[
                {
                    index:'',
                    rps:'',
                    vrai:'',
                }
            ],

        }
    },
    components:{
        Pagination,
        ajouterQuestion,
        modifierQuestion,
        detail,
        timer
    },
    beforeMount() {
        this.updateVisibleQuestions()
    },
    methods: {

        deletQuestion(delete_id){
            if (confirm("Cette question va etre supprimer")){
            axios.post('deleteQuestion',{'id':delete_id}).then((res)=>{
                this.getData()
            })}
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

        stopShow(){
            this.$confirm({
                message: "La diffusion va être arrêté",
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
                        axios.get('stopShow').then((res)=>{
                        axios.get('diffuser').then((e)=>{this.getData()})
                        })
                    }
                }
            })
        },

        getData(){
            axios.get('getquestions').then((res) =>{
                this.questions = res.data.map(i => ({ ...i, isVisible: false }))
                this.questions.sort(function (a, b) {
                    return b.id - a.id;
                    })
                this.countStat()
                this.updateVisibleQuestions()
                })
        },
        countStat(){
            this.questions.forEach((q)=>{
                q.responses.forEach((e)=>{
                    e.stat = (e.vote*100)/q.QstVote ;

                })
            })
        },
        addReponse(id_question){
            axios.post('addReponse',{'id':id_question,'rps':this.add}).then((res)=>{
                this.getData()
                this.add=''
            })
        },
        updatePage(pageNumber){
            this.currentPage = pageNumber;
            this.updateVisibleQuestions();
        },
        updateVisibleQuestions(){
            this.visibleQuestions = this.questions.slice(this.currentPage * this.pageSize,(this.currentPage * this.pageSize) + this.pageSize);

            if(this.visibleQuestions.length == 0 && this.currentPage>0){
                this.updatePage(this.currentPage - 1)
            }
        }


    },
    mounted() {
        this.getData()
         this.$root.$on('questions', () => {
             setTimeout(this.getData(), 300);
            this.getData()
        });

        window.Echo.private('diffuser')
           .listen('DiffuserEvent', (e) => {
               this.getData()
              });

   },


}
</script>
<style>
.actions{
     text-align: right;
}
.btn{
    border-radius :50px;
}
.table{
    box-shadow: 5px 10px 18px #000000;
}



</style>

