<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $role = auth()->user()->role;
        $route = $role === 'operator' ? route('operator', absolute: false) : route('dashboard', absolute: false);

        $this->redirectIntended(default: $route, navigate: true);
    }
}; ?>

<div>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-semibold text-white">Bienvenido de nuevo</h2>
        <p class="text-sm text-slate-400 mt-2">Ingresa a tu cuenta para continuar</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-300">Correo Electrónico</label>
            <div class="mt-2 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" 
                    class="block w-full pl-11 pr-4 py-3 border border-slate-700/80 rounded-xl bg-slate-950/50 text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="tu@correo.com">
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-300">Contraseña</label>
            <div class="mt-2 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-4 py-3 border border-slate-700/80 rounded-xl bg-slate-950/50 text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center cursor-pointer group">
                <input wire:model="form.remember" id="remember" type="checkbox" class="w-4 h-4 rounded border-slate-700 bg-slate-950/50 text-blue-500 focus:ring-blue-500 focus:ring-offset-slate-900 transition-colors cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-slate-400 group-hover:text-slate-300 transition-colors">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/30 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-slate-900 transition-all duration-200 hover:-translate-y-0.5">
                Iniciar Sesión
            </button>
        </div>
    </form>
</div>
