<template>
    <div>
      <SectionCard
        v-for="(section, index) in template.sections"
        :key="section.id"
        :section="section"
        :title="index.replaceAll('_', ' ').toUpperCase()"
      />
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
    }
  }
  </script>