<template>
  <v-card class="ma-5">
    <v-card-title> Bienvenido: {{ usuario }} 
      <v-spacer></v-spacer>
      <v-menu
      transition="slide-y-transition"
      bottom
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          class="purple"
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          Menú
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          @click="opciones(item.cod)"
        >
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>

    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="12" md="3" xs="12">
          <v-img width="200px" :src="$store.state.persona.picture"></v-img>
        </v-col>
        <v-col cols="12" md="9" xs="12">
          <v-row>
            <v-col cols="12">
              <v-text-field
                label="Profesión"
                v-model="$store.state.persona.professionalHeadline"
                outlined
                dense
                readonly
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Ubicación"
                v-model="$store.state.persona.location.name"
                outlined
                dense
                readonly
              ></v-text-field>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12">
          <v-card>
            <v-card-title>Experiencia Laboral
              <v-spacer></v-spacer>
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Buscar"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
            <v-data-table
              :headers="headers"
              :items="desserts"
              :search="search"
            ></v-data-table>
          </v-card>
        </v-col>
        <v-col cols="12">
          <v-card>
            <v-card-title>Estudios academico
              <v-spacer></v-spacer>
              <v-text-field
                v-model="searchEd"
                append-icon="mdi-magnify"
                label="Buscar"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
            <v-data-table
              :headers="headers"
              :items="dessertsEd"
              :search="searchEd"
            ></v-data-table>
          </v-card>
        </v-col>
        <v-col cols="12">
          <v-card>
            <v-card-title>Proyectos
              <v-spacer></v-spacer>
              <v-text-field
                v-model="searchPr"
                append-icon="mdi-magnify"
                label="Buscar"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
            <v-data-table
              :headers="headers"
              :items="dessertsPr"
              :search="searchPr"
            ></v-data-table>
          </v-card>
        </v-col>
        
      </v-row>
      <v-dialog v-model="dialogTrabajo" width="800px" persistent> 
        <v-card >
          <v-card-title class="primary white--text">Buscar trabajo por ID</v-card-title>
          <v-card class="ma-5" flat>
            <v-row>
              <v-col cols="12" md="8" xs="12">
                <v-text-field
                  label="idTrabajo"
                  v-model="idTrabajo"
                  required
                  outlined
                  dense
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4" xs="12">
                <v-btn @click="getTrabajo">
              Buscar
            </v-btn>
              </v-col>
            </v-row>
                
          </v-card>
          <v-card v-if="resultado" class="ma-5">
            <v-card-title>Resultado</v-card-title>
            <v-card flat class="ma-2">
              <v-row>
                <v-col cols="12" md="3" xs="12">
                  <v-img width="200px" :src="organizacion.picture"></v-img>
                </v-col>
                <v-col cols="12" md="9" xs="12">
                  <v-row>
                    <v-col cols="12">
                      <v-text-field
                      label="Empresa"
                      v-model="organizacion.name"
                      outlined
                      dense
                      readonly
                      hide-details
                    ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field
                      label="Cargo"
                      v-model="Cargo"
                      outlined
                      dense
                      readonly
                      hide-details
                    ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <span>Beneficios</span>

                      <v-chip-group
                        active-class="primary--text"
                        column
                      >
                        <v-chip
                          v-for="tag in beneficios"
                          :key="tag.content"
                        >
                          {{ tag.content }}
                        </v-chip>
                      </v-chip-group>
                    </v-col>
                    <v-col cols="12">
                      <span>Responsabilidades</span>

                      <v-chip-group
                        active-class="primary--text"
                        column
                      >
                        <v-chip
                          v-for="tag in responsabilidades"
                          :key="tag.content"
                        >
                          {{ tag.content }}
                        </v-chip>
                      </v-chip-group>
                    </v-col>
                    <v-col cols="12">
                      <span>Requerimientos</span>

                      <v-chip-group
                        active-class="primary--text"
                        column
                      >
                        <v-chip
                          v-for="tag in requerimientos"
                          :key="tag.content"
                        >
                          {{ tag.content }}
                        </v-chip>
                      </v-chip-group>
                    </v-col>

                  </v-row>
                  
                </v-col>
              </v-row>
            </v-card>
          </v-card>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="dialogTrabajo=false">
              Salir
            </v-btn>

          </v-card-actions>
        </v-card>
      </v-dialog>


      <v-dialog v-model="dialogoportunidades" width="800px" persistent> 
        <v-card >
          <v-card-title class="primary white--text">Buscar Oportunidades</v-card-title>
          <v-card class="ma-5" flat>
            <v-row>
              <v-col cols="12" md="3" xs="12">
                <v-text-field
                  label="Offset"
                  v-model="Offset"
                  required
                  outlined
                  dense
                  hide-details
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" xs="12">
                <v-text-field
                  label="Size"
                  v-model="Size"
                  required
                  outlined
                  dense
                  hide-details
                ></v-text-field>
                </v-col>
              <v-col cols="12" md="3" xs="12">
                <v-text-field
                  label="Agregate"
                  v-model="aggregate"
                  required
                  outlined
                  dense
                  hide-details
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" xs="12">
                <v-btn @click="getOportunidades">
              Buscar
            </v-btn>
              </v-col>
            </v-row>
                
          </v-card>
          <v-card v-if="resultadoOp" class="ma-5">
            
            <v-card-title>Resultado
              <v-spacer></v-spacer>
              <v-text-field
                v-model="searchOp"
                append-icon="mdi-magnify"
                label="Buscar"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
            <v-data-table
              :headers="headersOp"
              :items="dessertsOp"
              :search="searchOp"
            ></v-data-table>
          </v-card>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="dialogoportunidades=false">
              Salir
            </v-btn>

          </v-card-actions>
        </v-card>
      </v-dialog>
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
    </v-card-text>
  </v-card>
