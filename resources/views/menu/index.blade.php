<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ngetea - Premium Quality Teas</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600|playfair-display:500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; }
        h1, h2, h3, h4, .font-heading { font-family: 'Playfair Display', serif; }
        .glass-nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); }
        .premium-shadow { box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.15); }
    </style>
</head>
<body class="text-gray-800 antialiased" x-data="{ 
    selectedProduct: null,
    isModalOpen: false,
    openModal(product) {
        this.selectedProduct = product;
        this.isModalOpen = true;
        document.body.style.overflow = 'hidden';
    },
    closeModal() {
        this.isModalOpen = false;
        setTimeout(() => this.selectedProduct = null, 300);
        document.body.style.overflow = 'auto';
    }
}">

    <!-- Sticky Navigation -->
    <nav class="fixed w-full z-40 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-12 h-12 bg-emerald-800 rounded-full flex items-center justify-center text-white font-heading font-bold text-2xl shadow-md">
                        N
                    </div>
                    <span class="font-heading font-bold text-2xl tracking-tight text-gray-900">Ngetea</span>
                </div>
                <div class="flex items-center space-x-6">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 font-medium hover:text-emerald-700 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 font-medium hover:text-emerald-700 transition">Log in</a>
                    @endauth
                    <button class="bg-gray-900 hover:bg-emerald-800 text-white px-6 py-2.5 rounded-full font-medium transition-colors shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span>Cart (0)</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-emerald-900 overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1558857563-b37102e99e01?w=1600&q=80" alt="Premium Tea" class="w-full h-full object-cover opacity-30 mix-blend-overlay" />
            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-900/80 to-transparent"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 lg:py-48 flex flex-col items-center text-center">
            <span class="px-5 py-1.5 rounded-full bg-emerald-800/50 text-emerald-100 text-xs font-semibold tracking-widest uppercase mb-6 border border-emerald-700/50 backdrop-blur-md">Est. 2026</span>
            <h1 class="text-5xl md:text-7xl font-heading font-bold text-white mb-6 leading-tight">
                The Art of <br><span class="text-emerald-300 italic">Fine Tea</span>
            </h1>
            <p class="mt-4 text-lg md:text-xl text-emerald-100/80 max-w-2xl font-light leading-relaxed">
                Experience our meticulously crafted milk teas, refreshing fruit infusions, and delicate pairings. Hand-brewed to absolute perfection.
            </p>
        </div>
    </div>

    <!-- Main Menu Area -->
    <main id="menu" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 -mt-16 relative z-10">
        
        <!-- Category Navigation -->
        <div class="flex overflow-x-auto pb-4 mb-16 space-x-3 scrollbar-hide bg-white/80 backdrop-blur-xl p-3 rounded-full shadow-sm border border-gray-100 mx-auto max-w-fit">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->slug }}" class="whitespace-nowrap px-6 py-2.5 rounded-full text-gray-600 font-medium hover:bg-emerald-50 hover:text-emerald-800 transition-colors focus:outline-none">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Categories & Products -->
        <div class="space-y-24">
            @foreach($categories as $category)
                <section id="cat-{{ $category->slug }}" class="scroll-mt-32">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-heading font-bold text-gray-900">{{ $category->name }}</h2>
                        @if($category->description)
                            <p class="text-gray-500 mt-3 font-light">{{ $category->description }}</p>
                        @endif
                        <div class="w-12 h-1 bg-emerald-600 mx-auto mt-6 rounded-full"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                        @foreach($category->products as $product)
                            <!-- Product Card -->
                            <div 
                                @click="openModal({{ $product->toJson() }})"
                                class="group bg-white rounded-3xl overflow-hidden premium-shadow card-hover transition-all duration-300 border border-gray-100/50 cursor-pointer flex flex-col h-full"
                            >
                                <div class="relative h-64 overflow-hidden bg-gray-50">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" onerror="this.src='https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=500&q=80'" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" loading="lazy" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-8 flex flex-col flex-grow">
                                    <div class="flex justify-between items-start gap-4 mb-3">
                                        <h3 class="font-heading font-bold text-2xl text-gray-900 leading-tight group-hover:text-emerald-700 transition-colors">{{ $product->name }}</h3>
                                    </div>
                                    <p class="text-gray-500 text-sm line-clamp-2 mb-6 flex-grow font-light leading-relaxed">{{ $product->description }}</p>
                                    
                                    <div class="mt-auto flex items-center justify-between">
                                        <span class="font-semibold text-xl text-gray-900">${{ number_format($product->price, 2) }}</span>
                                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-950 text-gray-400 py-16 mt-32 border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-14 h-14 bg-emerald-900 rounded-full flex items-center justify-center text-white font-heading font-bold text-2xl mx-auto mb-6">N</div>
            <h2 class="text-3xl font-heading font-bold text-white mb-4">Ngetea</h2>
            <p class="mb-8 max-w-md mx-auto font-light text-gray-500">Premium hand-crafted teas delivered straight to your soul. Experience the difference in every sip.</p>
            <p class="text-sm tracking-wide">&copy; {{ date('Y') }} Ngetea. All rights reserved.</p>
        </div>
    </footer>

    <!-- Variation Modal -->
    <div x-show="isModalOpen" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl" @click.stop>
                    
                    <button @click="closeModal()" class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center rounded-full bg-white/50 backdrop-blur-md text-gray-800 hover:bg-gray-100 transition-colors z-20 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <template x-if="selectedProduct">
                        <div class="flex flex-col md:flex-row h-full max-h-[85vh]">
                            <!-- Image Side -->
                            <div class="w-full md:w-5/12 h-56 md:h-auto relative bg-gray-50">
                                <img :src="selectedProduct.image" onerror="this.src='https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=500&q=80'" :alt="selectedProduct.name" class="absolute inset-0 w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent md:hidden"></div>
                                <div class="absolute bottom-5 left-5 right-5 md:hidden">
                                    <h3 class="text-3xl font-heading font-bold text-white drop-shadow-md" x-text="selectedProduct.name"></h3>
                                </div>
                            </div>
                            
                            <!-- Content Side -->
                            <div class="w-full md:w-7/12 flex flex-col h-full bg-white">
                                <div class="p-8 pb-4 hidden md:block border-b border-gray-100">
                                    <h3 class="text-3xl font-heading font-bold text-gray-900 mb-3" x-text="selectedProduct.name"></h3>
                                    <p class="text-gray-500 font-light leading-relaxed" x-text="selectedProduct.description"></p>
                                </div>

                                <div class="p-8 overflow-y-auto flex-grow custom-scrollbar">
                                    <p class="text-gray-500 font-light md:hidden mb-6" x-text="selectedProduct.description"></p>
                                    
                                    <div class="space-y-8">
                                        <div>
                                            <h4 class="font-bold text-gray-900 mb-4 tracking-wide uppercase text-xs flex items-center justify-between">
                                                <span>Customization</span>
                                                <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full">Required</span>
                                            </h4>
                                            
                                            <div class="space-y-3">
                                                <template x-for="variation in selectedProduct.variations" :key="variation.id">
                                                    <label class="flex items-center justify-between p-4 border border-gray-100 rounded-2xl cursor-pointer hover:border-emerald-500 hover:bg-emerald-50/30 transition-all">
                                                        <div class="flex items-center">
                                                            <input type="radio" :name="variation.type" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                                            <div class="ml-4">
                                                                <span class="block text-sm font-semibold text-gray-900 capitalize" x-text="variation.type.replace('_', ' ')"></span>
                                                                <span class="block text-xs text-gray-500" x-text="variation.name"></span>
                                                            </div>
                                                        </div>
                                                        <template x-if="variation.additional_price > 0">
                                                            <span class="text-sm font-semibold text-gray-900" x-text="'+$' + Number(variation.additional_price).toFixed(2)"></span>
                                                        </template>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 border-t border-gray-100 bg-white shrink-0">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center border border-gray-200 rounded-full h-14 bg-gray-50 px-2">
                                            <button class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-white hover:shadow-sm transition-all focus:outline-none">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                            </button>
                                            <span class="w-8 text-center font-bold text-gray-900">1</span>
                                            <button class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-white hover:shadow-sm transition-all focus:outline-none">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            </button>
                                        </div>
                                        
                                        <button @click="closeModal()" class="flex-grow bg-gray-900 hover:bg-emerald-800 text-white h-14 rounded-full font-bold flex items-center justify-between px-8 transition-all shadow-lg transform hover:-translate-y-1">
                                            <span>Add to Order</span>
                                            <span x-text="'$' + Number(selectedProduct.price).toFixed(2)"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #fafafa; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    </style>
</body>
</html>
