/* --------------------------------------------------------------------------
 * 1. CONFIGURACIÓN GLOBAL
 * ------------------------------------------------------------------------ */
document.addEventListener('DOMContentLoaded', () => {
    // Axios ya está cargado en app.blade.php; aquí añadimos un “toast” simple.
    window.toast = (msg, type = 'success') => {
        // SweetAlert2:  Swal.fire(msg, '', type);
        alert(msg); // 
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
function initEdit () {
  const el = document.getElementById('tarea-edit');
  if (!el) return;

  const initial = JSON.parse(el.dataset.initial || '{}');
  const id      = el.dataset.id;

  new Vue({
    el: '#tarea-edit',
    data: {
      loading: false,
      form: {
        titulo:      initial.titulo      || '',
        descripcion: initial.descripcion || '',
        estado:      initial.estado      || 'pendiente'
      }
    },

  
    template: `
      <form @submit.prevent="update" class="space-y-6">
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

        <button :disabled="loading"
                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
          Actualizar
        </button>
        <a href="/tareas" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
      </form>
    `,

    methods: {
      update () {
        this.loading = true;
        axios.put(`/tareas/${id}`, this.form)
             .then(() => {
                 alert('Tarea actualizada');
                 window.location.href = '/tareas';   // o route('tareas.index')
             })
             .finally(() => (this.loading = false));
      }
    }
  });
}




/* --------------------------------------------------------------------------
 * 4. VISTA: LISTAR TAREAS
 * ------------------------------------------------------------------------ */
function initIndex () {
    const el = document.getElementById('tarea-index');
    if (!el) return;

    /* añadimos show:false a cada tarea */
    const initial = (JSON.parse(el.dataset.initial || '[]'))
                    .map(t => ({ ...t, show: false }));

    new Vue({
        el: '#tarea-index',
        data: { tareas: initial },

        methods: {
            toggle (t) { t.show = !t.show },

            cambiarEstado (t) {
                const nuevo = t.estado === 'pendiente'
                              ? 'completado'
                              : 'pendiente';

                axios.put(`/tareas/${t.id}`, { ...t, estado: nuevo })
                     .then(() => {
                         t.estado = nuevo;          
                         toast('Estado actualizado');
                     })
                     .catch(() => toast('Error', 'error'));
            },

            borrar (t) {
                if (!confirm('¿Eliminar la tarea?')) return;
                axios.delete(`/tareas/${t.id}`)
                     .then(() => {
                         this.tareas = this.tareas.filter(x => x.id !== t.id);
                         toast('Tarea eliminada');
                     })
                     .catch(() => toast('Error', 'error'));
            },

            routeEdit (id) { return `/tareas/${id}/edit`; }
        }
    });
}

/* -------------------  ESTADÍSTICAS  ------------------- */
function initStats () {
    const el = document.getElementById('tarea-stats');
    if (!el) return;

    const url = el.dataset.url;

    new Vue({
        el: '#tarea-stats',
        data: { stats: null },

        template: `
          <div v-if="stats"
               class="bg-white shadow rounded-lg p-6 mx-auto max-w-md
                      flex flex-col items-center">

              <h2 class="text-lg font-semibold text-gray-700 mb-4">
                  Resumen de tareas
              </h2>

              <!-- dona de 256×256 -->
              <canvas id="chartTareas" class="w-64 h-64"></canvas>

              <!-- leyenda -->
              <div class="mt-4 flex gap-6 text-sm">
                  <span class="flex items-center gap-1">
                      <span class="inline-block w-3 h-3 rounded-full bg-red-400"></span>
                      Pendiente ({{ stats.pendiente }})
                  </span>
                  <span class="flex items-center gap-1">
                      <span class="inline-block w-3 h-3 rounded-full bg-green-400"></span>
                      Completado ({{ stats.completado }})
                  </span>
              </div>

              <!-- lista de pendientes -->
              <div class="mt-6 w-full">
                  <h3 class="text-sm font-medium text-gray-600 mb-2">
                      Tareas pendientes
                  </h3>
                  <ul class="list-disc list-inside text-sm text-gray-700
                             space-y-1 max-h-48 overflow-y-auto">
                      <li v-for="p in stats.pendientes" :key="p.id">
                          - {{ p.titulo }}
                      </li>
                  </ul>
              </div>
          </div>
        `,

        mounted () {
            axios.get(url)
                 .then(r => {
                     this.stats = r.data;
                     this.$nextTick(this.renderChart);
                 })
                 .catch(err => console.error('stats error', err));
        },

        methods: {
            renderChart () {
                const ctx = document
                            .getElementById('chartTareas')
                            .getContext('2d');

                /* global Chart */
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pendiente', 'Completado'],
                        datasets: [{
                            data: [this.stats.pendiente,
                                   this.stats.completado],
                            backgroundColor: ['#f87171', '#34d399']
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: { legend: { display: false } }
                    }
                });
            }
        }
    });
}



initCreate();
initEdit();
initIndex();
initStats();
