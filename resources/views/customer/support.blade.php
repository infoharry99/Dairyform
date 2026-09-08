@extends('layouts.customer')

@section('title', 'Help & Dairy Support - MilkFlow')

@section('content')
<div class="space-y-4" x-data="{ newTicketModal: false }">
    <!-- Header -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-[10px] font-bold text-brand-600 uppercase">Direct Helpdesk</span>
            <h1 class="text-base font-black text-slate-900">Contact Dairy Shop</h1>
        </div>
        <button type="button" @click="newTicketModal = true" 
                class="px-3 py-1.5 rounded-xl bg-brand-600 text-white font-bold text-xs shadow-sm flex items-center gap-1">
            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
            <span>Raise Query</span>
        </button>
    </div>

    <!-- Active Tickets / Previous Queries -->
    <div class="space-y-3">
        @forelse($tickets as $t)
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3 text-xs">
            <div class="flex items-center justify-between border-b pb-2.5">
                <div>
                    <span class="font-mono text-[10px] text-slate-400 font-bold block">{{ $t->ticket_number }}</span>
                    <strong class="text-slate-900 text-sm">{{ $t->subject }}</strong>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                    {{ $t->status === 'resolved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    {{ $t->status }}
                </span>
            </div>

            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed">
                <span class="text-[10px] text-slate-400 font-bold block mb-1">Your Message:</span>
                {{ $t->message }}
            </div>

            @if($t->reply)
            <div class="bg-brand-50/70 p-3 rounded-2xl border border-brand-100 text-brand-900 leading-relaxed">
                <span class="text-[10px] text-brand-600 font-bold block mb-1">Reply from {{ $customer->dairy->name }}:</span>
                {{ $t->reply }}
            </div>
            @else
            <span class="text-[10px] text-slate-400 italic block">Pending reply from dairy owner...</span>
            @endif
        </div>
        @empty
        <div class="bg-white p-8 rounded-3xl border border-slate-200 text-center space-y-2">
            <div class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center mx-auto">
                <i data-lucide="message-square" class="w-5 h-5"></i>
            </div>
            <h3 class="text-sm font-bold text-slate-800">No support tickets</h3>
            <p class="text-xs text-slate-500">Need help or want to speak with your dairy owner? Raise a query above.</p>
        </div>
        @endforelse
    </div>

    <!-- Modal: Raise New Support Query -->
    <div x-cloak x-show="newTicketModal" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="newTicketModal" x-transition.opacity class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm" @click="newTicketModal = false"></div>

            <div x-show="newTicketModal" x-transition.scale class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-sm sm:w-full border border-slate-200">
                <div class="bg-brand-900 p-5 text-white flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold">Message {{ $customer->dairy->name }}</h3>
                        <span class="text-[10px] text-brand-300">Direct query to owner</span>
                    </div>
                    <button @click="newTicketModal = false" class="text-white/70 hover:text-white p-1 rounded-lg">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('customer.support.store') }}" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Subject *</label>
                        <input type="text" name="subject" required placeholder="e.g. Question about September bill / extra milk" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Detailed Message *</label>
                        <textarea name="message" rows="3" required placeholder="Type your message for the dairy owner..." class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50/50"></textarea>
                    </div>

                    <div class="pt-2 border-t flex justify-end gap-2">
                        <button type="button" @click="newTicketModal = false" class="px-3 py-2 rounded-xl text-slate-600 font-semibold">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold shadow">
                            Send Query
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
