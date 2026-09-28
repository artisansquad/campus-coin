<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AiCoachController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Calculate student financial summary for coach context
        $start = Carbon::now()->startOfMonth()->toDateString();
        $end = Carbon::now()->endOfMonth()->toDateString();

        $income = (float) Transaction::where('user_id', $user->id)->income()->whereBetween('date', [$start, $end])->sum('amount');
        $expense = (float) Transaction::where('user_id', $user->id)->expense()->whereBetween('date', [$start, $end])->sum('amount');
        $balance = $income - $expense;

        return view('user.ai.coach', compact('user', 'income', 'expense', 'balance'));
    }

    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $user = Auth::user();
        $userMsg = strtolower(trim($request->input('message')));

        $start = Carbon::now()->startOfMonth()->toDateString();
        $end = Carbon::now()->endOfMonth()->toDateString();

        $income = (float) Transaction::where('user_id', $user->id)->income()->whereBetween('date', [$start, $end])->sum('amount');
        $expense = (float) Transaction::where('user_id', $user->id)->expense()->whereBetween('date', [$start, $end])->sum('amount');
        $balance = $income - $expense;
        $currency = $user->currencySymbol();

        // Top category this month
        $topCat = Transaction::where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$start, $end])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', \DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->first();

        // Intelligent response generation based on live student data
        if (str_contains($userMsg, 'food') || str_contains($userMsg, 'eating') || str_contains($userMsg, 'cafe') || str_contains($userMsg, 'canteen') || str_contains($userMsg, 'meal') || str_contains($userMsg, 'restaurant')) {
            $foodSpent = (float) Transaction::where('user_id', $user->id)
                ->where('type', 'expense')
                ->whereBetween('date', [$start, $end])
                ->whereHas('category', fn ($q) => $q->where('name', 'Food'))
                ->sum('amount');

            $foodSaved = number_format($foodSpent * 0.25, 0);
            $reply = "You've spent **{$currency}".number_format($foodSpent, 2)."** on food this month. 🍔\n\n**Coach Recommendation:** To cut down food costs without going hungry:\n1. Utilize your hostel mess meal plan on weekdays.\n2. Keep instant oats or fruits in your room for quick breakfasts.\n3. Limit cafe deliveries or midnight fast food to once a week.\n\nThis could save you up to {$currency}{$foodSaved} monthly! That's extra budget for entertainment or savings. 💰";
        } elseif (str_contains($userMsg, 'afford') || str_contains($userMsg, 'buy') || str_contains($userMsg, 'can i spend') || str_contains($userMsg, 'budget left') || str_contains($userMsg, 'remaining')) {
            if ($balance > 2000) {
                $reply = "Looking at your current month's numbers: You have a healthy net surplus of **{$currency}".number_format($balance, 2)."**! 🎉\n\nYou can afford reasonable leisure or academic expenses. But remember your monthly savings goal of {$currency}".number_format($user->monthly_savings_goal, 2).'. Try to keep at least 20% reserved for unexpected campus needs like urgent books or emergency supplies!';
            } elseif ($balance > 0) {
                $reply = "Your remaining net balance for this month is **{$currency}".number_format($balance, 2)."**. While you're currently in the green, your safety buffer is tight. 🤏\n\nIf it's a non-essential purchase (concert ticket, new gadget, etc.), I'd suggest postponing it until your next allowance arrives. Focus on essentials only!";
            } else {
                $reply = "⚠️ **Heads up:** Your spending has outpaced your income by {$currency}".number_format(abs($balance), 2).'. I strongly recommend holding off on non-essential purchases until next month to avoid borrowing money or hostel overdrafts. 🚨';
            }
        } elseif (str_contains($userMsg, 'goal') || str_contains($userMsg, 'target') || str_contains($userMsg, 'save') || str_contains($userMsg, 'savings')) {
            $target = (float) $user->monthly_savings_goal;
            $currentSaved = max(0, $balance);
            $pct = $target > 0 ? round(($currentSaved / $target) * 100, 1) : 0;

            $reply = "Your monthly savings target is **{$currency}".number_format($target, 2)."**.\n\nCurrently, you have retained **{$currency}".number_format($currentSaved, 2)."** ({$pct}% completed). 🎯\n\n**Action Plan:** ".($pct >= 100 ? "🏆 Outstanding achievement! You've already met your goal this month. Lock this surplus into your emergency fund for campus emergencies!" : "You need to save {$currency}".number_format(max(100, ($target - $currentSaved)), 0).' more. Set aside {$currency}'.number_format(max(100, ($target - $currentSaved) / 10), 0).' over each remaining week to hit 100%!');
        } elseif (str_contains($userMsg, 'summary') || str_contains($userMsg, 'status') || str_contains($userMsg, 'how much') || str_contains($userMsg, 'breakdown') || str_contains($userMsg, 'total')) {
            $reply = 'Here is your live campus financial snapshot for '.Carbon::now()->format('F Y').":\n\n**💵 Total Inflow:** {$currency}".number_format($income, 2)."\n**💸 Total Outflow:** {$currency}".number_format($expense, 2)."\n**🎁 Net Balance:** {$currency}".number_format($balance, 2)."\n**🏆 Top Spend:** ".($topCat ? "{$topCat->name} ({$currency}".number_format($topCat->total, 2).')' : 'None logged yet')."\n\nFeel free to ask me for specific category tips or strategies to optimize your spending!";
        } elseif (str_contains($userMsg, 'hello') || str_contains($userMsg, 'hi') || str_contains($userMsg, 'hey') || str_contains($userMsg, 'namaste') || str_contains($userMsg, 'howdy') || str_contains($userMsg, 'good')) {
            $greeting = 'Hey '.($user->name ?? 'there')."! 👋 I'm your Campus Coin AI Financial Coach.\n\nI'm here to help you make smarter money decisions during college. Let me know:\n- How much you're spending on specific categories\n- If you can afford something this month\n- Tips to hit your savings goals\n- Your monthly financial overview\n\nWhat would you like to know about your budget? 💡";
            $reply = $greeting;
        } elseif (str_contains($userMsg, 'help') || str_contains($userMsg, 'what can') || str_contains($userMsg, 'how do')) {
            $reply = "I can help you with:\n\n**💰 Spending Analysis:**\n- 'How much did I spend on food?'\n- 'Show me my spending summary'\n- 'What's my top expense category?'\n\n**🎯 Affordability Check:**\n- 'Can I buy this gadget?'\n- 'Do I have budget left?'\n- 'Am I overspending?'\n\n**📈 Savings Strategy:**\n- 'How close am I to my savings goal?'\n- 'Give me money-saving tips'\n- 'How can I save more?'\n\n**👥 General Help:**\n- Just chat naturally! I understand context.\n\nWhat's on your mind? 🧠";
        } elseif (str_contains($userMsg, 'tip') || str_contains($userMsg, 'advice') || str_contains($userMsg, 'reduce') || str_contains($userMsg, 'save')) {
            $expensePct = $income > 0 ? round(($expense / $income) * 100, 1) : 0;
            $savings = "Here are some campus-specific money-saving tips:\n\n🎓 **Academic Savings:**\n- Buy used textbooks from seniors or rent them\n- Share subscriptions (streaming, apps) with roommates\n- Use library resources instead of buying materials\n\n🍔 **Food Savings:**\n- Stick to mess meals on weekdays\n- Cook instant noodles in your room for late-night cravings\n- Avoid expensive cafes; use campus canteen\n\n🎉 **Entertainment:**\n- Look for free campus events and workshops\n- Share movie tickets with friends (group discounts)\n- Limit outings to 1-2 times per month\n\n📱 **Tech & Utilities:**\n- Cancel unused subscriptions\n- Use free WiFi instead of mobile data\n- Charge devices during free electricity hours\n\nYou're currently spending **{$expensePct}%** of your income. Great job if it's below 80%! 👍";
            $reply = $savings;
        } else {
            $reply = "I'm not entirely sure what you mean, but I'm learning! 🧠\n\nTry asking me something like:\n- *'How much did I spend on food this month?'*\n- *'Can I afford a concert ticket?'*\n- *'Show me my spending summary'*\n- *'Give me saving tips'*\n\nOr just tell me what's on your mind about your budget, and I'll do my best to help! 💡";
        }

        return response()->json([
            'success' => true,
            'reply' => $reply,
        ]);
    }
}
