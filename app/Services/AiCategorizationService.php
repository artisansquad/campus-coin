<?php

namespace App\Services;

use App\Models\AiLearning;
use App\Models\Category;

class AiCategorizationService
{
    /**
     * Common student expense & income keyword patterns.
     *
     * @var array<string, array<string>>
     */
    protected array $defaultRules = [
        'Food' => [
            'cafe', 'canteen', 'mess', 'lunch', 'dinner', 'breakfast', 'subway', 'burger',
            'pizza', 'mcdonalds', 'kfc', 'coffee', 'chai', 'tea', 'bakery', 'restaurant',
            'snack', 'grocery', 'supermarket', 'mart', 'foodpanda', 'swiggy', 'zomato',
            'shawarma', 'biryani', 'juice', 'water bottle', 'dining',
        ],
        'Transport' => [
            'bus', 'metro', 'train', 'uber', 'careem', 'indrive', 'taxi', 'rickshaw',
            'petrol', 'fuel', 'gas', 'fare', 'parking', 'van', 'bike', 'scooter', 'toll',
            'commute', 'ticket',
        ],
        'Hostel/Rent' => [
            'hostel', 'rent', 'room', 'apartment', 'flat', 'mess bill', 'dorm', 'electricity',
            'utility', 'laundry', 'maintenance', 'security deposit', 'landlord',
        ],
        'Academics' => [
            'book', 'textbook', 'stationery', 'photocopy', 'print', 'tuition', 'fee',
            'semester', 'exam fee', 'pen', 'notebook', 'course', 'udemy', 'coursera',
            'assignment', 'lab fee', 'admission', 'library',
        ],
        'Subscriptions' => [
            'netflix', 'spotify', 'youtube', 'apple music', 'icloud', 'chatgpt', 'github',
            'prime', 'disney', 'subscription', 'software', 'adobe', 'vpn', 'hosting', 'domain',
        ],
        'Entertainment' => [
            'movie', 'cinema', 'theatre', 'bowling', 'gaming', 'steam', 'playstation',
            'party', 'outing', 'concert', 'match', 'cricket', 'snooker', 'billiards',
            'amusement', 'picnic', 'hangout',
        ],
        'Miscellaneous' => [
            'medical', 'medicine', 'doctor', 'pharmacy', 'clothes', 'shopping', 'shoes',
            'barber', 'haircut', 'salon', 'gift sent', 'repair', 'charity', 'donation',
        ],
        // Income categories
        'Allowance' => [
            'allowance', 'pocket money', 'dad', 'mom', 'father', 'mother', 'parents', 'home',
            'family', 'monthly allowance',
        ],
        'Part-time Job' => [
            'salary', 'part-time', 'freelance', 'upwork', 'fiverr', 'gig', 'tutoring',
            'teaching', 'tution fee received', 'internship', 'stipend', 'client payment',
        ],
        'Scholarship' => [
            'scholarship', 'merit', 'financial aid', 'grant', 'fellowship', 'bursary',
            'award',
        ],
        'Gift' => [
            'gift', 'birthday', 'eidi', 'eid gift', 'congratulations', 'present', 'cash gift',
        ],
        'Other Income' => [
            'refund', 'cashback', 'bonus', 'sold item', 'interest', 'dividend', 'loan returned',
        ],
    ];

    /**
     * Suggest a category based on the description text and student ID.
     */
    public function suggest(string $description, ?int $userId = null): ?Category
    {
        $clean = strtolower(trim($description));
        if (empty($clean)) {
            return null;
        }

        // 1. Check user-specific AI learnings first (highest priority)
        if ($userId) {
            $userLearning = AiLearning::where('user_id', $userId)
                ->whereRaw('? LIKE CONCAT("%", keyword, "%")', [$clean])
                ->orderByDesc('confidence')
                ->first();

            if ($userLearning && $userLearning->category) {
                return $userLearning->category;
            }
        }

        // 2. Check global AI learnings
        $globalLearning = AiLearning::whereNull('user_id')
            ->whereRaw('? LIKE CONCAT("%", keyword, "%")', [$clean])
            ->orderByDesc('confidence')
            ->first();

        if ($globalLearning && $globalLearning->category) {
            return $globalLearning->category;
        }

        // 3. Fallback to intelligent pattern matching dictionary
        foreach ($this->defaultRules as $categoryName => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($clean, strtolower($keyword))) {
                    $category = Category::where('name', $categoryName)
                        ->where(function ($q) use ($userId) {
                            $q->whereNull('user_id');
                            if ($userId) {
                                $q->orWhere('user_id', $userId);
                            }
                        })
                        ->first();

                    if ($category) {
                        return $category;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Learn from user corrections / transaction entries.
     */
    public function learn(int $userId, string $description, int $categoryId): void
    {
        $words = preg_split('/[\s,\.\-_]+/', strtolower(trim($description)));
        $stopWords = ['the', 'a', 'an', 'at', 'in', 'on', 'for', 'to', 'of', 'and', 'my', 'is', 'was', 'by', 'paid', 'spent', 'from', 'got'];

        foreach ($words as $word) {
            $word = trim($word);
            if (strlen($word) >= 3 && ! in_array($word, $stopWords)) {
                $learning = AiLearning::firstOrNew([
                    'user_id' => $userId,
                    'keyword' => $word,
                ]);

                $learning->category_id = $categoryId;
                $learning->confidence = ($learning->confidence ?? 0.5) + 0.5;
                $learning->save();
            }
        }
    }

    /**
     * Batch categorize descriptions (for CSV import).
     */
    public function batchSuggest(array $descriptions, ?int $userId = null): array
    {
        $results = [];
        foreach ($descriptions as $index => $desc) {
            $suggested = $this->suggest($desc, $userId);
            $results[$index] = $suggested ? [
                'category_id' => $suggested->id,
                'category_name' => $suggested->name,
                'confidence' => 0.95,
            ] : null;
        }

        return $results;
    }
}