</template>

<script>
import axios from "axios";
import { mapState } from "vuex";

export default {
  data: () => ({
    Offset:'',
    Size:'',
    aggregate:'',
    dialogoportunidades: false,
    resultadoOp: false,
    Cargo: '',
     snackbar: false,
      textSB: '',
    resultado: false,
    idTrabajo: null,
    usuario: null,
    dialogTrabajo: false,
    organizacion: [] ,
    beneficios: [],
    responsabilidades: [],
    requerimientos: [],
    exp: "",
    search: '',
    searchEd: '',
    searchPr: '',
    searchOp: '',
    items: [
        { title: 'Buscar trabajo por id', cod: 1 },
        { title: 'Buscar oportunidades', cod: 2 },
      ],
        headers: [
          {
            text: 'Nombre',
            align: 'start',
            value: 'name',
          },
          { text: 'Mes inicio', value: 'fromMonth' },
          { text: 'Año inicio', value: 'fromYear' }
        ],
        headersOp: [
          {
            text: 'Empleo',
            align: 'start',
            value: 'objective',
          },
          { text: 'Id', value: 'id' },
        ],
        desserts: [],
        dessertsOp: [],
        dessertsEd: [],
        dessertsPr: [],
  }),
  name: "Home",
  components: {},
  computed: {
    ...mapState(["persona", "experiencia"]),
  },
  methods: {
    getTrabajo(){
      this.reset();
      var obj = {
        path: 'JOB',
        job: this.idTrabajo};
        console.log(obj);
        axios({
        url: this.$store.state.conexion,
        method: 'GET',
        responseType: 'json',
        params: obj,
      }).then((respuesta) => {
            
            if(respuesta.data && respuesta.data!== null){
                this.resultado = true;
                this.organizacion = respuesta.data.organizations[0];
                this.Cargo = respuesta.data.objective;
                //this.beneficios = respuesta.data.details;
                for(let i = 0; i < respuesta.data.details.length; i++ ){
                switch (respuesta.data.details[i].code){
                  case 'benefits':
                    this.beneficios.push(respuesta.data.details[i]);
                    break;
                  case 'responsibilities':
                    this.responsabilidades.push(respuesta.data.details[i]);
                    break;
                  case 'requirements':
                    this.requerimientos.push(respuesta.data.details[i]);
                    break;
                  default:
                }
                console.log(this.beneficios);
                }
            }else{
                this.reset();
                this.snackbar= true;
                this.textSB= 'No hay coincidencias';
            }

            
          });
    },
    reset(){
      this.organizacion = [];
      this.beneficios = [];
      this.responsabilidades = [];
      this.requerimientos = [];
      this.dessertsOp=[];
      this.resultado = false;
      this.resultadoOp = false;
    },
    getOportunidades(){
      this.reset();
      var obj = {
        path: 'JOBS',
        offset:this.Offset, 
        size:this.Size, 
        aggregate:this.aggregate};

        console.log(obj);
        axios({
        url: this.$store.state.conexion,
        method: 'POST',
        responseType: 'json',
        data: obj,
      }).then((respuesta) => {
            
            this.resultadoOp = true;
            
             if(respuesta.data && respuesta.data!== null){
                 for(let i = 0; i < respuesta.data.results.length; i++ ){
                   console.log(respuesta.data.results[i].organizations);
                   this.dessertsOp.push(respuesta.data.results[i]);
                 }
            }else{
                this.reset();
                this.snackbar= true;
                this.textSB= 'No hay coincidencias';
            }

            
          });
    },
    opciones(cod){
     console.log(cod)
     switch (cod){
        case 1:
            this.reset();
            this.dialogTrabajo=true;
          break;
        case 2:
          this.dialogoportunidades = true;
          break;
        default:
      }
    },
    cargainicial(){
      this.usuario = this.$store.state.persona.name;
    for(let i = 0; i < this.$store.state.experiencia.length; i++ ){
      switch (this.$store.state.experiencia[i].category){
        case 'jobs':
          this.desserts.push(this.$store.state.experiencia[i]);
          break;
        case 'education':
          this.dessertsEd.push(this.$store.state.experiencia[i]);
          break;
         case 'projects':
           this.dessertsPr.push(this.$store.state.experiencia[i]);
           break;
        default:
      }
 
    }
    }

  },
  created() {
    this.cargainicial();
  },
};
</script>
