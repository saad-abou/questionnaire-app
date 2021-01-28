<template>

  <v-dialog
        ref="dialog"
        v-model="modal2"
        :return-value.sync="question.countdown"
        persistent
        width="290px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="question.countdown"
            label="Picker in dialog"
            prepend-icon="mdi-clock-time-four-outline"
            readonly
            v-bind="attrs"
            v-on="on"
            dark
            color="white"
          ></v-text-field>
        </template>
        <v-time-picker
          v-if="modal2"
          v-model="question.countdown"
          format="24hr"
          use-seconds
          full-width
        >
          <v-spacer></v-spacer>
          <v-btn
            text
            color="primary"
            @click="modal2 = false"
          >
            Fermer
          </v-btn>
          <v-btn
            text
            color="primary"
            @click="$refs.dialog.save(question.countdown);addTime()"
          >
            Ajouter
          </v-btn>
        </v-time-picker>
      </v-dialog>

</template>
<script>
  export default {
    data() {
        return {
            modal2: false,
        }
    },
     props: {
       question:Object,
   },
   methods: {
       addTime(){
           axios.post('addTime', {'id':this.question.id,'time':this.question.countdown })
       }
   },
  }
</script>
