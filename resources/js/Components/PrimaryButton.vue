<script setup>
defineProps({
    prependIcon: {
        type: String,
        default: '',
    },
    loading: {
        type: Boolean,
        default: false,
    },
});
</script>
<template>
    <v-btn
        class="bg-grey-darken-4"
        :loading="loading"
    >
        <v-icon v-if="prependIcon" class="mr-2">{{ prependIcon }}</v-icon>
        <slot />
    </v-btn>
</template>
