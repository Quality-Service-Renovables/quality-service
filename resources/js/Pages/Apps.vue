<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import App from '@/Components/App.vue';

defineProps({
    equipment_categories: Object,
});

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
                    <v-col xs="12" sm="12" md="12" lg="4" class="text-center pt-0">
                        <h4 class="text-grey-darken-1">Administración</h4>
                        <div class="d-flex align-start flex-wrap">
                            <App path="dashboard" title="Dashboard" icon="mdi-monitor-dashboard"/>
                            <App path="#" title="Proyectos" icon="mdi-folder-text-outline"/>
                            <App path="#" title="Usuarios y permisos" icon="mdi-account-group"/>
                            <App path="profile" title="Perfil" icon="mdi-face-man-profile"/>
                        </div>
                    </v-col>
                    <v-col xs="12" sm="12" md="12" lg="6" class="text-center pt-0">
                        <h4 class="text-grey-darken-1">Mantenedores</h4>
                        <div class="d-flex align-start flex-wrap">
                            <App path="equipments" title="Equipos" icon="mdi-clipboard-list-outline"/>
                            <App path="equipments-categories" title="Categorias" icon="mdi-list-box-outline"/>
                            <App path="customers" title="Clientes" icon="mdi-format-list-checkbox"/>
                            <App path="#" title="Inspecciones" icon="mdi-table-cog"/>
                            <App path="failures" title="Fallas" icon="mdi-playlist-remove"/>
                            <App path="trademarks" title="Marcas" icon="mdi-playlist-star"/>
                            <App path="models" title="Modelos" icon="mdi-format-list-text"/>
                            <App path="oils" title="Aceites" icon="mdi-barrel"/>
                        </div>
                    </v-col>
                </v-row>
            </div>
        </div>
    </AuthenticatedLayout>
</template>