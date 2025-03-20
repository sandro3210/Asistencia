<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';

// Interfaz de Alumno
interface Alumno {
    id: number;
    nombre: string;
    apellido: string;
    grado: string;
    seccion: string;
    fecha_nacimiento: string;
}

// Props de alumnos
defineProps<{ alumnos: Alumno[] }>();

// Estado del formulario
const form = ref({
    id: null,
    nombre: '',
    apellido: '',
    grado: '',
    seccion: '',
    fecha_nacimiento: '',
});

// Variable para verificar si estamos editando
const isEditing = ref(false);

// Función para registrar o actualizar un alumno
const submit = () => {
    if (isEditing.value && form.value.id) {
        // Actualizar alumno
        router.put(`/alumnos/${form.value.id}`, form.value, {
            onSuccess: () => resetForm(),
        });
    } else {
        // Registrar nuevo alumno
        router.post('/alumnos', form.value, {
            onSuccess: () => resetForm(),
        });
    }
};

// Función para cargar datos del alumno en el formulario de edición
const editAlumno = (alumno: Alumno) => {
    form.value = { ...alumno }; // Copiar datos
    isEditing.value = true;
};

// Función para eliminar alumno
const deleteAlumno = (id: number) => {
    if (confirm('¿Estás seguro de eliminar este alumno?')) {
        router.delete(`/alumnos/${id}`);
    }
};

// Resetear el formulario
const resetForm = () => {
    form.value = { id: null, nombre: '', apellido: '', grado: '', seccion: '', fecha_nacimiento: '' };
    isEditing.value = false;
};
</script>

<template>
    <AppSidebarLayout>
        <div class="p-6 bg-[#121212] text-[#E0E0E0] min-h-screen">
            <!-- Sección de Registro/Edición -->
            <section class="mb-6">
                <h2 class="text-2xl font-semibold mb-4">{{ isEditing ? 'Editar Alumno' : 'Registrar Alumno' }}</h2>
                <form @submit.prevent="submit" class="bg-[#1E1E1E] p-6 rounded-lg shadow-md border border-[#292929]">
                    <div class="grid grid-cols-2 gap-4">
                        <input v-model="form.nombre" placeholder="Nombre" class="input-field" required />
                        <input v-model="form.apellido" placeholder="Apellido" class="input-field" required />
                        <input v-model="form.grado" placeholder="Grado" class="input-field" required />
                        <input v-model="form.seccion" placeholder="Sección" class="input-field" required />
                        <input v-model="form.fecha_nacimiento" type="date" class="input-field col-span-2" required />
                    </div>

                    <div class="flex gap-2 mt-4">
                        <button type="submit" class="w-full bg-[#007ACC] hover:bg-[#005F99] text-white py-3 rounded-lg transition">
                            {{ isEditing ? 'Actualizar' : 'Registrar' }}
                        </button>
                        <button v-if="isEditing" type="button" @click="resetForm" class="w-full bg-[#505050] hover:bg-[#666666] text-white py-3 rounded-lg transition">
                            Cancelar
                        </button>
                    </div>
                </form>
            </section>

            <!-- Sección de Lista de Alumnos -->
            <section>
                <h2 class="text-2xl font-semibold mb-4">Lista de Alumnos</h2>
                <ul class="space-y-3">
                    <li v-for="alumno in alumnos" :key="alumno.id" class="bg-[#1E1E1E] p-4 rounded-lg shadow-md border border-[#292929] flex justify-between items-center">
                        <div>
                            <p class="font-medium text-lg">{{ alumno.nombre }} {{ alumno.apellido }}</p>
                            <p class="text-sm text-gray-400">{{ alumno.grado }} - {{ alumno.seccion }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button @click="editAlumno(alumno)" class="px-4 py-2 bg-[#FFA500] hover:bg-[#CC8400] text-white rounded-lg">
                                ✏️ Editar
                            </button>
                            <button @click="deleteAlumno(alumno.id)" class="px-4 py-2 bg-[#FF4C4C] hover:bg-[#CC3C3C] text-white rounded-lg">
                                🗑️ Eliminar
                            </button>
                        </div>
                    </li>
                </ul>
            </section>
        </div>
    </AppSidebarLayout>
</template>

<style scoped>
.input-field {
    @apply w-full p-3 bg-[#292929] border border-[#3A3A3A] rounded text-white focus:outline-none focus:ring-2 focus:ring-[#007ACC];
}
</style>
 