<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { mdiAccount } from "@mdi/js";
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <v-row class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <v-col cols="4">
                    <v-card class="card-dashboard mx-auto text-center">
                        <template v-slot:title>
                            <v-icon icon="mdi-timelapse" />
                            <br>
                            <span class="font-weight-black">En proceso</span>
                        </template>

                        <v-card-text class="bg-surface-light px-4 py-4 text-center">
                            5 proyectos en proceso
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="4">
                    <v-card class="card-dashboard mx-auto text-center">
                        <template v-slot:title>
                            <v-icon icon="mdi-check" />
                            <br>
                            <span class="font-weight-black">Finalizados</span>
                        </template>

                        <v-card-text class="bg-surface-light px-4 py-4 text-center">
                            5 proyectos finalizados
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="4">
                    <v-card class="card-dashboard mx-auto text-center">
                        <template v-slot:title>
                            <v-icon icon="mdi-alert-circle-check-outline" />
                            <br>
                            <span class="font-weight-black">Por validar</span>
                        </template>

                        <v-card-text class="bg-surface-light px-4 py-4 text-center">
                            5 proyectos por validar
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.card-dashboard {
    border-radius: 15px !important;
}

.v-card .v-icon{
    font-size: 75px !important;
}
</style>