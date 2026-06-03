<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Recibimos los datos del artista que se va a editar
const props = defineProps({
    artista: Object
});

// Inicializamos el formulario con los datos actuales del artista
const form = useForm({
    nombres: props.artista.nombres,
    nacionalidad: props.artista.nacionalidad
});

// Función para mandar los cambios con PUT
const submit = () => {
    form.put(route('artistas.update', props.artista.id));
};
</script>

<template>
    <Head title="Editar Artista" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Artista</h2>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <div>
                            <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres Completos</label>
                            <input 
                                type="text" 
                                id="nombres" 
                                v-model="form.nombres" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                            <div v-if="form.errors.nombres" class="text-red-600 text-sm mt-1">
                                {{ form.errors.nombres }}
                            </div>
                        </div>

                        <div>
                            <label for="nacionalidad" class="block text-sm font-medium text-gray-700">Nacionalidad</label>
                            <input 
                                type="text" 
                                id="nacionalidad" 
                                v-model="form.nacionalidad" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                            <div v-if="form.errors.nacionalidad" class="text-red-600 text-sm mt-1">
                                {{ form.errors.nacionalidad }}
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <Link :href="route('artistas.index')" class="text-sm text-gray-600 hover:text-gray-900 px-3 py-2">
                                Cancelar
                            </Link>
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded shadow transition disabled:opacity-50"
                            >
                                {{ form.processing ? 'Actualizando...' : 'Actualizar Artista' }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>