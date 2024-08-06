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
    <button
        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
        :disabled="loading"
        @click="handle($event)"
    >
        <v-icon v-if="prependIcon" class="mr-2">{{ prependIcon }}</v-icon>
        <slot />
    </button>
</template>

<script>
export default {
    methods: {
        handle(e) {
            e.preventDefault();
        },
    },
}
</script>
