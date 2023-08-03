<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kode' => $this->faker->sentence() . '-'. $this->faker->randomDigit(),
            'judul' => $this->faker->sentence(),
            'isbn' => $this->faker->randomDigit(),
            'pengarang' => $this->faker->name(),
            'jumlah_halaman' => $this->faker->randomDigit(),
            'jumlah_stok' => $this->faker->randomDigit(),
            'tahun_terbit' => $this->faker->date('Y_m_d'),
            'sinopsis' => $this->faker->text(),
            'gambar' => $this->faker->imageUrl(640,480),
            'id_kategori' => $this->faker->numberBetween(0, 100),
        ];
    }
}
