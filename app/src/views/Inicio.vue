<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="12">
        <v-row
          :align="alignment"
          :justify="justify"
          class="grey lighten-5"
          style="height: 800px"
        >
          <v-col cols="12" lg="3" md="6" xs="8">
            <v-card class="ma-0 pa-5" style="height: 600px" color="#eeeeee">
              <v-form ref="form">
                <v-img src="" aspect-ratio="1.4" contain> </v-img>
                <v-text-field
                  :rules="[rules.required]"
                  label="Username"
                  name="Username"
                  v-model="username"
                  required
                  outlined
                  dense
                  hint="Para iniciar debe ingresar un usuario valido"
                  persistent-hint
                ></v-text-field>

                <v-btn color="success" class="mr-4" @click="getUser">
                  Ingresar
                </v-btn>
              </v-form>
              <v-alert
                border="right"
                colored-border
                type="error"
                elevation="10"
                transition="scale-transition"
                :value="alert"
                class="ma-2"
              >
                {{ advertencia }}
              </v-alert>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
    <router-view name="ruta"> </router-view>
    <v-snackbar
      v-model="snackbar"
    >
      {{ textSB }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="red"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-container>
</template>


<script>
import axios from "axios";
import {mapState} from 'vuex'

export default {
  data() {
    return {
      alert: false,
      snackbar: false,
      textSB: '',
      advertencia: "",
      username: "",
      Password: "",
      lista: [],
      alignmentsAvailable: ["start", "center", "end", "baseline", "stretch"],
      alignment: "center",
      dense: false,
      justifyAvailable: [
        "start",
        "center",
        "end",
        "space-around",
        "space-between",
      ],
      justify: "center",
      show1: false,
      password: "Password",
      rules: {
        required: (value) => !!value || "Required.",
      },
    };
  },
  computed: {
    ...mapState(["persona", "experiencia"]),
  },
  methods: {
    
    getUser() {
     var obj = {
          path: 'USER',
          username: this.username};
        console.log(obj);
        axios({
        url: this.$store.state.conexion,
        method: 'GET',
        responseType: 'json',
        params: obj,
      }).then((respuesta) => {
            console.log(respuesta.data);
            if(respuesta.data && respuesta.data!== null){
                this.$router.push({name: 'Home'});
                this.$store.state.persona = respuesta.data.person;
                this.$store.state.experiencia = respuesta.data.experiences;

                console.log(this.$store.state.experiencia);
            }else{
                this.snackbar= true;
                this.textSB= 'usuario no existe';
            }

            
          });

      
      
    },
   
  },
};
</script>

<style>
</style>

