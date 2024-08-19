
<?php

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation')->nullable();
            $table->foreignIdFor(Country::class);
        });

        collect([
            'Alaska'                => 'AK',
            'Alabama'               => 'AL',
            'Arkansas'              => 'AR',
            'Arizona'               => 'AZ',
            'California'            => 'CA',
            'Colorado'              => 'CO',
            'Connecticut'           => 'CT',
            'District of Columbia ' => 'DC',
            'Delaware'              => 'DE',
            'Florida'               => 'FL',
            'Georgia'               => 'GA',
            'Hawaii'                => 'HI',
            'Iowa'                  => 'IA',
            'Idaho'                 => 'ID',
            'Illinois'              => 'IL',
            'Indiana'               => 'IN',
            'Kansas'                => 'KS',
            'Kentucky'              => 'KY',
            'Louisiana'             => 'LA',
            'Massachusetts'         => 'MA',
            'Maryland'              => 'MD',
            'Maine'                 => 'ME',
            'Michigan'              => 'MI',
            'Minnesota'             => 'MN',
            'Missouri'              => 'MO',
            'Mississippi'           => 'MS',
            'Montana'               => 'MT',
            'North Carolina'        => 'NC',
            'North Dakota'          => 'ND',
            'Nebraska'              => 'NE',
            'New Hampshire'         => 'NH',
            'New Jersey'            => 'NJ',
            'New Mexico'            => 'NM',
            'Nevada'                => 'NV',
            'New York'              => 'NY',
            'Ohio'                  => 'OH',
            'Oklahoma'              => 'OK',
            'Oregon'                => 'OR',
            'Pennsylvania'          => 'PA',
            'Rhode Island'          => 'RI',
            'South Carolina'        => 'SC',
            'South Dakota'          => 'SD',
            'Tennessee'             => 'TN',
            'Texas'                 => 'TX',
            'Utah'                  => 'UT',
            'Virginia'              => 'VA',
            'Vermont'               => 'VT',
            'Washington'            => 'WA',
            'Wisconsin'             => 'WI',
            'West Virginia'         => 'WV',
            'Wyoming'               => 'WY',
        ])
            ->map(fn ($abbreviation, $state) => ['name' => $state, 'abbreviation' => $abbreviation, 'country_id' => 1])
            ->chunk(25)
            ->each(fn ($states) => State::insert($states->toArray()));

        State::insert(['name' => 'São Paulo', 'abbreviation' => 'SP', 'country_id' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
