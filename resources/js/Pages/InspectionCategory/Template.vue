<template>
  <Toaster position="top-right" richColors :visibleToasts="10" />
  <div>
    <v-btn class="text-none text-subtitle-1 me-1 mb-2" color="primary" @click="dialog = true">
      Agregar sección
    </v-btn>
    <p class="text-h6 font-weight-black my-2" v-if="item.template.sections">Secciones</p>
    <SectionCard v-for="(section, index) in item.template.sections" :key="section.id" :section="section"
      :title="index.replaceAll('_', ' ').toUpperCase()" />
    <v-dialog v-model="dialog" width="auto">
      <v-card min-width="400" prepend-icon="mdi-plus" title="Nueva sección">
        <v-card-text>
          <v-row dense>
            <v-col cols="12">
              <v-text-field label="Nombre*" variant="outlined" required hide-details v-model="sectionForm.name"></v-text-field>
            </v-col>
          </v-row>
        </v-card-text>
        <template v-slot:actions>
          <v-btn class="ms-auto" text="Cancelar" @click="dialog = false"></v-btn>
          <v-btn color="primary" text @click="save()">Guardar</v-btn>
        </template>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import SectionCard from './Partials/SectionCard.vue';
import { Toaster, toast } from 'vue-sonner'

export default {
  components: {
    SectionCard,
    Toaster
  },
  props: {
    item: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      dialog: false,
      types: [
        { id: 'campo', name: 'Campo' },
        { id: 'section', name: 'Sección' },
      ],
      sectionForm: {
        name: ''
      },
    }
  },
  methods: {
    save() {
      // Guardamos la sección con axios
      const postRequest = () => {
        return axios.post('api/inspection/forms/set-form', {

          ct_inspection_code: this.item.ct_inspection_code,
          sections: [{
            ct_inspection_section: this.sectionForm.name,
            sub_sections: [],
            fields: []
          }],
        });
      };

      toast.promise(postRequest(), {
        loading: 'Procesando...',
        success: (response) => {
          this.dialog = false;
          console.log(response.data.data);
          this.item.template.sections = response.data.data.sections;
          this.sectionForm.name = '';
          return 'Sección creada correctamente';
        },
        error: (data) => {
          this.handleErrors(data);
        }
      });
      //this.dialog = false;
    }
  }
}
</script>