<?php

namespace Database\Seeders;

use App\Models\Klass;
use App\Models\Section;
use App\Models\Student;
use Database\Factories\KlassFactory;
use Database\Factories\SectionFactory;
use Database\Factories\StudentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class KlassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Klass::factory()
            ->count(10)
            ->sequence(fn($sequence) => ['name' => 'Klass ' . $sequence->index + 1])
            ->has(
                Section::factory()
                    ->count(3)
                    ->state(
                        new Sequence(
                            ['name' => 'Section A'],
                            ['name' => 'Section B'],
                            ['name' => 'Section C'],
                        )
                    )
                    ->has(
                        Student::factory()
                            ->count(5)
                            ->state(
                                function (array $attributes, Section $section) {
                                    return ['klass_id' => $section->klass_id];
                                }
                            )
                    )
            )
            ->create();
    }
}
