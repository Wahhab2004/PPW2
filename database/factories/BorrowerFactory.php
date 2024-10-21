<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;
use App\Models\Book;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrower>
 */
class BorrowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Tentukan loanDate: antara tiga bulan terakhir hingga sekarang
        $loanDate = Carbon::now()->subDays(rand(0, 90));

        // Tentukan dueDate: 14 hari setelah loanDate
        $dueDate = (clone $loanDate)->addDays(14);

        // Tentukan returnDate: bisa sebelum dueDate (tepat waktu) atau setelah dueDate (telat)
        $isLate = $this->faker->boolean(50); //50% kemungkinan terlambat
        if ($isLate) {
            // Return terlambat, setelah dueDate hingga 30 hari setelahnya
            $returnDate = (clone $dueDate)->addDays(rand(1, 30));
        } else {
            // Return tepat waktu, sebelum atau tepat pada dueDate
            $returnDate = (clone $loanDate)->addDays(rand(1, 14));
        }

        // Hitung denda: 1000 per hari keterlambatan
        $fine = 0;
        if ($returnDate > $dueDate) {
            $lateDays = $returnDate->diffInDays($dueDate);
            $fine = $lateDays * -1000;
        }

        return [
            'member_id' => Member::inRandomOrder()->first()->id,
            'book_id' => Book::inRandomOrder()->first()->id,
            'loan_date' => $loanDate,
            'return_date' => $returnDate,
            'due_date' => $dueDate,
            'fine' => $fine,
        ];
    }
}
