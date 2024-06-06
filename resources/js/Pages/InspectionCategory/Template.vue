<template>
  <Toaster position="top-right" richColors :visibleToasts="10" />
  <div>
    <v-btn class="text-none text-subtitle-1 me-1 mb-2" color="primary" @click="dialog = true">
      Agregar sección
    </v-btn>
    <p class="text-h6 font-weight-black my-2" v-if="item.template.sections">Secciones</p>
    <SectionCard v-for="(section, index) in item.template.sections" :key="section.id" :section="section"
      :title="section.section_details.ct_inspection_section" />
    <v-dialog v-model="dialog" width="auto">
      <v-card min-width="400" prepend-icon="mdi-plus" title="Nueva sección">
        <v-card-text>
          <v-row dense>
            <v-col cols="12">
              <v-text-field label="Nombre*" variant="outlined" required hide-details
                v-model="sectionForm.name"></v-text-field>
            </v-col>
          </v-row>
        </v-card-text>
        <template v-slot:actions>
          <v-btn class="ms-auto" text="Cancelar" @click="dialog = false"></v-btn>
          <v-btn color="primary" text @click="saveSection()">Guardar</v-btn>
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
      sectionForm: {
        name: ''
      },
      dialog: false
    }
  },
  methods: {
    async saveSection() {
      const toastId = toast.loading('Procesando...'); // Guardar el ID del toast para poder actualizarlo o cerrarlo

      try {
        // Realizar la solicitud POST para guardar la sección
        await this.postSection();

        // Restablecer el formulario y cerrar el diálogo
        this.resetForm();

        // Actualizar las secciones
        await this.updateSections();

        // Mostrar mensaje de éxito
        toast.success('Sección creada correctamente', { id: toastId });
      } catch (error) {
        // Mostrar mensaje de error
        toast.error('Error al crear la sección', { id: toastId });
      }
    },

    async postSection() {
      try {
        await axios.post('api/inspection/sections', {
          ct_inspection_uuid: this.item.ct_inspection_uuid,
          ct_inspection_section: this.sectionForm.name,
        });
      } catch (error) {
        toast.error('Error al crear la sección');
        throw error; // Propagar el error para que sea manejado por saveSection
      }
    },

    async updateSections() {
      try {
        const response = await axios.get(`api/inspection/forms/get-form/${this.item.ct_inspection_uuid}`);
        this.item.template.sections = response.data.data.sections;
      } catch (error) {
        toast.error('Error al cargar las secciones');
        throw error; // Propagar el error para que sea manejado por saveSection
      }
    },

    resetForm() {
      this.dialog = false;
      this.sectionForm.name = '';
    },

  }


}
</script>