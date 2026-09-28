@extends('layouts.app')

@section('title', 'AI Financial Coach — Campus Coin')

@section('breadcrumbs')
    <span>/</span>
    <span class="text-blue-400">AI Coach</span>
@endsection

@section('content')
<div class="space-y-6" x-data="aiCoachApp()">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center text-sm">🤖</span>
                <span>Campus Coin AI Financial Coach</span>
            </h1>
            <p class="text-xs text-slate-400 mt-1">Live financial guidance tailored to your university budget, mess bills, and savings milestones.</p>
        </div>

        <div class="flex items-center gap-2 text-xs">
            <span class="px-3 py-1.5 rounded-xl border border-slate-800 bg-slate-900/60 text-slate-300">
                Current Net Buffer: <strong class="text-blue-400 font-mono">{{ $user->currencySymbol() }}{{ number_format($balance, 2) }}</strong>
            </span>
        </div>
    </div>

    <!-- Quick Question Prompt Chips -->
    <div class="flex flex-wrap gap-2">
        <button @click="sendPredefined('How much did I spend on food this month?')" class="px-3 py-1.5 rounded-lg border border-slate-800 bg-slate-900/40 hover:border-blue-500 text-slate-300 hover:text-white text-xs transition-colors">
            🍔 Food spending check
        </button>
        <button @click="sendPredefined('Can I afford an outing or shopping this weekend?')" class="px-3 py-1.5 rounded-lg border border-slate-800 bg-slate-900/40 hover:border-blue-500 text-slate-300 hover:text-white text-xs transition-colors">
            🎟️ Can I afford an outing?
        </button>
        <button @click="sendPredefined('Give me tips to hit my savings goal')" class="px-3 py-1.5 rounded-lg border border-slate-800 bg-slate-900/40 hover:border-blue-500 text-slate-300 hover:text-white text-xs transition-colors">
            🎯 Tips to hit savings goal
        </button>
        <button @click="sendPredefined('Summarize my spending')" class="px-3 py-1.5 rounded-lg border border-slate-800 bg-slate-900/40 hover:border-blue-500 text-slate-300 hover:text-white text-xs transition-colors">
            📊 Monthly spending summary
        </button>
    </div>

    <!-- Chat Interface Container -->
    <div class="glass-panel p-6 flex flex-col h-[520px]">
        <!-- Messages Scroll Area -->
        <div id="chatContainer" class="flex-1 overflow-y-auto space-y-4 pr-2">
            <template x-for="msg in messages" :key="msg.id">
                <div class="flex gap-3" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                    <template x-if="msg.role === 'assistant'">
                        <div class="w-8 h-8 rounded-xl bg-purple-500/20 text-purple-400 border border-purple-500/30 flex items-center justify-center shrink-0 text-xs">
                            🤖
                        </div>
                    </template>

                    <div class="max-w-xl rounded-2xl p-4 text-xs leading-relaxed"
                         :class="msg.role === 'user' 
                            ? 'bg-blue-600 text-white rounded-tr-none' 
                            : 'bg-slate-900/80 border border-slate-800 text-slate-200 rounded-tl-none'">
                        <div class="whitespace-pre-line" x-html="formatMessage(msg.text)"></div>
                        <span class="block text-[10px] mt-1 opacity-60 text-right" x-text="msg.time"></span>
                    </div>

                    <template x-if="msg.role === 'user'">
                        <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 text-xs font-bold">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                    </template>
                </div>
            </template>

            <!-- Typing indicator -->
            <div x-show="isThinking" x-cloak class="flex items-center gap-2 text-slate-400 text-xs italic">
                <div class="w-2 h-2 rounded-full bg-purple-500 animate-ping"></div>
                <span>Campus Coin Coach is analyzing your financial records...</span>
            </div>
        </div>

        <!-- Chat Input Form -->
        <form @submit.prevent="sendMessage" class="mt-4 pt-4 border-t border-slate-800 flex gap-3">
            <input type="text" x-model="inputMessage" placeholder="Ask your AI coach anything about your spending, allowances, savings..."
                   :disabled="isThinking"
                   class="flex-1 px-4 py-2.5 rounded-xl border bg-slate-900/70 border-slate-700 text-xs focus:border-blue-500 focus:outline-none">
            <button type="submit" :disabled="isThinking || !inputMessage.trim()"
                    class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 disabled:opacity-50 text-white text-xs font-semibold shadow-lg shadow-blue-600/30 flex items-center gap-2 transition-all">
                <span>Ask Coach</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function aiCoachApp() {
        return {
            inputMessage: '',
            isThinking: false,
            messages: [
                {
                    id: 1,
                    role: 'assistant',
                    text: "Hello {{ $user->name }}! I am your **Campus Coin AI Financial Coach**. 💡\n\nI monitor your live spending patterns, canteen budgets, allowance flow, and savings milestones.\n\nHow can I help you optimize your student finances today?",
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                }
            ],

            sendPredefined(question) {
                this.inputMessage = question;
                this.sendMessage();
            },

            formatMessage(text) {
                // simple markdown bold formatting
                return text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            },

            async sendMessage() {
                const text = this.inputMessage.trim();
                if (!text || this.isThinking) return;

                const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                this.messages.push({ id: Date.now(), role: 'user', text, time });
                this.inputMessage = '';
                this.isThinking = true;
                this.scrollToBottom();

                try {
                    const res = await fetch("{{ route('ai.coach.chat') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ message: text })
                    });
                    const data = await res.json();
                    this.messages.push({
                        id: Date.now() + 1,
                        role: 'assistant',
                        text: data.reply || "I analyzed your numbers, but could not formulate a response. Please try rephrasing.",
                        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                    });
                } catch (e) {
                    this.messages.push({
                        id: Date.now() + 1,
                        role: 'assistant',
                        text: "Connection error. Please check your network and try again.",
                        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                    });
                } finally {
                    this.isThinking = false;
                    this.scrollToBottom();
                }
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const el = document.getElementById('chatContainer');
                    if (el) el.scrollTop = el.scrollHeight;
                });
            }
        };
    }
</script>
@endpush
