<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\SeasonTypes;
use App\Models\Country;
use App\Models\HousingCategory;
use App\Models\HousingFormula;
use App\Models\ResidenceCategory;
use App\Models\Season;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        User::factory()->create([
            'last_name' => 'admin',
            'first_name' => 'cynab',
            'email' => 'admin@admin.com',
            'is_admin' => true,
        ]);

        $country = Country::create(['name' => 'Morocco', 'order_by' => 1, 'is_active' => true]);

        $marrakechCity = $country->cities()->create(['name' => 'Marrakech', 'order_by' => 1, 'is_active' => true]);
        $agadirCity = $country->cities()->create(['name' => 'Agadir', 'order_by' => 1, 'is_active' => true]);
        $country->cities()->createMany([
            ['name' => 'Tangier', 'order_by' => 2, 'is_active' => true],
            ['name' => 'Casablanca', 'order_by' => 1, 'is_active' => false],
        ]);

        $country = Country::create(['name' => 'Spain', 'order_by' => 2, 'is_active' => false]);

        $country->cities()->createMany([
            ['name' => 'Barcelona', 'order_by' => 1, 'is_active' => true],
            ['name' => 'Madrid', 'order_by' => 1, 'is_active' => true],
            ['name' => 'Granada', 'order_by' => 2, 'is_active' => true],
            ['name' => 'Valencia', 'order_by' => 3, 'is_active' => false],
        ]);

        $country = Country::create(['name' => 'Germany', 'order_by' => 3, 'is_active' => true]);

        $country->cities()->createMany([
            ['name' => 'Berlin', 'order_by' => 1, 'is_active' => true],
            ['name' => 'Munich', 'order_by' => 1, 'is_active' => false],
            ['name' => 'Hamburg', 'order_by' => 3, 'is_active' => true],
            ['name' => 'Cologne', 'order_by' => 4, 'is_active' => false],
        ]);

        $hotelCategoryId = ResidenceCategory::create(['name' => 'Hotel', 'order_by' => 1, 'is_active' => true])->id;
        $riadCategoryId = ResidenceCategory::create(['name' => 'Riad', 'order_by' => 2, 'is_active' => true])->id;
        ResidenceCategory::create(['name' => 'Shelter', 'order_by' => 3, 'is_active' => false]);

        HousingCategory::create(['name' => 'Single', 'order_by' => 1, 'is_active' => false]);
        $doubleCategoryId = HousingCategory::create(['name' => 'Double', 'order_by' => 2, 'is_active' => true])->id;
        $tripleCategoryId = HousingCategory::create(['name' => 'Triple', 'order_by' => 3, 'is_active' => true])->id;

        $jaalResidence = $marrakechCity->residences()->create([
            'name' => 'Jaal',
            'residence_category_id' => $riadCategoryId,
            'description' => 'This 5-star hotel and spa is located in central Marrakech, a 10-minute drive from Menara Airport. It offers a fitness center with a hot tub, and a garden with solarium.',
            'website' => 'https://jaalriadresort.com-hotel.com/',
            'email' => 'contact@jaalriad.com',
            'contact' => 'Jalal Jaal',
            'tax' => 250,
            'is_active' => true,
            'order_by' => 1,
        ]);

        $royalAtlasResidence = $agadirCity->residences()->create([
            'name' => 'Royal Atlas',
            'residence_category_id' => $hotelCategoryId,
            'description' => 'Enjoy the sun and beach while relaxing with a gorgeous seafront view. Book now! Stay in the most popular seaside resort in Morocco',
            'website' => 'https://atlashotelscollection.com/',
            'email' => 'contact@royalatlas.com',
            'contact' => 'Hamid Raly',
            'tax' => 350,
            'is_active' => true,
            'order_by' => 1,
        ]);

        $jaalHousing = $jaalResidence->housings()->create([
            'housing_category_id' => $doubleCategoryId,
            'name' => 'Cople',
            'description' => 'For lovers who want to relaxe',
            'for_max' => 2,
            'order_by' => 1,
            'is_active' => true,
        ]);

        $royalAtlasHousing = $royalAtlasResidence->housings()->create([
            'housing_category_id' => $tripleCategoryId,
            'name' => 'Friends',
            'description' => 'For triple friends',
            'for_max' => 3,
            'order_by' => 2,
            'is_active' => true,
        ]);

        $breakfastFormulaId = HousingFormula::create(['name' => 'Breakfast', 'order_by' => 1, 'is_active' => true])->id;
        $dinnerFormulaId = HousingFormula::create(['name' => 'Dinner', 'order_by' => 1, 'is_active' => true])->id;

        $jaalHousing->prices()->create([
            'housing_formula_id' => $breakfastFormulaId,
            'type_SHML' => SeasonTypes::Low->value,
            'for_one_price' => 500,
            'extra_price' => 350,
            'extra_price_is_active' => true,
            'min_nights' => 3,
            'weekends' => '0,6',
            'weekend_price' => 150,
            'weekend_is_active' => false,
            'kid_bed_price' => 200,
            'kid_bed_is_active' => false,
            'extra_bed_price' => 400,
            'extra_bed_is_active' => false,
        ]);

        $royalAtlasHousing->prices()->create([
            'housing_formula_id' => $dinnerFormulaId,
            'type_SHML' => SeasonTypes::Special->value,
            'for_one_price' => 450,
            'extra_price' => 300,
            'extra_price_is_active' => true,
            'min_nights' => 2,
            'weekends' => '0,6',
            'weekend_price' => 200,
            'weekend_is_active' => false,
            'kid_bed_price' => 200,
            'kid_bed_is_active' => false,
            'extra_bed_price' => 300,
            'extra_bed_is_active' => false,
        ]);

        $royalAtlasHousing->prices()->create([
            'housing_formula_id' => $dinnerFormulaId,
            'type_SHML' => SeasonTypes::Low->value,
            'for_one_price' => 300,
            'extra_price' => 200,
            'extra_price_is_active' => true,
            'min_nights' => 3,
            'weekends' => '0,6',
            'weekend_price' => 100,
            'weekend_is_active' => false,
            'kid_bed_price' => 200,
            'kid_bed_is_active' => false,
            'extra_bed_price' => 200,
            'extra_bed_is_active' => false,
        ]);

        Season::create([
            'date_from' => '2021-12-29',
            'date_to' => '2022-01-02',
            'description' => 'New Year',
            'type_SHML' => SeasonTypes::Special->value,
            'is_active' => true,
        ]);

        Season::create([
            'date_from' => '2022-01-03',
            'date_to' => '2022-03-01',
            'description' => 'Calm',
            'type_SHML' => SeasonTypes::Low->value,
            'is_active' => true,
        ]);

        Season::create([
            'date_from' => '2022-07-01',
            'date_to' => '2022-10-01',
            'description' => 'Summer',
            'type_SHML' => SeasonTypes::High->value,
            'is_active' => true,
        ]);

        Season::create([
            'date_from' => '2022-10-02',
            'date_to' => '2022-12-28',
            'description' => 'Late Year',
            'type_SHML' => SeasonTypes::Medium->value,
            'is_active' => true,
        ]);
    }
}
