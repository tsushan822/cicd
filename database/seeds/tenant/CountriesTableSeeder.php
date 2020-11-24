<?php

namespace Seeds\Tenant;

use App\Zen\Setting\Model\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        Country ::truncate();

        $addCountry = $this -> addCountry();
        $this -> addToDataBase($addCountry);

        $otherCountries = $this -> addExtraCountry();
        $this -> addToDataBase($otherCountries);
    }

    public function addCountry()
    {

        return [
            //1
            [
                'name' => 'European Union',
                'iso_3166_code' => 'europeanunion',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //2
            [
                'name' => 'United States Of America',
                'iso_3166_code' => 'us',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //3
            [
                'name' => 'Russia',
                'iso_3166_code' => 'ru',
                'is_EEA' => 0,
                'currency_id' => 3,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //4
            [
                'name' => 'Switzerland',
                'is_EEA' => 0,
                'iso_3166_code' => 'ch',
                'currency_id' => 4,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //5
            [
                'name' => 'Norway',
                'is_EEA' => 1,
                'iso_3166_code' => 'no',
                'currency_id' => 5,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //6
            [
                'name' => 'Sweden',
                'is_EEA' => 1,
                'iso_3166_code' => 'se',
                'currency_id' => 6,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //7
            [
                'name' => 'Poland',
                'is_EEA' => 1,
                'iso_3166_code' => 'pl',
                'currency_id' => 7,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //8
            [
                'name' => 'Romania',
                'is_EEA' => 1,
                'iso_3166_code' => 'ro',
                'currency_id' => 8,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //9
            [
                'name' => 'Finland',
                'iso_3166_code' => 'fi',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //10
            [
                'name' => 'Germany',
                'iso_3166_code' => 'de',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //11
            [
                'name' => 'Austria',
                'iso_3166_code' => 'at',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //12
            [
                'name' => 'Belgium',
                'iso_3166_code' => 'be',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //13
            [
                'name' => 'Bulgaria',
                'iso_3166_code' => 'bg',
                'is_EEA' => 1,
                'currency_id' => 9,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //14
            [
                'name' => 'Croatia',
                'iso_3166_code' => 'hr',
                'is_EEA' => 1,
                'currency_id' => 10,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //15
            [
                'name' => 'Cyprus',
                'iso_3166_code' => 'cy',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //16
            [
                'name' => 'Czech Republic',
                'iso_3166_code' => 'cz',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //17
            [
                'name' => 'Denmark',
                'iso_3166_code' => 'dk',
                'is_EEA' => 1,
                'currency_id' => 12,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //18
            [
                'name' => 'Estonia',
                'iso_3166_code' => 'ee',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //19
            [
                'name' => 'France',
                'iso_3166_code' => 'fr',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //20
            [
                'name' => 'Greece',
                'iso_3166_code' => 'gr',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //21
            [
                'name' => 'Hungary',
                'iso_3166_code' => 'hu',
                'is_EEA' => 1,
                'currency_id' => 13,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //22
            [
                'name' => 'Ireland',
                'iso_3166_code' => 'ie',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //23
            [
                'name' => 'Italy',
                'iso_3166_code' => 'it',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //24
            [
                'name' => 'Latvia',
                'iso_3166_code' => 'lv',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //25
            [
                'name' => 'Lithuania',
                'iso_3166_code' => 'lt',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //26
            [
                'name' => 'Luxembourg',
                'iso_3166_code' => 'lu',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //27
            [
                'name' => 'Malta',
                'iso_3166_code' => 'mt',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //28
            [
                'name' => 'Netherlands',
                'iso_3166_code' => 'nl',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //29
            [
                'name' => 'Portugal',
                'iso_3166_code' => 'pt',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //30
            [
                'name' => 'Slovakia',
                'iso_3166_code' => 'sk',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //31
            [
                'name' => 'Slovenia',
                'iso_3166_code' => 'si',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //32
            [
                'name' => 'Spain',
                'iso_3166_code' => 'es',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //33
            [
                'name' => 'United Kingdom',
                'iso_3166_code' => 'gb',
                'is_EEA' => 1,
                'currency_id' => 14,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //34
            [
                'name' => 'Iceland',
                'iso_3166_code' => 'is',
                'is_EEA' => 1,
                'currency_id' => 15,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //35
            [
                'name' => 'Liechtenstein',
                'iso_3166_code' => 'li',
                'is_EEA' => 1,
                'currency_id' => 1,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //36
            [
                'name' => 'Japan',
                'iso_3166_code' => 'jp',
                'is_EEA' => 0,
                'currency_id' => 16,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //37
            [
                'name' => 'Turkey',
                'iso_3166_code' => 'tr',
                'is_EEA' => 1,
                'currency_id' => 17,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //38
            [
                'name' => 'Australia',
                'iso_3166_code' => 'au',
                'is_EEA' => 0,
                'currency_id' => 18,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //39
            [
                'name' => 'Brazil',
                'iso_3166_code' => 'br',
                'is_EEA' => 0,
                'currency_id' => 19,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //40
            [
                'name' => 'Canada',
                'iso_3166_code' => 'ca',
                'is_EEA' => 0,
                'currency_id' => 20,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //41
            [
                'name' => 'China',
                'iso_3166_code' => 'cn',
                'is_EEA' => 0,
                'currency_id' => 21,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //42
            [
                'name' => 'Hong Kong',
                'iso_3166_code' => 'hk',
                'is_EEA' => 0,
                'currency_id' => 22,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //43
            [
                'name' => 'India',
                'iso_3166_code' => 'in',
                'is_EEA' => 0,
                'currency_id' => 23,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //44
            [
                'name' => 'Indonesia',
                'iso_3166_code' => 'id',
                'is_EEA' => 0,
                'currency_id' => 24,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //45
            [
                'name' => 'South Korea',
                'iso_3166_code' => 'kr',
                'is_EEA' => 0,
                'currency_id' => 25,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //46
            [
                'name' => 'Mexico',
                'iso_3166_code' => 'mx',
                'is_EEA' => 0,
                'currency_id' => 26,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //47
            [
                'name' => 'Malaysia',
                'iso_3166_code' => 'my',
                'is_EEA' => 0,
                'currency_id' => 27,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //48
            [
                'name' => 'New Zealand',
                'iso_3166_code' => 'nz',
                'is_EEA' => 0,
                'currency_id' => 28,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //49
            [
                'name' => 'Philippines',
                'iso_3166_code' => 'ph',
                'is_EEA' => 0,
                'currency_id' => 29,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //50
            [
                'name' => 'Singapore',
                'iso_3166_code' => 'sg',
                'is_EEA' => 0,
                'currency_id' => 30,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //51
            [
                'name' => 'Thailand',
                'iso_3166_code' => 'th',
                'is_EEA' => 0,
                'currency_id' => 31,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //52
            [
                'name' => 'South Africa',
                'iso_3166_code' => 'za',
                'is_EEA' => 0,
                'currency_id' => 32,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //53
            [
                'name' => 'Israel',
                'iso_3166_code' => 'il',
                'is_EEA' => 0,
                'currency_id' => 33,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],
        ];

    }

    private function addExtraCountry()
    {
        return [//54
            [
                'name' => 'Afghanistan',
                'iso_3166_code' => 'af',
                'is_EEA' => 0,
                'currency_id' => 35,
                'user_id' => '1',
                'updated_user_id' => '1',
            ],

            //55
            [
                'name' => 'Albania',
                'iso_3166_code' => 'al',
                'is_EEA' => 0,
                'currency_id' => 36,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //56
            [
                'name' => 'Algeria',
                'iso_3166_code' => 'dz',
                'is_EEA' => 0,
                'currency_id' => 70,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //57
            [
                'name' => 'Andorra',
                'iso_3166_code' => 'dz',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //58
            [
                'name' => 'Angola',
                'iso_3166_code' => 'ao',
                'is_EEA' => 0,
                'currency_id' => 38,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //59
            [
                'name' => 'Antigua and Barbuda',
                'iso_3166_code' => 'ag',
                'is_EEA' => 0,
                'currency_id' => 165,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //60
            [
                'name' => 'Argentina',
                'iso_3166_code' => 'ar',
                'is_EEA' => 0,
                'currency_id' => 41,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //61
            [
                'name' => 'Armenia',
                'iso_3166_code' => 'am',
                'is_EEA' => 0,
                'currency_id' => 37,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //62
            [
                'name' => 'Aruba',
                'iso_3166_code' => 'aw',
                'is_EEA' => 0,
                'currency_id' => 42,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //63
            [
                'name' => 'Aruba',
                'iso_3166_code' => 'aw',
                'is_EEA' => 0,
                'currency_id' => 42,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //64
            [
                'name' => 'Azerbaijan',
                'iso_3166_code' => 'az',
                'is_EEA' => 0,
                'currency_id' => 43,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //65
            [
                'name' => 'Bahamas',
                'iso_3166_code' => 'bs',
                'is_EEA' => 0,
                'currency_id' => 52,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //66
            [
                'name' => 'Bahrain',
                'iso_3166_code' => 'bh',
                'is_EEA' => 0,
                'currency_id' => 46,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //67
            [
                'name' => 'Bangladesh',
                'iso_3166_code' => 'bd',
                'is_EEA' => 0,
                'currency_id' => 39,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //68
            [
                'name' => 'Barbados',
                'iso_3166_code' => 'bb',
                'is_EEA' => 0,
                'currency_id' => 45,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //69
            [
                'name' => 'Belarus',
                'iso_3166_code' => 'by',
                'is_EEA' => 0,
                'currency_id' => 55,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //70
            [
                'name' => 'Belize',
                'iso_3166_code' => 'bz',
                'is_EEA' => 0,
                'currency_id' => 56,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //71
            [
                'name' => 'Benin',
                'iso_3166_code' => 'bj',
                'is_EEA' => 0,
                'currency_id' => 164,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //72
            [
                'name' => 'Bermuda',
                'iso_3166_code' => 'bm',
                'is_EEA' => 0,
                'currency_id' => 48,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //73
            [
                'name' => 'Bhutan',
                'iso_3166_code' => 'bt',
                'is_EEA' => 0,
                'currency_id' => 53,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //74
            [
                'name' => 'Bolivia',
                'iso_3166_code' => 'bo',
                'is_EEA' => 0,
                'currency_id' => 51,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //75
            [
                'name' => 'Bosnia and Herzegovina',
                'iso_3166_code' => 'ba',
                'is_EEA' => 0,
                'currency_id' => 44,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //76
            [
                'name' => 'Botswana',
                'iso_3166_code' => 'bw',
                'is_EEA' => 0,
                'currency_id' => 54,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //77
            [
                'name' => 'Botswana',
                'iso_3166_code' => 'bw',
                'is_EEA' => 0,
                'currency_id' => 54,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //78
            [
                'name' => 'Brunei Darussalam',
                'iso_3166_code' => 'bn',
                'is_EEA' => 0,
                'currency_id' => 49,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],


            //79
            [
                'name' => 'Burkina Faso',
                'iso_3166_code' => 'bf',
                'is_EEA' => 0,
                'currency_id' => 164,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //80
            [
                'name' => 'Burundi',
                'iso_3166_code' => 'bi',
                'is_EEA' => 0,
                'currency_id' => 47,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //81
            [
                'name' => 'Cambodia',
                'iso_3166_code' => 'kh',
                'is_EEA' => 0,
                'currency_id' => 92,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //82
            [
                'name' => 'Cameroon',
                'iso_3166_code' => 'cm',
                'is_EEA' => 0,
                'currency_id' => 167,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //83
            [
                'name' => 'Cape Verde',
                'iso_3166_code' => 'cv',
                'is_EEA' => 0,
                'currency_id' => 67,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //84
            [
                'name' => 'Cayman Islands',
                'iso_3166_code' => 'ky',
                'is_EEA' => 0,
                'currency_id' => 96,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //85
            [
                'name' => 'Central African Republic',
                'iso_3166_code' => 'cf',
                'is_EEA' => 0,
                'currency_id' => 167,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //86
            [
                'name' => 'Chad',
                'iso_3166_code' => 'td',
                'is_EEA' => 0,
                'currency_id' => 167,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //87
            [
                'name' => 'Chile',
                'iso_3166_code' => 'cl',
                'is_EEA' => 0,
                'currency_id' => 61,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //88
            [
                'name' => 'Colombia',
                'iso_3166_code' => 'co',
                'is_EEA' => 0,
                'currency_id' => 62,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //89
            [
                'name' => 'Comoros',
                'iso_3166_code' => 'km',
                'is_EEA' => 0,
                'currency_id' => 93,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //90
            [
                'name' => 'Congo',
                'iso_3166_code' => 'cg',
                'is_EEA' => 0,
                'currency_id' => 167,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //91
            [
                'name' => 'Democratic Republic of Congo',
                'iso_3166_code' => 'cd',
                'is_EEA' => 0,
                'currency_id' => 57,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //92
            [
                'name' => 'Costa Rica',
                'iso_3166_code' => 'cr',
                'is_EEA' => 0,
                'currency_id' => 64,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //93
            [
                'name' => 'Côte d\'Ivoire',
                'iso_3166_code' => 'ci',
                'is_EEA' => 0,
                'currency_id' => 164,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //94
            [
                'name' => 'Cuba',
                'iso_3166_code' => 'cu',
                'is_EEA' => 0,
                'currency_id' => 66,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //95
            [
                'name' => 'Djibouti',
                'iso_3166_code' => 'dj',
                'is_EEA' => 0,
                'currency_id' => 68,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //96
            [
                'name' => 'Dominica',
                'iso_3166_code' => 'dm',
                'is_EEA' => 0,
                'currency_id' => 165,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //97
            [
                'name' => 'Dominican Republic',
                'iso_3166_code' => 'do',
                'is_EEA' => 0,
                'currency_id' => 69,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //98
            [
                'name' => 'Ecuador',
                'iso_3166_code' => 'ec',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //99
            [
                'name' => 'Egypt',
                'iso_3166_code' => 'eg',
                'is_EEA' => 0,
                'currency_id' => 71,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //100
            [
                'name' => 'El Salvador',
                'iso_3166_code' => 'sv',
                'is_EEA' => 0,
                'currency_id' => 139,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //101
            [
                'name' => 'Equatorial Guinea',
                'iso_3166_code' => 'gq',
                'is_EEA' => 0,
                'currency_id' => 167,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //102
            [
                'name' => 'Eritrea',
                'iso_3166_code' => 'er',
                'is_EEA' => 0,
                'currency_id' => 72,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //103
            [
                'name' => 'Ethiopia',
                'iso_3166_code' => 'et',
                'is_EEA' => 0,
                'currency_id' => 73,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //104
            [
                'name' => 'Falkland Islands',
                'iso_3166_code' => 'fk',
                'is_EEA' => 0,
                'currency_id' => 75,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //105
            [
                'name' => 'Faroe Islands',
                'iso_3166_code' => 'fo',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //106
            [
                'name' => 'Fiji',
                'iso_3166_code' => 'fj',
                'is_EEA' => 0,
                'currency_id' => 74,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],


            //107
            [
                'name' => 'French Guiana',
                'iso_3166_code' => 'gf',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //108
            [
                'name' => 'French Southern Territories',
                'iso_3166_code' => 'tf',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //109
            [
                'name' => 'Gabon',
                'iso_3166_code' => 'ga',
                'is_EEA' => 0,
                'currency_id' => 167,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //110
            [
                'name' => 'Gambia',
                'iso_3166_code' => 'gm',
                'is_EEA' => 0,
                'currency_id' => 79,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //111
            [
                'name' => 'Georgia',
                'iso_3166_code' => 'ge',
                'is_EEA' => 0,
                'currency_id' => 76,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //112
            [
                'name' => 'Ghana',
                'iso_3166_code' => 'gh',
                'is_EEA' => 0,
                'currency_id' => 77,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],


            //113
            [
                'name' => 'Gibraltar',
                'iso_3166_code' => 'gi',
                'is_EEA' => 0,
                'currency_id' => 78,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //114
            [
                'name' => 'Greenland',
                'iso_3166_code' => 'gl',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //115
            [
                'name' => 'Grenada',
                'iso_3166_code' => 'gd',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //116
            [
                'name' => 'Guadeloupe',
                'iso_3166_code' => 'gp',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //117
            [
                'name' => 'Guam',
                'iso_3166_code' => 'gu',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //118
            [
                'name' => 'Guatemala',
                'iso_3166_code' => 'gt',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //119
            [
                'name' => 'Guernsey',
                'iso_3166_code' => 'gg',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //120
            [
                'name' => 'Guinea',
                'iso_3166_code' => 'gn',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //121
            [
                'name' => 'Guinea-Bissau',
                'iso_3166_code' => 'gw',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //122
            [
                'name' => 'Guyana',
                'iso_3166_code' => 'gy',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //123
            [
                'name' => 'Haiti',
                'iso_3166_code' => 'gt',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //124
            [
                'name' => 'Heard Island and McDonald Islands',
                'iso_3166_code' => 'hm',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //125
            [
                'name' => 'Holy See (Vatican City State)',
                'iso_3166_code' => 'va',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //126
            [
                'name' => 'Honduras',
                'iso_3166_code' => 'hn',
                'is_EEA' => 0,
                'currency_id' => 82,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],


            //127
            [
                'name' => 'Indonesia',
                'iso_3166_code' => 'id',
                'is_EEA' => 0,
                'currency_id' => 24,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //128
            [
                'name' => 'Iran, Islamic Republic of',
                'iso_3166_code' => 'ir',
                'is_EEA' => 0,
                'currency_id' => 85,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //129
            [
                'name' => 'Iraq',
                'iso_3166_code' => 'iq',
                'is_EEA' => 0,
                'currency_id' => 84,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //130
            [
                'name' => 'Isle of Man',
                'iso_3166_code' => 'im',
                'is_EEA' => 0,
                'currency_id' => 14,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //131
            [
                'name' => 'Israel',
                'iso_3166_code' => 'il',
                'is_EEA' => 0,
                'currency_id' => 33,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //132
            [
                'name' => 'Jamaica',
                'iso_3166_code' => 'jm',
                'is_EEA' => 0,
                'currency_id' => 87,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //133
            [
                'name' => 'Jersey',
                'iso_3166_code' => 'je',
                'is_EEA' => 0,
                'currency_id' => 14,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //134
            [
                'name' => 'Jordan',
                'iso_3166_code' => 'jo',
                'is_EEA' => 0,
                'currency_id' => 88,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //135
            [
                'name' => 'Kazakhstan',
                'iso_3166_code' => 'kz',
                'is_EEA' => 0,
                'currency_id' => 97,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //136
            [
                'name' => 'Kenya',
                'iso_3166_code' => 'ke',
                'is_EEA' => 0,
                'currency_id' => 90,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //137
            [
                'name' => 'Kiribati',
                'iso_3166_code' => 'ki',
                'is_EEA' => 0,
                'currency_id' => 18,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //138
            [
                'name' => 'Korea, Democratic People\'s Republic of',
                'iso_3166_code' => 'kp',
                'is_EEA' => 0,
                'currency_id' => 94,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //139
            [
                'name' => 'Korea, Republic of',
                'iso_3166_code' => 'kr',
                'is_EEA' => 0,
                'currency_id' => 25,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //140
            [
                'name' => 'Kuait',
                'iso_3166_code' => 'kw',
                'is_EEA' => 0,
                'currency_id' => 95,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //141
            [
                'name' => 'Kyrgyzstan',
                'iso_3166_code' => 'kg',
                'is_EEA' => 0,
                'currency_id' => 91,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //142
            [
                'name' => 'Lao People\'s Democratic Republic',
                'iso_3166_code' => 'la',
                'is_EEA' => 0,
                'currency_id' => 98,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //143
            [
                'name' => 'Lebanon',
                'iso_3166_code' => 'lb',
                'is_EEA' => 0,
                'currency_id' => 99,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //144
            [
                'name' => 'Lesotho',
                'iso_3166_code' => 'ls',
                'is_EEA' => 0,
                'currency_id' => 102,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //145
            [
                'name' => 'Liberia',
                'iso_3166_code' => 'lr',
                'is_EEA' => 0,
                'currency_id' => 101,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //146
            [
                'name' => 'Libya',
                'iso_3166_code' => 'ly',
                'is_EEA' => 0,
                'currency_id' => 103,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //147
            [
                'name' => 'Macao',
                'iso_3166_code' => 'mo',
                'is_EEA' => 0,
                'currency_id' => 110,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //148
            [
                'name' => 'Macedonia, the Former Yugoslav Republic of',
                'iso_3166_code' => 'mk',
                'is_EEA' => 0,
                'currency_id' => 107,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //149
            [
                'name' => 'Madagascar',
                'iso_3166_code' => 'mg',
                'is_EEA' => 0,
                'currency_id' => 106,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //150
            [
                'name' => 'Malawi',
                'iso_3166_code' => 'mw',
                'is_EEA' => 0,
                'currency_id' => 114,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //151
            [
                'name' => 'Maldives',
                'iso_3166_code' => 'mv',
                'is_EEA' => 0,
                'currency_id' => 113,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //152
            [
                'name' => 'Mali',
                'iso_3166_code' => 'ml',
                'is_EEA' => 0,
                'currency_id' => 164,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //153
            [
                'name' => 'Marshall Islands',
                'iso_3166_code' => 'mh',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //154
            [
                'name' => 'Martinique',
                'iso_3166_code' => 'mq',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //155
            [
                'name' => 'Mauritania',
                'iso_3166_code' => 'mr',
                'is_EEA' => 0,
                'currency_id' => 111,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //156
            [
                'name' => 'Mauritius',
                'iso_3166_code' => 'mu',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //157
            [
                'name' => 'Mayotte',
                'iso_3166_code' => 'yt',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //158
            [
                'name' => 'Micronesia, Federated States of',
                'iso_3166_code' => 'fm',
                'is_EEA' => 0,
                'currency_id' => 12,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //159
            [
                'name' => 'Moldova, Republic of',
                'iso_3166_code' => 'md',
                'is_EEA' => 0,
                'currency_id' => 112,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //160
            [
                'name' => 'Monaco',
                'iso_3166_code' => 'mc',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //161
            [
                'name' => 'Mongolia',
                'iso_3166_code' => 'mn',
                'is_EEA' => 0,
                'currency_id' => 109,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //162
            [
                'name' => 'Montenegro',
                'iso_3166_code' => 'me',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //163
            [
                'name' => 'Montserrat',
                'iso_3166_code' => 'ms',
                'is_EEA' => 0,
                'currency_id' => 165,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //164
            [
                'name' => 'Morocco',
                'iso_3166_code' => 'ma',
                'is_EEA' => 0,
                'currency_id' => 104,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //165
            [
                'name' => 'Mozambique',
                'iso_3166_code' => 'mz',
                'is_EEA' => 0,
                'currency_id' => 116,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //166
            [
                'name' => 'Myanmar',
                'iso_3166_code' => 'mm',
                'is_EEA' => 0,
                'currency_id' => 108,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //167
            [
                'name' => 'Namibia',
                'iso_3166_code' => 'na',
                'is_EEA' => 0,
                'currency_id' => 117,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //168
            [
                'name' => 'Nauru',
                'iso_3166_code' => 'nr',
                'is_EEA' => 0,
                'currency_id' => 18,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //169
            [
                'name' => 'Nepal',
                'iso_3166_code' => 'np',
                'is_EEA' => 0,
                'currency_id' => 120,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],


            //170
            [
                'name' => 'Nicaragua',
                'iso_3166_code' => 'ni',
                'is_EEA' => 0,
                'currency_id' => 119,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //171
            [
                'name' => 'Niger',
                'iso_3166_code' => 'ne',
                'is_EEA' => 0,
                'currency_id' => 164,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //172
            [
                'name' => 'Nigeria',
                'iso_3166_code' => 'ng',
                'is_EEA' => 0,
                'currency_id' => 118,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //173
            [
                'name' => 'Niue',
                'iso_3166_code' => 'nu',
                'is_EEA' => 0,
                'currency_id' => 28,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //174
            [
                'name' => 'Norfolk Island',
                'iso_3166_code' => 'nf',
                'is_EEA' => 0,
                'currency_id' => 18,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //175
            [
                'name' => 'Northern Mariana Islands',
                'iso_3166_code' => 'mp',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //176
            [
                'name' => 'Oman',
                'iso_3166_code' => 'om',
                'is_EEA' => 0,
                'currency_id' => 121,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //177
            [
                'name' => 'Pakistan',
                'iso_3166_code' => 'pk',
                'is_EEA' => 0,
                'currency_id' => 125,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //178
            [
                'name' => 'Palau',
                'iso_3166_code' => 'pw',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //179
            [
                'name' => 'Palestine, State of',
                'iso_3166_code' => 'ps',
                'is_EEA' => 0,
                'currency_id' => 33,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //180
            [
                'name' => 'Panama',
                'iso_3166_code' => 'pa',
                'is_EEA' => 0,
                'currency_id' => 122,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //181
            [
                'name' => 'Papua New Guinea',
                'iso_3166_code' => 'pg',
                'is_EEA' => 0,
                'currency_id' => 124,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //182
            [
                'name' => 'Paraguay',
                'iso_3166_code' => 'py',
                'is_EEA' => 0,
                'currency_id' => 126,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //183
            [
                'name' => 'Peru',
                'iso_3166_code' => 'pe',
                'is_EEA' => 0,
                'currency_id' => 123,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //184
            [
                'name' => 'Philippines',
                'iso_3166_code' => 'ph',
                'is_EEA' => 0,
                'currency_id' => 29,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //185
            [
                'name' => 'Pitcairn',
                'iso_3166_code' => 'pn',
                'is_EEA' => 0,
                'currency_id' => 28,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //186
            [
                'name' => 'Puerto Rico',
                'iso_3166_code' => 'pr',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //187
            [
                'name' => 'Qatar',
                'iso_3166_code' => 'qa',
                'is_EEA' => 0,
                'currency_id' => 127,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //188
            [
                'name' => 'Réunion',
                'iso_3166_code' => 're',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //189
            [
                'name' => 'Russian Federation',
                'iso_3166_code' => 'ru',
                'is_EEA' => 0,
                'currency_id' => 3,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //190
            [
                'name' => 'Rwanda',
                'iso_3166_code' => 'rw',
                'is_EEA' => 0,
                'currency_id' => 129,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //191
            [
                'name' => 'Saint Barthélemy',
                'iso_3166_code' => 'rl',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //192
            [
                'name' => 'Saint Helena, Ascension and Tristan da Cunha',
                'iso_3166_code' => 'sh',
                'is_EEA' => 0,
                'currency_id' => 134,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //193
            [
                'name' => 'Saint Kitts and Nevis',
                'iso_3166_code' => 'kn',
                'is_EEA' => 0,
                'currency_id' => 165,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //194
            [
                'name' => 'Saint Lucia',
                'iso_3166_code' => 'lc',
                'is_EEA' => 0,
                'currency_id' => 165,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //195
            [
                'name' => 'Saint Martin (French part)',
                'iso_3166_code' => 'mf',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //196
            [
                'name' => 'Saint Pierre and Miquelon',
                'iso_3166_code' => 'pm',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //197
            [
                'name' => 'Saint Vincent and the Grenadines',
                'iso_3166_code' => 'vc',
                'is_EEA' => 0,
                'currency_id' => 165,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //198
            [
                'name' => 'Samoa',
                'iso_3166_code' => 'ws',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //199
            [
                'name' => 'San Marino',
                'iso_3166_code' => 'sm',
                'is_EEA' => 0,
                'currency_id' => 1,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //200
            [
                'name' => 'Sao Tome and Principe',
                'iso_3166_code' => 'st',
                'is_EEA' => 0,
                'currency_id' => 138,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //201
            [
                'name' => 'Saudi Arabia',
                'iso_3166_code' => 'sa',
                'is_EEA' => 0,
                'currency_id' => 130,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //202
            [
                'name' => 'Senegal',
                'iso_3166_code' => 'sn',
                'is_EEA' => 0,
                'currency_id' => 164,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //203
            [
                'name' => 'Serbia',
                'iso_3166_code' => 'rs',
                'is_EEA' => 0,
                'currency_id' => 128,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //204
            [
                'name' => 'Seychelles',
                'iso_3166_code' => 'sc',
                'is_EEA' => 0,
                'currency_id' => 132,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //205
            [
                'name' => 'Sierra Leone',
                'iso_3166_code' => 'sl',
                'is_EEA' => 0,
                'currency_id' => 135,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //206
            [
                'name' => 'Singapore',
                'iso_3166_code' => 'sg',
                'is_EEA' => 0,
                'currency_id' => 30,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //207
            [
                'name' => 'Sint Maarten (Dutch part)',
                'iso_3166_code' => 'sx',
                'is_EEA' => 0,
                'currency_id' => 40,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //208
            [
                'name' => 'Solomon Islands',
                'iso_3166_code' => 'sb',
                'is_EEA' => 0,
                'currency_id' => 131,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //209
            [
                'name' => 'Somalia',
                'iso_3166_code' => 'so',
                'is_EEA' => 0,
                'currency_id' => 136,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //210
            [
                'name' => 'South Africa',
                'iso_3166_code' => 'sz',
                'is_EEA' => 0,
                'currency_id' => 32,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //211
            [
                'name' => 'South Georgia and the South Sandwich Islands',
                'iso_3166_code' => 'gs',
                'is_EEA' => 0,
                'currency_id' => 14,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //212
            [
                'name' => 'South Sudan',
                'iso_3166_code' => 'ss',
                'is_EEA' => 0,
                'currency_id' => 166,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //213
            [
                'name' => 'Sri Lanka',
                'iso_3166_code' => 'lk',
                'is_EEA' => 0,
                'currency_id' => 100,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //214
            [
                'name' => 'Sudan',
                'iso_3166_code' => 'sd',
                'is_EEA' => 0,
                'currency_id' => 133,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //215
            [
                'name' => 'Suriname',
                'iso_3166_code' => 'sr',
                'is_EEA' => 0,
                'currency_id' => 137,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //216
            [
                'name' => 'Svalbard and Jan Mayen',
                'iso_3166_code' => 'sj',
                'is_EEA' => 0,
                'currency_id' => 5,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //217
            [
                'name' => 'Swaziland',
                'iso_3166_code' => 'sz',
                'is_EEA' => 0,
                'currency_id' => 141,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //218
            [
                'name' => 'Syrian Arab Republic',
                'iso_3166_code' => 'sy',
                'is_EEA' => 0,
                'currency_id' => 140,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //219
            [
                'name' => 'Taiwan, Province of China',
                'iso_3166_code' => 'tw',
                'is_EEA' => 0,
                'currency_id' => 147,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //220
            [
                'name' => 'Tajikistan',
                'iso_3166_code' => 'tj',
                'is_EEA' => 0,
                'currency_id' => 142,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //221
            [
                'name' => 'Tanzania, United Republic of',
                'iso_3166_code' => 'tz',
                'is_EEA' => 0,
                'currency_id' => 148,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //222
            [
                'name' => 'Thailand',
                'iso_3166_code' => 'th',
                'is_EEA' => 0,
                'currency_id' => 31,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //223
            [
                'name' => 'Timor-Leste',
                'iso_3166_code' => 'tl',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //224
            [
                'name' => 'Togo',
                'iso_3166_code' => 'tg',
                'is_EEA' => 0,
                'currency_id' => 164,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //225
            [
                'name' => 'Tokelau',
                'iso_3166_code' => 'tk',
                'is_EEA' => 0,
                'currency_id' => 28,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //226
            [
                'name' => 'Tonga',
                'iso_3166_code' => 'to',
                'is_EEA' => 0,
                'currency_id' => 145,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //227
            [
                'name' => 'Trinidad and Tobago',
                'iso_3166_code' => 'tt',
                'is_EEA' => 0,
                'currency_id' => 146,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //228
            [
                'name' => 'Tunisia',
                'iso_3166_code' => 'tn',
                'is_EEA' => 0,
                'currency_id' => 144,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //229
            [
                'name' => 'Turkmenistan',
                'iso_3166_code' => 'tm',
                'is_EEA' => 0,
                'currency_id' => 143,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //230
            [
                'name' => 'Turks and Caicos Islands',
                'iso_3166_code' => 'tc',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //231
            [
                'name' => 'Tuvalu',
                'iso_3166_code' => 'tv',
                'is_EEA' => 0,
                'currency_id' => 18,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //232
            [
                'name' => 'Uganda',
                'iso_3166_code' => 'ug',
                'is_EEA' => 0,
                'currency_id' => 150,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //233
            [
                'name' => 'Ukraine',
                'iso_3166_code' => 'ua',
                'is_EEA' => 0,
                'currency_id' => 149,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //234
            [
                'name' => 'United States Minor Outlying Islands',
                'iso_3166_code' => 'um',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //235
            [
                'name' => 'Uruguay',
                'iso_3166_code' => 'uy',
                'is_EEA' => 0,
                'currency_id' => 153,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //236
            [
                'name' => 'Uzbekistan',
                'iso_3166_code' => 'uz',
                'is_EEA' => 0,
                'currency_id' => 155,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //237
            [
                'name' => 'Vanuatu',
                'iso_3166_code' => 'vu',
                'is_EEA' => 0,
                'currency_id' => 158,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //238
            [
                'name' => 'Venezuela, Bolivarian Republic of',
                'iso_3166_code' => 've',
                'is_EEA' => 0,
                'currency_id' => 156,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //239
            [
                'name' => 'Vietnam',
                'iso_3166_code' => 'vn',
                'is_EEA' => 0,
                'currency_id' => 157,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //240
            [
                'name' => 'Virgin Islands, British',
                'iso_3166_code' => 'vg',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //241
            [
                'name' => 'Virgin Islands, U.S.',
                'iso_3166_code' => 'vi',
                'is_EEA' => 0,
                'currency_id' => 2,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],


            //242
            [
                'name' => 'Western Sahara',
                'iso_3166_code' => 'eh',
                'is_EEA' => 0,
                'currency_id' => 104,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //243
            [
                'name' => 'Yemen',
                'iso_3166_code' => 'ye',
                'is_EEA' => 0,
                'currency_id' => 160,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //244
            [
                'name' => 'Zambia',
                'iso_3166_code' => 'zm',
                'is_EEA' => 0,
                'currency_id' => 161,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],

            //245
            [
                'name' => 'Zimbabwe',
                'iso_3166_code' => 'zw',
                'is_EEA' => 0,
                'currency_id' => 162,
                'user_id' => 1,
                'updated_user_id' => 1,
            ],
        ];
    }

    private function addToDataBase($countriesArray)
    {
        foreach($countriesArray as $country)
            Country ::create($country);
    }
}
