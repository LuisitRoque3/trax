<div class="max-w-[1400px] mx-auto p-4 md:p-6 grid grid-cols-1 xl:grid-cols-12 gap-6 relative" x-data="{ historyOpen: false }">
    
    <!-- EFECTOS DE FONDO -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- FORMULARIO NOVEDOSO (Panel Izquierdo) -->
    <div class="xl:col-span-4 flex flex-col gap-6">
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-[2rem] border border-slate-700/50 shadow-2xl overflow-hidden">
            <!-- Header Formulario -->
            <div class="bg-gradient-to-r from-blue-600/20 to-transparent p-6 border-b border-slate-700/50 flex justify-between items-center">
                <h2 class="text-white text-xl font-black tracking-tight flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </span>
                    Flash Dispatch
                </h2>
                <div class="flex items-center gap-2">
                    <button @click="historyOpen = true" type="button" class="flex items-center gap-2 text-slate-400 hover:text-white text-xs font-bold uppercase transition-colors px-3 py-1.5 rounded-lg border border-transparent hover:border-slate-500/30 hover:bg-slate-700/50">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Historial
                    </button>

                    <button wire:click="logout" class="flex items-center gap-2 text-slate-400 hover:text-red-400 text-xs font-bold uppercase transition-colors px-3 py-1.5 rounded-lg border border-transparent hover:border-red-500/30 hover:bg-red-500/10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Salir
                    </button>
                </div>
            </div>

            <form wire:submit.prevent="createOrder" class="p-6 space-y-6" x-data="{ focused: null }">
                
                <!-- Búsqueda Inteligente -->
                <div class="relative group" @click.away="focused = null">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="client_search" 
                        @focus="focused = 'search'"
                        autocomplete="off" 
                        class="w-full bg-slate-950/50 border border-slate-700 rounded-2xl text-white placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pl-12 pr-4 py-4 transition-all" 
                        placeholder="Buscar cliente (Tel o Nombre)...">
                    
                    @if(count($suggestedClients) > 0)
                    <div class="absolute z-20 mt-2 w-full bg-slate-800 border border-slate-700 rounded-2xl shadow-2xl overflow-hidden" x-show="focused === 'search'">
                        @foreach($suggestedClients as $client)
                            <button type="button" wire:click="selectClient({{ $client->id }})" class="w-full text-left px-5 py-4 hover:bg-slate-700/50 transition-colors flex items-center justify-between border-b border-slate-700/50 last:border-0">
                                <div>
                                    <span class="block text-white font-bold">{{ $client->name }}</span>
                                    <span class="block text-blue-400 text-xs font-medium">{{ $client->phone }}</span>
                                </div>
                                <span class="text-slate-500 text-xs truncate max-w-[100px]">{{ $client->default_destination }}</span>
                            </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Inputs Estilo Floating Label -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative col-span-2 sm:col-span-1">
                        <input type="text" wire:model="client_name" id="c_name" placeholder=" " class="peer w-full bg-slate-950/50 border border-slate-700 rounded-2xl text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-4 pt-6 transition-all placeholder-transparent">
                        <label for="c_name" class="absolute left-4 top-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider peer-placeholder-shown:text-sm peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-[10px] peer-focus:text-blue-400 transition-all">Nombre</label>
                    </div>
                    <div class="relative col-span-2 sm:col-span-1">
                        <input type="text" wire:model="client_phone" id="c_phone" placeholder=" " class="peer w-full bg-slate-950/50 border border-slate-700 rounded-2xl text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-4 pt-6 transition-all placeholder-transparent">
                        <label for="c_phone" class="absolute left-4 top-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider peer-placeholder-shown:text-sm peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-[10px] peer-focus:text-blue-400 transition-all">Teléfono</label>
                    </div>
                </div>

                <!-- Destino -->
                <div class="relative">
                    <input type="text" wire:model="destination" id="c_dest" placeholder=" " class="peer w-full bg-slate-950/50 border border-slate-700 rounded-2xl text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-4 pt-6 transition-all placeholder-transparent">
                    <label for="c_dest" class="absolute left-4 top-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider peer-placeholder-shown:text-sm peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-[10px] peer-focus:text-blue-400 transition-all">Destino / Dirección</label>
                </div>

                <!-- Petición Dinámica (AlpineJS para parsing visual) -->
                <div class="relative" x-data="{ 
                    get items() { 
                        return $wire.petition.split(/[\n,]+/).map(i => i.trim()).filter(i => i.length > 0); 
                    } 
                }">
                    <textarea 
                        wire:model.live="petition" 
                        id="c_pet" 
                        rows="3" 
                        placeholder=" " 
                        class="peer w-full bg-slate-950/50 border border-slate-700 rounded-2xl text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-4 pt-6 transition-all placeholder-transparent resize-none"></textarea>
                    <label for="c_pet" class="absolute left-4 top-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider peer-placeholder-shown:text-sm peer-placeholder-shown:top-4 peer-focus:top-2 peer-focus:text-[10px] peer-focus:text-blue-400 transition-all">¿Qué necesita? (Escribe y presiona Enter por producto)</label>
                    
                    <!-- Chips Dinámicos -->
                    <div class="mt-3 flex flex-wrap gap-2" x-show="items.length > 0" x-transition>
                        <template x-for="item in items">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold rounded-lg shadow-sm">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                <span x-text="item"></span>
                            </span>
                        </template>
                    </div>
                </div>

                <!-- Botones y Acciones -->
                <div class="pt-2">
                    <button type="submit" class="w-full group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white transition-all duration-200 bg-blue-600 rounded-2xl hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 focus:ring-offset-slate-900 active:scale-95 shadow-xl shadow-blue-500/20 overflow-hidden">
                        <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black pointer-events-none"></span>
                        <span class="relative flex items-center gap-2">
                            <span>Lanzar Pedido</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </span>
                    </button>
                    
                    @if($selected_client_id)
                        <button type="button" wire:click="resetClient" class="w-full mt-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 hover:text-red-400 transition-colors">
                            × Limpiar Formulario
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- LISTA DE ÓRDENES (Panel Derecho) -->
    <div class="xl:col-span-8 flex flex-col gap-4">
        <!-- Tarjetas Activas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 auto-rows-max">
            
            @forelse($pendingOrders as $order)
                <div class="bg-slate-900/60 backdrop-blur-md rounded-[2rem] p-5 border {{ $order->status === 'pending' ? 'border-orange-500/30' : 'border-green-500/30' }} flex flex-col shadow-xl transition-all hover:bg-slate-900 relative overflow-hidden group">
                    
                    <!-- Destello de estado -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl {{ $order->status === 'pending' ? 'from-orange-500/10' : 'from-green-500/10' }} to-transparent rounded-bl-full pointer-events-none"></div>

                    <div class="flex justify-between items-start mb-4 relative z-10">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-lg inline-flex items-center gap-1.5 {{ $order->status === 'pending' ? 'bg-orange-500/20 text-orange-400' : 'bg-green-500/20 text-green-400' }}">
                                @if($order->status === 'pending')
                                    <span class="w-2 h-2 rounded-full bg-orange-400 animate-pulse"></span>
                                    Buscando Operador
                                @else
                                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                                    {{ optional($order->operator)->name }}
                                @endif
                            </span>
                        </div>
                        <span class="text-slate-500 text-[10px] font-bold uppercase bg-slate-950 px-2 py-1 rounded-md">{{ $order->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="relative z-10 mb-4 flex-grow">
                        <h3 class="text-white font-black text-xl mb-1">{{ $order->client->name ?? 'Sin Cliente' }}</h3>
                        <p class="text-blue-400 text-sm font-medium mb-3 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $order->destination }}
                        </p>
                        
                        <div class="bg-slate-950/50 rounded-xl p-3 border border-slate-800">
                            <ul class="list-disc list-inside text-slate-300 text-sm italic space-y-1">
                                @foreach(preg_split('/[\n,]+/', $order->petition) as $item)
                                    @if(trim($item))
                                        <li>{{ trim($item) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @if($order->status === 'pending')
                        <div class="mt-auto relative z-10 pt-4 border-t border-slate-800">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Asignación Rápida</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($operators as $operator)
                                    <button type="button" wire:click="assignOperator({{ $order->id }}, {{ $operator->id }})" class="flex-1 min-w-[100px] bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white text-xs font-bold py-2.5 px-3 rounded-xl active:scale-95 transition-all duration-200 border border-slate-700 hover:border-blue-500 text-center truncate">
                                        {{ $operator->name }}
                                    </button>
                                @endforeach
                                @if($operators->isEmpty())
                                    <span class="text-slate-500 text-xs italic">No hay operadores registrados</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20 bg-slate-900/40 rounded-[2rem] border border-slate-800 border-dashed backdrop-blur-sm">
                    <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <p class="text-slate-400 text-xl font-bold tracking-tight">Sin órdenes en cola</p>
                    <p class="text-slate-500 text-sm mt-1">La calle está tranquila. Crea un nuevo pedido.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- SLIDE-OVER HISTORIAL -->
    <div x-show="historyOpen" class="fixed inset-0 z-50 overflow-hidden" x-cloak style="display: none;">
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" @click="historyOpen = false" x-show="historyOpen" x-transition.opacity></div>
        
        <div class="fixed inset-y-0 right-0 max-w-md w-full flex">
            <div class="w-full h-full bg-slate-900 border-l border-slate-800 shadow-2xl flex flex-col transform transition-transform" x-show="historyOpen" x-transition:enter="translate-x-full" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="translate-x-full" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                
                <div class="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900/50 backdrop-blur-xl">
                    <h2 class="text-white text-xl font-black flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Historial de Entregas
                    </h2>
                    <button @click="historyOpen = false" class="text-slate-500 hover:text-white transition-colors p-2 rounded-lg hover:bg-slate-800">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    @forelse($historyOrders as $order)
                        <div class="bg-slate-800/50 rounded-2xl p-4 border border-slate-700/50 hover:border-blue-500/30 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-white font-bold">{{ $order->client->name ?? 'Cliente' }}</h3>
                                <span class="text-slate-500 text-[10px] font-bold uppercase">{{ $order->updated_at->format('H:i') }}</span>
                            </div>
                            <p class="text-slate-400 text-xs mb-3 flex items-center gap-1">
                                <svg class="w-3 h-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Entregado por: <span class="text-slate-300 font-bold">{{ $order->operator->name ?? 'Desconocido' }}</span>
                            </p>
                            <div class="bg-slate-900/50 rounded-xl p-3 border border-slate-800/50">
                                <ul class="list-disc list-inside text-slate-400 text-xs italic space-y-1">
                                    @foreach(preg_split('/[\n,]+/', $order->petition) as $item)
                                        @if(trim($item))
                                            <li>{{ trim($item) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <svg class="w-12 h-12 text-slate-700 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-slate-500 font-medium">Aún no hay entregas completadas hoy.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
