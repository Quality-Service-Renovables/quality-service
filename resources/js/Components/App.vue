<template>
    <v-card class="app text-center bg-surface-light" @click="redirecTo(path)">
        <div class="px-0 py-4">
            <v-icon :icon="icon" />
            <v-card-text class="title-app font-weight-black text-wrap">{{ title }}</v-card-text>
        </div>
    </v-card>
</template>

<script>
import { router } from '@inertiajs/vue3'

export default {
    props: {
        path: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true
        }
    },
    data() {
        return {

        };
    },
    methods: {
        redirecTo(path) {
            router.visit(path);
        }
    },
}
</script>

<style scoped>
.app {
    background-color: #f3f4f6;
    border-radius: 15px;
    padding: 0px;
    margin: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 80px;
    min-width: 80px;
    height: 80px;
    max-height: 80px;
}

/* cada 4 elementos le ponemos el margin-left en 0 */
.app:nth-child(4n+1) {
    margin-left: 0;
}

.app:hover {
    cursor: pointer;
}

.title-app {
    padding: 0px !important;
    font-size: .75rem !important;
}

.v-card-item {
    padding: 0px !important;
}
</style>
