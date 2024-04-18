<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3'


defineProps({
    equipment_categories: Object,
});

const redirecTo = (to) => {
    router.visit(to);
}
</script>

<template>

    <Head title="Equipments" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis Apps</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
                <v-row>
                    <v-col xs="12" sm="12" md="12" lg="4">
                        <h4 class="text-grey-darken-1">Administración</h4>
                        <hr>
                        <div class="d-flex align-start flex-wrap">
                            <v-card class="app text-center bg-surface-light" @click="redirecTo('dashboard')">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-monitor-dashboard" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Dashboard</v-card-text>
                                </div>
                            </v-card>
                            <v-card class="app text-center bg-surface-light">
                                <div class="px-0 py-4">
                                    <p><v-icon icon="mdi-folder-text-outline" /></p>
                                    <v-card-text class="title-app font-weight-black text-wrap">Proyectos</v-card-text>
                                </div>
                            </v-card>
                        </div>
                    </v-col>
                    <v-col xs="12" sm="12" md="12" lg="4">
                        <h4 class="text-grey-darken-1">Mantenedores</h4>
                        <hr>
                        <div class="d-flex align-start flex-wrap">
                            <v-card class="app text-center bg-surface-light" @click="redirecTo('equipments')">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-clipboard-list-outline" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Equipos</v-card-text>
                                </div>
                            </v-card>
                            <v-card class="app text-center bg-surface-light"
                                @click="redirecTo('equipments-categories')">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-list-box-outline" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Categorias</v-card-text>
                                </div>
                            </v-card>
                            <v-card class="app text-center bg-surface-light">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-format-list-checkbox" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Clientes</v-card-text>
                                </div>
                            </v-card>
                            <v-card class="app text-center bg-surface-light">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-table-cog" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Inspecciones</v-card-text>
                                </div>
                            </v-card>
                            <v-card class="app text-center bg-surface-light">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-playlist-remove" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Fallas</v-card-text>
                                </div>
                            </v-card>
                            <v-card class="app text-center bg-surface-light">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-playlist-star" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Marcas</v-card-text>
                                </div>
                            </v-card>
                            <v-card class="app text-center bg-surface-light">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-format-list-text" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Modelos</v-card-text>
                                </div>
                            </v-card>
                            <v-card class="app text-center bg-surface-light">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-barrel" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Aceites</v-card-text>
                                </div>
                            </v-card>
                        </div>
                    </v-col>
                    <v-col xs="12" sm="12" md="12" lg="4">
                        <h4 class="text-grey-darken-1">Configuración</h4>
                        <hr>
                        <div class="d-flex align-start flex-wrap">
                            <v-card class="app text-center bg-surface-light">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-account-group" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Usuarios y permisos</v-card-text>
                                </div>
                            </v-card>
                            <v-card class="app text-center bg-surface-light" @click="redirecTo('profile')">
                                <div class="px-0 py-4">
                                    <v-icon icon="mdi-face-man-profile" />
                                    <v-card-text class="title-app font-weight-black text-wrap">Perfil</v-card-text>
                                </div>
                            </v-card>
                        </div>
                    </v-col>
                </v-row>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>

export default {
    data() {
        return {

        };
    },
    methods: {

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