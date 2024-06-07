<template>
  <div class="d-flex">
    <v-icon class="mdi mdi-subdirectory-arrow-right mt-4"></v-icon>
    <v-card class="mb-5 ml-2 mr-2 border rounded-lg w-100" variant="flat" elevation="1">
      <v-sheet class="border">
        <v-card-item>
          <template v-slot:prepend>
            <v-card-title>
              {{ title }}
            </v-card-title>
          </template>

          <v-divider class="mx-2" vertical></v-divider>
          <v-btn density="compact" icon="mdi-plus" variant="tonal" class="text-subtitle-1 me-1" color="primary"
            @click="dialog = true"></v-btn>
          <v-btn density="compact" icon="mdi-pencil" variant="tonal" class="text-subtitle-1 me-1"></v-btn>
          <v-btn density="compact" icon="mdi-trash-can" variant="tonal" class="text-subtitle-1 me-1"
            color="red"></v-btn>
        </v-card-item>
      </v-sheet>

      <div class="ml-2">
        <!-- Si la sección principal tiene campos los mostramos -->
        <p class="text-h6 font-weight-black mt-4" v-if="section.fields.length || section.fields != ''">Campos ({{
                section.fields.length ?? 1
              }})</p>
        <template v-if="section.fields">
          <FieldCard v-for="field in section.fields" :key="field.id" :field="field" />
        </template>

        <!-- Si la sección principal tiene sub-secciones las mostramos -->
        <p class="text-h6 font-weight-black mt-4" v-if="section.sub_sections && section.sub_sections.length">
          Sub-secciones
          ({{
                section.sub_sections.length }})</p>
        <template v-if="section.sub_sections">
          <SectionCard v-for="sub_section in section.sub_sections" :key="sub_section.id" :section="sub_section"
            :title="sub_section.ct_inspection_section" />
        </template>
      </div>
      <v-dialog v-model="dialog" width="auto">
        <v-card min-width="400" prepend-icon="mdi-plus" title="Nueva sección o campo">
          <v-card-text>
            <v-row dense>
              <v-col cols="12">
                <v-text-field label="Nombre*" variant="outlined" required hide-details
                  v-model="sectionForm.name"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select label="Tipo*" variant="outlined" required hide-details v-model="sectionForm.type"
                  :items="types" item-title="name" item-value="id"></v-select>
              </v-col>
              <v-col cols="12" v-if="sectionForm.type == 'field'">
                <v-checkbox label="Requerido" v-model="sectionForm.required"></v-checkbox>
              </v-col>
            </v-row>
          </v-card-text>
          <template v-slot:actions>
            <v-btn class="ms-auto" text="Cancelar" @click="dialog = false"></v-btn>
            <v-btn color="primary" text @click="save()">Guardar</v-btn>
          </template>
        </v-card>
      </v-dialog>
    </v-card>
  </div>

</template>

<script>
import { toast } from 'vue-sonner';
import FieldCard from './FieldCard.vue';

export default {
  name: 'SectionCard',
  components: {
    FieldCard
  },
  props: {
    item: {
      type: Object,
      required: true
    },
    section: {
      type: Object,
      required: true
    },
    title: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      dialog: false,
      types: [
        { id: 'field', name: 'Campo' },
        { id: 'section', name: 'Sección' },
      ],
      sectionForm: {
        name: '',
        type: '',
        required: true
      },
    }
  },
  methods: {
    async save() {

      if (this.sectionForm.type == 'section') {
        console.log("Guardamos la subsección");
        this.$emit('save-section', this.item.ct_inspection_uuid, this.sectionForm.name, this.section.section_details.ct_inspection_section_uuid);
        this.resetForm();
      } else if (this.sectionForm.type == 'field') {
        console.log("Guardamos el campo");
        try {
          console.log("Guardando campo");
          await this.saveField();
          console.log("Campo guardado");
          this.resetForm();
          console.log("Formulario reseteado");
          console.log("Actualizando secciones");
          await this.$emit('update-sections');
          console.log("Secciones actualizadas");
        } catch (error) {
          this.handleErrors(error);
        }
      }

    },
    async saveField() {
      try {
        // TODO: Hay que refactorizar este código
        let ct_inspection_section_uuid = this.section.section_details ? this.section.section_details.ct_inspection_section_uuid : this.section.ct_inspection_section_uuid;

        await axios.post('api/inspection/forms/set-form-fields', {
          ct_inspection_section_uuid: ct_inspection_section_uuid,
          fields: [
            {
              ct_inspection_form: this.sectionForm.name,
              required: this.sectionForm.required
            }
          ]
        });
      } catch (error) {
        throw error; // Propagar el error para que sea manejado por saveSection
      }
    },
    resetForm() {
      this.dialog = false;
      this.sectionForm.name = '';
      this.sectionForm.type = '';
      this.sectionForm.required = true;
    },
  }
}
</script>
