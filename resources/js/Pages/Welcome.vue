<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px] h-screen"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative lg:max-w-7xl">
                <main>
                    <div class="mb-12">
                        <p class="text-2xl">
                            <span class="text-white">Quality Service</span> Renovables
                            <div class="flex justify-center">
                                <p class="text-sm">Estamos creando algo increible</p>
                            </div>
                        </p>
                        <div class="flex justify-center">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('home')"
                                class="mt-4 text-white py-2 px-4 bg-gray-900 hover:bg-blue-700 rounded"
                            >
                                Home
                            </Link>

                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="mt-4 text-white py-2 px-4 bg-gray-900 hover:bg-blue-700 rounded"
                                >
                                    Ingresar al Sistema
                                </Link>
<!--                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="mt-4 text-sm/relaxed"
                                >
                                    Registrar
                                </Link>-->
                            </template>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>
