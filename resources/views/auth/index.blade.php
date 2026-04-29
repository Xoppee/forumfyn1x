<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fyn1x Forum - Acesso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md" x-data="{ tab: 'login' }">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black tracking-tighter bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent italic mb-2">
                FYN1X FORUM
            </h1>
            <p class="text-slate-500 text-sm font-medium">Acesse a engine da nossa comunidade</p>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-3xl shadow-2xl overflow-hidden">
            
            <div class="flex border-b border-slate-700 bg-slate-800/50">
                <button 
                    @click="tab = 'login'" 
                    :class="tab === 'login' ? 'text-blue-400 border-b-2 border-blue-400 bg-slate-700/30' : 'text-slate-500 hover:text-slate-300'"
                    class="flex-1 py-4 text-sm font-bold transition-all duration-300">
                    ENTRAR
                </button>
                <button 
                    @click="tab = 'register'" 
                    :class="tab === 'register' ? 'text-emerald-400 border-b-2 border-emerald-400 bg-slate-700/30' : 'text-slate-500 hover:text-slate-300'"
                    class="flex-1 py-4 text-sm font-bold transition-all duration-300">
                    REGISTRAR
                </button>
            </div>

            <div class="p-8">
                <div x-show="tab === 'login'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-4">
                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">E-mail</label>
                            <div class="relative">
                                <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                                <input type="email" name="email" required placeholder="seu@email.com"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between mb-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Senha</label>
                                <a href="#" class="text-xs text-blue-500 hover:underline">Esqueceu?</a>
                            </div>
                            <div class="relative">
                                <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                                <input type="password" name="password" required placeholder="••••••••"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                            ACESSAR CONTA
                        </button>
                    </form>
                </div>

                <div x-show="tab === 'register'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4">
                    <form action="{{ route('register') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nome</label>
                            <div class="relative">
                                <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                                <input type="text" name="name" required placeholder="Ex: Fyn1x_Dev"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nome de Usuário</label>
                            <div class="relative">
                                <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                                <input type="text" name="username" required placeholder="Ex: Fyn1x_Dev"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">E-mail</label>
                            <div class="relative">
                                <i data-lucide="at-sign" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                                <input type="email" name="email" required placeholder="seu@email.com"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Senha</label>
                            <div class="relative">
                                <i data-lucide="shield-check" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                                <input type="password" name="password" required placeholder="Mínimo 8 caracteres"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-600/20 transition-all active:scale-95">
                            CRIAR MINHA CONTA
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <p class="text-center mt-8 text-slate-600 text-xs tracking-widest uppercase font-bold">
            &copy; {{ date('Y') }} Fyn1x Infrastructure
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>