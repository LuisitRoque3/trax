<div class="max-w-md mx-auto min-h-screen bg-slate-950 p-4 pb-24">
    <!-- Header App-like -->
    <header class="flex justify-between items-center mb-6 pt-4">
        <div>
            <h1 class="text-white font-black text-xl">Mi Ruta</h1>
            <p class="text-slate-400 text-sm">Operador Activo</p>
        </div>
        <button wire:click="logout" class="flex flex-col items-center justify-center text-slate-500 hover:text-red-400 transition-colors">
            <div class="w-10 h-10 bg-slate-800 border border-slate-700 rounded-full flex items-center justify-center font-bold mb-1 group-hover:border-red-500/50">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </div>
            <span class="text-[9px] font-bold uppercase tracking-wider">Salir</span>
        </button>
    </header>

    @if($activeOrder)
        <!-- Tarjeta de Orden Activa -->
        <div class="bg-slate-900 rounded-[2rem] p-6 shadow-2xl border border-blue-500/20 mb-6">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-full {{ $activeOrder->status === 'picked_up' ? 'bg-blue-500/20 text-blue-400' : 'bg-orange-500/20 text-orange-400' }}">
                    {{ $activeOrder->status === 'picked_up' ? 'En Camino al Destino' : 'Ir a Comprar/Recoger' }}
                </span>
            </div>
            
            <h2 class="text-white font-black text-2xl mb-1">{{ $activeOrder->client->name ?? 'Cliente' }}</h2>
            <p class="text-slate-400 text-sm mb-6 flex items-center gap-2">
                <span class="text-lg">📍</span> {{ $activeOrder->destination }}
            </p>

            <!-- Checklist Dinámico de Petición -->
            <div class="bg-slate-800 rounded-2xl p-4 mb-6">
                <h3 class="text-slate-400 text-[11px] font-bold uppercase mb-3">Lista de Pedido (Toca para tachar)</h3>
                <div class="space-y-2">
                    @foreach($checklist as $index => $item)
                        <div 
                            wire:click="toggleItem({{ $index }})"
                            class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-colors active:scale-95 duration-200 {{ $item['found'] ? 'bg-green-500/10 border border-green-500/20' : 'bg-slate-700/50 border border-transparent' }}"
                        >
                            <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 flex-shrink-0 {{ $item['found'] ? 'bg-green-500 border-green-500 text-white' : 'border-slate-500 text-transparent' }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-medium {{ $item['found'] ? 'text-green-400 line-through' : 'text-slate-200' }}">
                                {{ $item['text'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Botones de Acción Gigantes Táctiles -->
            @if($activeOrder->status === 'assigned')
                <button wire:click="updateStatus('picked_up')" class="w-full bg-orange-500 hover:bg-orange-400 text-white font-black text-lg rounded-2xl py-5 active:scale-95 transition-transform duration-200 shadow-xl shadow-orange-500/20">
                    Ya lo recogí / compré
                </button>
            @elseif($activeOrder->status === 'picked_up')
                <button wire:click="updateStatus('delivered')" class="w-full bg-green-500 hover:bg-green-400 text-white font-black text-lg rounded-2xl py-5 active:scale-95 transition-transform duration-200 shadow-xl shadow-green-500/20">
                    Entregado al Cliente
                </button>
            @endif
        </div>
    @else
        <!-- Estado Vacío -->
        <div class="flex flex-col items-center justify-center mt-20">
            <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mb-6 shadow-inner">
                <span class="text-4xl">🛵</span>
            </div>
            <h2 class="text-white font-bold text-xl mb-2">Sin Pedidos</h2>
            <p class="text-slate-400 text-center max-w-[250px]">Estás libre. El Traffic Control te asignará tu próximo destino.</p>
            
            <button wire:click="loadActiveOrder" class="mt-8 text-blue-400 font-bold uppercase text-[11px] tracking-wider py-2 px-4 rounded-full border border-blue-500/30 hover:bg-blue-500/10 active:scale-95 transition-all">
                Actualizar
            </button>
        </div>
    @endif
</div>
