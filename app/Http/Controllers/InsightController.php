<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\SavingTip;
use App\Services\AiInsightService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InsightController extends Controller
{
    public function __construct(
        protected AiInsightService $insightService
    ) {}

    public function index(Request $request): View
    {
        $user = Auth::user();
        $selectedMonth = $request->query('month', Carbon::now()->format('Y-m'));

        // Generate or fetch current selected month's insight
        $currentInsight = Insight::where('user_id', $user->id)
            ->where('month', $selectedMonth)
            ->first();

        if (! $currentInsight) {
            $currentInsight = $this->insightService->generateMonthlyInsight($user, $selectedMonth);
        }

        // Fetch historical insights list
        $insightHistory = Insight::where('user_id', $user->id)
            ->orderByDesc('month')
            ->get();

        // Bookmarked tips and insights
        $bookmarkedInsights = Insight::where('user_id', $user->id)->where('is_bookmarked', true)->get();
        $bookmarkedTips = SavingTip::where('user_id', $user->id)->bookmarked()->get();

        // Upcoming month spend forecast
        $forecast = $this->insightService->forecastNextMonth($user);

        return view('user.insights', compact(
            'user',
            'selectedMonth',
            'currentInsight',
            'insightHistory',
            'bookmarkedInsights',
            'bookmarkedTips',
            'forecast'
        ));
    }

    public function generate(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $this->insightService->generateMonthlyInsight($user, $month);

        return back()->with('success', "AI spending insights regenerated for {$month}!");
    }

    public function toggleBookmark(Insight $insight): RedirectResponse
    {
        $user = Auth::user();
        if ($insight->user_id !== $user->id) {
            abort(403);
        }

        $insight->is_bookmarked = ! $insight->is_bookmarked;
        $insight->save();

        $status = $insight->is_bookmarked ? 'bookmarked' : 'unbookmarked';

        return back()->with('success', "Insight {$status} successfully.");
    }

    public function toggleTipBookmark(SavingTip $tip): RedirectResponse
    {
        $user = Auth::user();
        if ($tip->user_id && $tip->user_id !== $user->id) {
            abort(403);
        }

        $tip->is_bookmarked = ! $tip->is_bookmarked;
        $tip->save();

        return back()->with('success', 'Tip bookmark updated.');
    }

    public function dismissTip(SavingTip $tip): RedirectResponse
    {
        $user = Auth::user();
        if ($tip->user_id && $tip->user_id !== $user->id) {
            abort(403);
        }

        $tip->is_dismissed = true;
        $tip->save();

        return back()->with('success', 'Tip dismissed.');
    }

    public function togglePinTip(SavingTip $tip): RedirectResponse
    {
        $user = Auth::user();
        if ($tip->user_id && $tip->user_id !== $user->id) {
            abort(403);
        }

        $tip->is_pinned = ! $tip->is_pinned;
        $tip->save();

        return back()->with('success', $tip->is_pinned ? 'Tip pinned to top!' : 'Tip unpinned.');
    }
}
