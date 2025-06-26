/* --------------------------------------------------------------------------
 * 1. CONFIGURACIÓN GLOBAL
 * ------------------------------------------------------------------------ */
document.addEventListener('DOMContentLoaded', () => {
    // Axios ya está cargado en app.blade.php; aquí añadimos un “toast” simple.
    window.toast = (msg, type = 'success') => {
        // Si tienes SweetAlert2:  Swal.fire(msg, '', type);
        alert(msg); // reemplázalo cuando instales Swal o cualquier otra lib.
    };

    initCreate();
    initEdit();
});

/* --------------------------------------------------------------------------
 * 2. VISTA: CREAR TAREA
 * ------------------------------------------------------------------------ */
function initCreate () {
    const el = document.getElementById('tarea-create');
    if (!el) return;

    const url = el.dataset.url;

    new Vue({
        el: '#tarea-create',
        data: {
            loading: false,
            form: { titulo: '', descripcion: '' }   //  ⬅ sin estado
        },
        template: `
            <div class="space-y-6 bg-white shadow rounded-lg p-6">
                <form @submit.prevent="save" class="space-y-6">

                    <div>
                        <label class="block mb-1 font-medium">Título</label>
                        <input v-model="form.titulo"
                               class="w-full border rounded px-3 py-2"
                               required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Descripción</label>
                        <textarea v-model="form.descripcion"
                                  rows="4"
                                  class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <button :disabled="loading"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded">
                            Guardar
                        </button>
                        <a href="/tareas" class="text-gray-600 hover:underline">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        `,
        methods: {
            save () {
                this.loading = true;
                axios.post(url, this.form)        // sólo título y descripción
                     .then(() => {
                         alert('Tarea creada');
                         window.location.href = '/tareas';
                     })
                     .catch(err => {
                         console.error(err.response?.data ?? err);
                         alert('Error al guardar');
                     })
                     .finally(() => this.loading = false);
            }
        }
    });
}



/* --------------------------------------------------------------------------
 * 3. VISTA: EDITAR TAREA
 * ------------------------------------------------------------------------ */
function initEdit() {
  const el = document.getElementById('tarea-edit');
  if (!el) return;

  const initial = JSON.parse(el.dataset.initial || '{}');
  const id      = el.dataset.id;

  new Vue({
    el: '#tarea-edit',
    data: {
      loading: false,
      form: {
        titulo:       initial.titulo      || '',
        descripcion:  initial.descripcion || '',
        estado:       initial.estado      || 'pendiente'
      }
    },
    template: `
      <form @submit.prevent="update" class="space-y-6">
        <div>
          <label class="block mb-1 font-medium">Título</label>
          <input v-model="form.titulo" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block mb-1 font-medium">Descripción</label>
          <textarea v-model="form.descripcion" rows="4"
                    class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div>
          <label class="block mb-1 font-medium">Estado</label>
          <select v-model="form.estado" class="border rounded px-3 py-2">
            <option value="pendiente">Pendiente</option>
            <option value="completado">Completado</option>
          </select>
        </div>

        <button :disabled="loading"
                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
          Actualizar
        </button>
        <a href="/tareas" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
      </form>
    `,
    methods: {
        update () {
            this.loading = true
            axios.put(`/tareas/${id}`, this.form)
                .then(() => {
                alert('Tarea actualizada')
                window.location.href = '/tareas'   //  ó  "{{ route('tareas.index') }}"
                })
                .finally(() => this.loading = false)
        }

    }
  });
}




/* --------------------------------------------------------------------------
 * 4. VISTA: LISTAR TAREAS
 * ------------------------------------------------------------------------ */
function initIndex() {
    const el = document.getElementById('tarea-index');
    if (!el) return;

    // datos iniciales inyectados desde Blade
    const initial = JSON.parse(el.dataset.initial || '[]');

    new Vue({
        el: '#tarea-index',
        data: {
            tareas: initial
        },
        methods: {
            /* PUT /tareas/{id} para cambiar el estado */
            cambiarEstado(t) {
                axios.put(`/tareas/${t.id}`, { ...t })
                     .then(() => toast('Estado actualizado'))
                     .catch(() => toast('Error', 'error'));
            },
            /* DELETE /tareas/{id} */
            borrar(t) {
                if (!confirm('¿Eliminar la tarea?')) return;
                axios.delete(`/tareas/${t.id}`)
                     .then(() => {
                         this.tareas = this.tareas.filter(x => x.id !== t.id);
                         toast('Tarea eliminada');
                     })
                     .catch(() => toast('Error', 'error'));
            },
            /* genera la URL de edición usando las rutas de Laravel */
            routeEdit(id) {
                return `/tareas/${id}/edit`;
            }
        }
    });
}


initCreate();
initEdit();
initIndex();
