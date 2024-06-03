<template>
  <v-card class="ma-4 border" variant="flat">
    <v-sheet class="border">
      <v-card-item>
        <template v-slot:prepend>
          <v-card-title>
            {{ title }}
          </v-card-title>
        </template>

        <v-divider class="mx-2" vertical></v-divider>

        <v-btn class="text-none text-subtitle-1 me-1" color="primary" size="small">
          Agregar
        </v-btn>
        <v-btn class="text-none text-subtitle-1 me-1" size="small" variant="tonal">
          Editar
        </v-btn>
        <v-btn class="text-red text-subtitle-1 me-1" size="small" variant="tonal">
          Eliminar
        </v-btn>
      </v-card-item>
    </v-sheet>

    <!-- Si la sección principal tiene campos los mostramos -->
    <p class="text-h5 font-weight-black m-4" v-if="section.fields && section.fields.length">Campos ({{ section.fields.length }})</p>
    <template v-if="section.fields">
      <FieldCard v-for="field in section.fields" :key="field.id" :field="field" />
    </template>

    <!-- Si la sección principal tiene sub-secciones las mostramos -->
    <p class="text-h5 font-weight-black m-4" v-if="section.sub_sections && section.sub_sections.length">Sub-secciones ({{ section.sub_sections.length }})</p>
    <template v-if="section.sub_sections">
      <SectionCard v-for="sub_section in section.sub_sections" :key="sub_section.id" :section="sub_section" :title="sub_section.ct_inspection_section" />
    </template>

  </v-card>
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
