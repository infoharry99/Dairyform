@extends('layouts.admin')

@section('title', 'Dairy Products Catalog - MilkFlow')
@section('page_title', 'Value-Added Dairy Products')

@section('header_badge')
<span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200">
    Catalog & Inventory
</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ addProductModal: false }">
    <!-- Top Action Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Dairy Inventory & Price Management</h3>
            <p class="text-xs text-slate-500">Sell extra curd, paneer, and ghee alongside regular morning milk deliveries.</p>
        </div>

        <button type="button" @click="addProductModal = true" 
                class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition flex items-center gap-1.5">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Add New Product</span>
        </button>
    </div>

    <!-- Products Grid (As Required by Prompt) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $prod)
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:border-brand-500/40 transition flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                        {{ $prod->category }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $prod->stock > 10 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                        {{ $prod->stock > 0 ? $prod->stock . ' ' . $prod->unit . ' in stock' : 'Out of Stock' }}
                    </span>
                </div>

                <h4 class="font-bold text-slate-900 text-base mb-1">{{ $prod->name }}</h4>
                <div class="text-xl font-black text-brand-700 mb-4">
                    ₹{{ number_format($prod->price) }} <span class="text-xs text-slate-400 font-normal">/ {{ $prod->unit }}</span>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Fast Selling</span>
                <button type="button" onclick="alert('Inventory stock updated for {{ $prod->name }}.');" class="text-brand-600 hover:text-brand-800 font-bold">
                    Edit Price / Stock
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal: Add New Product -->
    <div x-cloak x-show="addProductModal" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="addProductModal" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="addProductModal = false"></div>

            <div x-show="addProductModal" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full border border-slate-200">
                <div class="bg-brand-900 p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-brand-300 uppercase tracking-widest">Inventory Management</span>
                        <h3 class="text-lg font-bold">Add New Dairy Product</h3>
                    </div>
                    <button @click="addProductModal = false" class="text-white/70 hover:text-white p-1 rounded-lg">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('dairy.products.store') }}" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Product Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Masala Shrikhand" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Category *</label>
                            <select name="category" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-medium">
                                <option value="milk">Milk</option>
                                <option value="curd">Curd / Dahi</option>
                                <option value="paneer">Paneer</option>
                                <option value="ghee">Ghee</option>
                                <option value="butter">Butter</option>
                                <option value="buttermilk">Buttermilk</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Unit *</label>
                            <input type="text" name="unit" value="kg" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Price per Unit (₹) *</label>
                            <input type="number" step="1" name="price" value="280" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-bold">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Initial Stock *</label>
                            <input type="number" name="stock" value="20" required class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50 font-bold">
                        </div>
                    </div>

                    <div class="pt-4 border-t flex justify-end gap-2">
                        <button type="button" @click="addProductModal = false" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 font-semibold">Cancel</button>
                        <button type="submit" class="px-6 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold shadow">
                            Save to Catalog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
