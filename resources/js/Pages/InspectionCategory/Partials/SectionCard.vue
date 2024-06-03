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
          <v-btn density="compact" icon="mdi-plus" variant="tonal" class="text-subtitle-1 me-1" color="primary"></v-btn>
          <v-btn density="compact" icon="mdi-pencil" variant="tonal" class="text-subtitle-1 me-1"></v-btn>
          <v-btn density="compact" icon="mdi-trash-can" variant="tonal" class="text-subtitle-1 me-1" color="red"></v-btn>
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
    </v-card>
  </div>

</template>

<script>
import FieldCard from './FieldCard.vue';

export default {
  name: 'SectionCard',
  components: {
    FieldCard
  },
  props: {
    section: {
      type: Object,
      required: true
    },
    title: {
      type: String,
      required: true
    }
  }
}
</script>
