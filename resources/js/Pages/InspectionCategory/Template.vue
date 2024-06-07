<template>
  <Toaster position="top-right" richColors :visibleToasts="10" />
  <div>
    <v-btn class="text-none text-subtitle-1 me-1 mb-2" color="primary" @click="dialog = true">
      Agregar sección
    </v-btn>
    <p class="text-h6 font-weight-black my-2" v-if="item.template.sections">Secciones</p>
    <SectionCard v-for="(section, index) in item.template.sections" :key="section.id" :section="section"
      :title="section.section_details.ct_inspection_section" :item="item" @save-section="saveSection" @update-sections="handleUpdateSections" />
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
          <v-btn color="primary" text @click="saveSection(item.ct_inspection_uuid, sectionForm.name)">Guardar</v-btn>
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
    async saveSection(ct_inspection_uuid, name, ct_inspection_relation_uuid = null) {
      try {
        // Realizar la solicitud POST para guardar la sección
        await this.postSection(ct_inspection_uuid, name, ct_inspection_relation_uuid);

        // Restablecer el formulario y cerrar el diálogo
        this.resetForm();

        // Actualizar las secciones
        await this.updateSections();
        toast.success('Sección guardada correctamente');
      } catch (error) {
        // Manejar el error de postSection o updateSections
        this.handleErrors(error);
      }
    },

    async postSection(ct_inspection_uuid, name, ct_inspection_relation_uuid = null) {
      try {
        await axios.post('api/inspection/sections', {
          ct_inspection_uuid: ct_inspection_uuid,
          ct_inspection_section: name,
          ct_inspection_relation_uuid: ct_inspection_relation_uuid,
        });
      } catch (error) {
        throw error; // Propagar el error para que sea manejado por saveSection
      }
    },

    async updateSections() {
      console.log("Entra a updateSections");
      try {
        console.log("updateSections: actualizando secciones");
        const response = await axios.get(`api/inspection/forms/get-form/${this.item.ct_inspection_uuid}`);
        this.item.template.sections = response.data.data.sections;
      } catch (error) {
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