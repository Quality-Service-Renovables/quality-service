<template>
  <div>
    <v-btn class="text-none text-subtitle-1 me-1 mb-2" color="primary">
      Agregar sección
    </v-btn>
    <p class="text-h6 font-weight-black my-2" v-if="this.template.sections">Secciones</p>
    <SectionCard v-for="(section, index) in template.sections" :key="section.id" :section="section"
      :title="index.replaceAll('_', ' ').toUpperCase()" />
  </div>
</template>

<script>
import SectionCard from './Partials/SectionCard.vue';

export default {
  components: {
    SectionCard
  },
  props: {
    template: {
      type: Object,
      required: true
    }
  },
}
</script>