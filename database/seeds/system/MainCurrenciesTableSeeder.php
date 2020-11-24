<?php

namespace Seeds\System;

use App\Zen\System\Model\MainCurrency as Currency;
use Illuminate\Database\Seeder;

class MainCurrenciesTableSeeder extends Seeder
{

    public
    function run()
    {
        Currency ::truncate();

        //1
        Currency ::create([
            'iso_4217_code' => 'EUR',
            'iso_3166_code' => 'europeanunion',
            'iso_number' => '978',
            'currency_name' => 'Euro',
            'active_status' => '1',
        ]);
        //2
        Currency ::create([
            'iso_4217_code' => 'USD',
            'iso_3166_code' => 'us',
            'iso_number' => '840',
            'currency_name' => 'United States dollar',
            'active_status' => '1',
        ]);
        //3
        Currency ::create([
            'iso_4217_code' => 'RUB',
            'iso_3166_code' => 'ru',
            'iso_number' => '643',
            'currency_name' => 'Russian ruble',
            'active_status' => '0',
        ]);
        //4
        Currency ::create([
            'iso_4217_code' => 'CHF',
            'iso_3166_code' => 'ch',
            'iso_number' => '756',
            'currency_name' => 'Swiss franc',
            'active_status' => '0',
        ]);
        //5
        Currency ::create([
            'iso_4217_code' => 'NOK',
            'iso_3166_code' => 'no',
            'iso_number' => '578',
            'currency_name' => 'Norwegian krone',
            'active_status' => '0',
        ]);
        //6
        Currency ::create([
            'iso_4217_code' => 'SEK',
            'iso_3166_code' => 'se',
            'iso_number' => '752',
            'currency_name' => 'Swedish krona',
            'active_status' => '0',
        ]);
        //7
        Currency ::create([
            'iso_4217_code' => 'PLN',
            'iso_3166_code' => 'pl',
            'iso_number' => '985',
            'currency_name' => 'Polish sloty',
            'active_status' => '0',
        ]);
        //8
        Currency ::create([
            'iso_4217_code' => 'RON',
            'iso_3166_code' => 'ro',
            'iso_number' => '946',
            'currency_name' => 'Romanian leu',
            'active_status' => '0',
        ]);

        //9
        Currency ::create([
            'iso_4217_code' => 'BGN',
            'iso_3166_code' => 'bg',
            'iso_number' => '975',
            'currency_name' => 'Bulgarian lev',
            'active_status' => '0',
        ]);

        //10
        Currency ::create([
            'iso_4217_code' => 'HRK',
            'iso_3166_code' => 'hr',
            'iso_number' => '191',
            'currency_name' => 'Croatian kuna', 'active_status' => '0',]);

        //11
        Currency ::create([
            'iso_4217_code' => 'CZK',
            'iso_3166_code' => 'cz',
            'iso_number' => '203',
            'currency_name' => 'Czech koruna',
            'active_status' => '0',
        ]);
        //12
        Currency ::create([
            'iso_4217_code' => 'DKK',
            'iso_3166_code' => 'dk',
            'iso_number' => '208',
            'currency_name' => 'Danish krone',
            'active_status' => '0',
        ]);

        //13
        Currency ::create([
            'iso_4217_code' => 'HUF',
            'iso_3166_code' => 'hu',
            'iso_number' => '348',
            'currency_name' => 'Hungarian forint',
            'active_status' => '0',
        ]);

        //14
        Currency ::create([
            'iso_4217_code' => 'GBP',
            'iso_3166_code' => 'gb',
            'iso_number' => '826',
            'currency_name' => 'Pound sterling',
            'active_status' => '0',
        ]);

        //15
        Currency ::create([
            'iso_4217_code' => 'ISK',
            'iso_3166_code' => 'is',
            'iso_number' => '352',
            'currency_name' => 'Icelandic króna',
            'active_status' => '0',
        ]);

        //16
        Currency ::create([
            'iso_4217_code' => 'JPY',
            'iso_3166_code' => 'jp',
            'iso_number' => '392',
            'currency_name' => 'Japanese yen',
            'active_status' => '0',
        ]);

        //17
        Currency ::create([
            'iso_4217_code' => 'TRY',
            'iso_3166_code' => 'tr',
            'iso_number' => '949',
            'currency_name' => 'Turkish lira',
            'active_status' => '0',
        ]);

        //18
        Currency ::create([
            'iso_4217_code' => 'AUD',
            'iso_3166_code' => 'au',
            'iso_number' => '036',
            'currency_name' => 'Australian dollar',
            'active_status' => '0',
        ]);

        //19
        Currency ::create([
            'iso_4217_code' => 'BRL',
            'iso_3166_code' => 'br',
            'iso_number' => '986',
            'currency_name' => 'Brazilian real',
            'active_status' => '0',
        ]);

        //20
        Currency ::create([
            'iso_4217_code' => 'CAD',
            'iso_3166_code' => 'ca',
            'iso_number' => '124',
            'currency_name' => 'Canadian dollar',
            'active_status' => '0',
        ]);

        //21
        Currency ::create([
            'iso_4217_code' => 'CNY',
            'iso_3166_code' => 'cn',
            'iso_number' => '156',
            'currency_name' => 'Chinese yuan',
            'active_status' => '0',
        ]);

        //22
        Currency ::create([
            'iso_4217_code' => 'HKD',
            'iso_3166_code' => 'hk',
            'iso_number' => '344',
            'currency_name' => 'Hong Kong dollar',
            'active_status' => '0',
        ]);

        //23
        Currency ::create([
            'iso_4217_code' => 'INR',
            'iso_3166_code' => 'in',
            'iso_number' => '356',
            'currency_name' => 'Indian rupee',
            'active_status' => '0',
        ]);

        //24
        Currency ::create([
            'iso_4217_code' => 'IDR',
            'iso_3166_code' => 'id',
            'iso_number' => '360',
            'currency_name' => 'Indonesian rupiah',
            'active_status' => '0',
        ]);

        //25
        Currency ::create([
            'iso_4217_code' => 'KRW',
            'iso_3166_code' => 'kr',
            'iso_number' => '410',
            'currency_name' => 'South Korean won',
            'active_status' => '0',
        ]);

        //26
        Currency ::create([
            'iso_4217_code' => 'MXN',
            'iso_3166_code' => 'mx',
            'iso_number' => '484',
            'currency_name' => 'Mexican peso',
            'active_status' => '0',
        ]);

        //27
        Currency ::create([
            'iso_4217_code' => 'MYR',
            'iso_3166_code' => 'my',
            'iso_number' => '458',
            'currency_name' => 'Malaysian ringgit',
            'active_status' => '0',
        ]);

        //28
        Currency ::create([
            'iso_4217_code' => 'NZD',
            'iso_3166_code' => 'nz',
            'iso_number' => '554',
            'currency_name' => 'New Zealand dollar',
            'active_status' => '0',
        ]);

        //29
        Currency ::create([
            'iso_4217_code' => 'PHP',
            'iso_3166_code' => 'ph',
            'iso_number' => '608',
            'currency_name' => 'Philippine peso',
            'active_status' => '0',
        ]);

        //30
        Currency ::create([
            'iso_4217_code' => 'SGD',
            'iso_3166_code' => 'sg',
            'iso_number' => '702',
            'currency_name' => 'Singapore dollar',
            'active_status' => '0',
        ]);

        //31
        Currency ::create([
            'iso_4217_code' => 'THB',
            'iso_3166_code' => 'th',
            'iso_number' => '764',
            'currency_name' => 'Thai baht',
            'active_status' => '0',
        ]);

        //32
        Currency ::create([
            'iso_4217_code' => 'ZAR',
            'iso_3166_code' => 'za',
            'iso_number' => '710',
            'currency_name' => 'South African rand',
            'active_status' => '0',
        ]);

        //33
        Currency ::create([
            'iso_4217_code' => 'ILS',
            'iso_3166_code' => 'il',
            'iso_number' => '376',
            'currency_name' => 'Israeli new shekel',
            'active_status' => '0',
        ]);

        //34
        Currency ::create([
            'iso_4217_code' => 'AED',
            'iso_3166_code' => 'ae',
            'iso_number' => '784',
            'currency_name' => 'United Arab Emirates dirham',
            'active_status' => '0',
        ]);

        //35
        Currency ::create([
            'iso_4217_code' => 'AFN',
            'iso_3166_code' => 'af',
            'iso_number' => '784',
            'currency_name' => 'Afghan afghani',
            'active_status' => '0',
        ]);

        //36
        Currency ::create([
            'iso_4217_code' => 'ALL',
            'iso_3166_code' => 'al',
            'iso_number' => '008',
            'currency_name' => 'Albanian lek',
            'active_status' => '0',
        ]);

        //37
        Currency ::create([
            'iso_4217_code' => 'AMD',
            'iso_3166_code' => 'am',
            'iso_number' => '051',
            'currency_name' => 'Armenian dram',
            'active_status' => '0',
        ]);

        //38
        Currency ::create([
            'iso_4217_code' => 'AOA',
            'iso_3166_code' => 'ao',
            'iso_number' => '973',
            'currency_name' => 'Angolan kwanza',
            'active_status' => '0',
        ]);

        //39
        Currency ::create([
            'iso_4217_code' => 'BDT',
            'iso_3166_code' => 'bd',
            'iso_number' => '050',
            'currency_name' => 'Taka',
            'active_status' => '0',
        ]);

        //40
        Currency ::create([
            'iso_4217_code' => 'ANG',
            'iso_3166_code' => 'an',
            'iso_number' => '532',
            'currency_name' => 'Netherlands Antillean Guilder',
            'active_status' => '0',
        ]);

        //41
        Currency ::create([
            'iso_4217_code' => 'ARS',
            'iso_3166_code' => 'ar',
            'iso_number' => '032',
            'currency_name' => 'Argentine Peso',
            'active_status' => '0',
        ]);

        //42
        Currency ::create([
            'iso_4217_code' => 'AWG',
            'iso_3166_code' => 'aw',
            'iso_number' => '533',
            'currency_name' => 'Aruban Florin',
            'active_status' => '0',
        ]);

        //43
        Currency ::create([
            'iso_4217_code' => 'AZN',
            'iso_3166_code' => 'az',
            'iso_number' => '944',
            'currency_name' => 'Azerbaijan Manat',
            'active_status' => '0',
        ]);

        //44
        Currency ::create([
            'iso_4217_code' => 'BAM',
            'iso_3166_code' => 'ba',
            'iso_number' => '977',
            'currency_name' => 'Convertible Mark',
            'active_status' => '0',
        ]);

        //45
        Currency ::create([
            'iso_4217_code' => 'BBD',
            'iso_3166_code' => 'bb',
            'iso_number' => '052',
            'currency_name' => 'Barbados Dollar',
            'active_status' => '0',
        ]);

        //46
        Currency ::create([
            'iso_4217_code' => 'BHD',
            'iso_3166_code' => 'bh',
            'iso_number' => '048',
            'currency_name' => 'Bahraini Dinar',
            'active_status' => '0',
        ]);

        //47
        Currency ::create([
            'iso_4217_code' => 'BIF',
            'iso_3166_code' => 'bi',
            'iso_number' => '108',
            'currency_name' => 'Burundi Franc',
            'active_status' => '0',
        ]);

        //48
        Currency ::create([
            'iso_4217_code' => 'BMD',
            'iso_3166_code' => 'bm',
            'iso_number' => '060',
            'currency_name' => 'Bermudian Dollar',
            'active_status' => '0',
        ]);

        //49
        Currency ::create([
            'iso_4217_code' => 'BND',
            'iso_3166_code' => 'bn',
            'iso_number' => '096',
            'currency_name' => 'Brunei Dollar',
            'active_status' => '0',
        ]);

        //50
        Currency ::create([
            'iso_4217_code' => 'BOB',
            'iso_3166_code' => 'bo',
            'iso_number' => '068',
            'currency_name' => 'Boliviano',
            'active_status' => '0',
        ]);

        //51
        Currency ::create([
            'iso_4217_code' => 'BOV',
            'iso_3166_code' => 'bo',
            'iso_number' => '984',
            'currency_name' => 'Mvdol',
            'active_status' => '0',
        ]);

        //52
        Currency ::create([
            'iso_4217_code' => 'BSD',
            'iso_3166_code' => 'bs',
            'iso_number' => '044',
            'currency_name' => 'Bahamian Dollar',
            'active_status' => '0',
        ]);

        //53
        Currency ::create([
            'iso_4217_code' => 'BTN',
            'iso_3166_code' => 'bt',
            'iso_number' => '064',
            'currency_name' => 'Ngultrum',
            'active_status' => '0',
        ]);

        //54
        Currency ::create([
            'iso_4217_code' => 'BWP',
            'iso_3166_code' => 'bw',
            'iso_number' => '072',
            'currency_name' => 'Pula',
            'active_status' => '0',
        ]);

        //55
        Currency ::create([
            'iso_4217_code' => 'BYN',
            'iso_3166_code' => 'by',
            'iso_number' => '933',
            'currency_name' => 'Belarusian Ruble',
            'active_status' => '0',
        ]);

        //56
        Currency ::create([
            'iso_4217_code' => 'BZD',
            'iso_3166_code' => 'bz',
            'iso_number' => '084',
            'currency_name' => 'Belize Dollar',
            'active_status' => '0',
        ]);

        //57
        Currency ::create([
            'iso_4217_code' => 'CDF',
            'iso_3166_code' => 'cd',
            'iso_number' => '976',
            'currency_name' => 'Congolese Franc',
            'active_status' => '0',
        ]);

        //58
        Currency ::create([
            'iso_4217_code' => 'CHE',
            'iso_3166_code' => 'ch',
            'iso_number' => '947',
            'currency_name' => 'WIR Euro',
            'active_status' => '0',
        ]);

        //59
        Currency ::create([
            'iso_4217_code' => 'CHW',
            'iso_3166_code' => 'ch',
            'iso_number' => '948',
            'currency_name' => 'WIR Franc',
            'active_status' => '0',
        ]);

        //60
        Currency ::create([
            'iso_4217_code' => 'CLF',
            'iso_3166_code' => 'cl',
            'iso_number' => '990',
            'currency_name' => 'Unidad de Fomento',
            'active_status' => '0',
        ]);

        //61
        Currency ::create([
            'iso_4217_code' => 'CLP',
            'iso_3166_code' => 'cl',
            'iso_number' => '152',
            'currency_name' => 'Chilean Peso',
            'active_status' => '0',
        ]);

        //62
        Currency ::create([
            'iso_4217_code' => 'COP',
            'iso_3166_code' => 'co',
            'iso_number' => '170',
            'currency_name' => 'Colombian Peso',
            'active_status' => '0',
        ]);

        //63
        Currency ::create([
            'iso_4217_code' => 'COU',
            'iso_3166_code' => 'co',
            'iso_number' => '970',
            'currency_name' => 'Unidad de Valor Real',
            'active_status' => '0',
        ]);

        //64
        Currency ::create([
            'iso_4217_code' => 'CRC',
            'iso_3166_code' => 'cr',
            'iso_number' => '188',
            'currency_name' => 'Costa Rican Colon',
            'active_status' => '0',
        ]);

        //65
        Currency ::create([
            'iso_4217_code' => 'CUC',
            'iso_3166_code' => 'cu',
            'iso_number' => '931',
            'currency_name' => 'Peso Convertible',
            'active_status' => '0',
        ]);

        //66
        Currency ::create([
            'iso_4217_code' => 'CUP',
            'iso_3166_code' => 'cu',
            'iso_number' => '192',
            'currency_name' => 'Cuban Peso',
            'active_status' => '0',
        ]);

        //67
        Currency ::create([
            'iso_4217_code' => 'CVE',
            'iso_3166_code' => 'cv',
            'iso_number' => '132',
            'currency_name' => 'Cabo Verde Escudo',
            'active_status' => '0',
        ]);

        //68
        Currency ::create([
            'iso_4217_code' => 'DJF',
            'iso_3166_code' => 'dj',
            'iso_number' => '262',
            'currency_name' => 'Djibouti Franc',
            'active_status' => '0',
        ]);

        //69
        Currency ::create([
            'iso_4217_code' => 'DOP',
            'iso_3166_code' => 'do',
            'iso_number' => '214',
            'currency_name' => 'Dominican Peso',
            'active_status' => '0',
        ]);

        //70
        Currency ::create([
            'iso_4217_code' => 'DZD',
            'iso_3166_code' => 'dz',
            'iso_number' => '012',
            'currency_name' => 'Algerian Dinar',
            'active_status' => '0',
        ]);

        //71
        Currency ::create([
            'iso_4217_code' => 'EGP',
            'iso_3166_code' => 'eg',
            'iso_number' => '818',
            'currency_name' => 'Egyptian Pound',
            'active_status' => '0',
        ]);

        //72
        Currency ::create([
            'iso_4217_code' => 'ERN',
            'iso_3166_code' => 'er',
            'iso_number' => '232',
            'currency_name' => 'Nakfa',
            'active_status' => '0',
        ]);

        //73
        Currency ::create([
            'iso_4217_code' => 'ETB',
            'iso_3166_code' => 'et',
            'iso_number' => '230',
            'currency_name' => 'Ethiopian Birr',
            'active_status' => '0',
        ]);

        //74
        Currency ::create([
            'iso_4217_code' => 'FJD',
            'iso_3166_code' => 'fj',
            'iso_number' => '242',
            'currency_name' => 'Fiji Dollar',
            'active_status' => '0',
        ]);

        //75
        Currency ::create([
            'iso_4217_code' => 'FKP',
            'iso_3166_code' => 'fk',
            'iso_number' => '238',
            'currency_name' => 'Falkland Islands Pound',
            'active_status' => '0',
        ]);

        //76
        Currency ::create([
            'iso_4217_code' => 'GEL',
            'iso_3166_code' => 'ge',
            'iso_number' => '981',
            'currency_name' => 'Lari',
            'active_status' => '0',
        ]);

        //77
        Currency ::create([
            'iso_4217_code' => 'GHS',
            'iso_3166_code' => 'gh',
            'iso_number' => '936',
            'currency_name' => 'Ghana Cedi',
            'active_status' => '0',
        ]);

        //78
        Currency ::create([
            'iso_4217_code' => 'GIP',
            'iso_3166_code' => 'gi',
            'iso_number' => '292',
            'currency_name' => 'Gibraltar Pound',
            'active_status' => '0',
        ]);

        //79
        Currency ::create([
            'iso_4217_code' => 'GMD',
            'iso_3166_code' => 'gm',
            'iso_number' => '270',
            'currency_name' => 'Dalasi',
            'active_status' => '0',
        ]);

        //80
        Currency ::create([
            'iso_4217_code' => 'GNF',
            'iso_3166_code' => 'gn',
            'iso_number' => '324',
            'currency_name' => 'Guinean Franc',
            'active_status' => '0',
        ]);

        //81
        Currency ::create([
            'iso_4217_code' => 'GTQ',
            'iso_3166_code' => 'gt',
            'iso_number' => '320',
            'currency_name' => 'Quetzal',
            'active_status' => '0',
        ]);

        //82
        Currency ::create([
            'iso_4217_code' => 'HNL',
            'iso_3166_code' => 'hn',
            'iso_number' => '340',
            'currency_name' => 'Lempira',
            'active_status' => '0',
        ]);

        //83
        Currency ::create([
            'iso_4217_code' => 'HTG',
            'iso_3166_code' => 'ht',
            'iso_number' => '332',
            'currency_name' => 'Gourde',
            'active_status' => '0',
        ]);

        //84
        Currency ::create([
            'iso_4217_code' => 'IQD',
            'iso_3166_code' => 'iq',
            'iso_number' => '368',
            'currency_name' => 'Iraqi Dinar',
            'active_status' => '0',
        ]);

        //85
        Currency ::create([
            'iso_4217_code' => 'IRR',
            'iso_3166_code' => 'ir',
            'iso_number' => '364',
            'currency_name' => 'Iranian Rial',
            'active_status' => '0',
        ]);

        //86
        Currency ::create([
            'iso_4217_code' => 'ISKX',
            'iso_3166_code' => 'isX',
            'iso_number' => '352',
            'currency_name' => 'Iceland Krona Doubled',
            'active_status' => '0',
        ]);

        //87
        Currency ::create([
            'iso_4217_code' => 'JMD',
            'iso_3166_code' => 'jm',
            'iso_number' => '388',
            'currency_name' => 'Jamaican Dollar',
            'active_status' => '0',
        ]);

        //88
        Currency ::create([
            'iso_4217_code' => 'JOD',
            'iso_3166_code' => 'jo',
            'iso_number' => '400',
            'currency_name' => 'Jordanian Dinar',
            'active_status' => '0',
        ]);

        //89
        Currency ::create([
            'iso_4217_code' => 'JPYX',
            'iso_3166_code' => 'jpx',
            'iso_number' => '392',
            'currency_name' => 'Yen Doubled',
            'active_status' => '0',
        ]);

        //90
        Currency ::create([
            'iso_4217_code' => 'KES',
            'iso_3166_code' => 'ke',
            'iso_number' => '404',
            'currency_name' => 'Kenyan Shilling',
            'active_status' => '0',
        ]);

        //91
        Currency ::create([
            'iso_4217_code' => 'KGS',
            'iso_3166_code' => 'kg',
            'iso_number' => '417',
            'currency_name' => 'Som',
            'active_status' => '0',
        ]);

        //92
        Currency ::create([
            'iso_4217_code' => 'KHR',
            'iso_3166_code' => 'kh',
            'iso_number' => '116',
            'currency_name' => 'Riel',
            'active_status' => '0',
        ]);

        //93
        Currency ::create([
            'iso_4217_code' => 'KMF',
            'iso_3166_code' => 'km',
            'iso_number' => '174',
            'currency_name' => 'Comorian Franc',
            'active_status' => '0',
        ]);

        //94
        Currency ::create([
            'iso_4217_code' => 'KPW',
            'iso_3166_code' => 'kp',
            'iso_number' => '408',
            'currency_name' => 'North Korean Won',
            'active_status' => '0',
        ]);

        //95
        Currency ::create([
            'iso_4217_code' => 'KWD',
            'iso_3166_code' => 'kw',
            'iso_number' => '414',
            'currency_name' => 'Kuwaiti Dinar',
            'active_status' => '0',
        ]);

        //96
        Currency ::create([
            'iso_4217_code' => 'KYD',
            'iso_3166_code' => 'ky',
            'iso_number' => '136',
            'currency_name' => 'Cayman Islands Dollar',
            'active_status' => '0',
        ]);

        //97
        Currency ::create([
            'iso_4217_code' => 'KZT',
            'iso_3166_code' => 'kz',
            'iso_number' => '398',
            'currency_name' => 'Tenge',
            'active_status' => '0',
        ]);

        //98
        Currency ::create([
            'iso_4217_code' => 'LAK',
            'iso_3166_code' => 'la',
            'iso_number' => '418',
            'currency_name' => 'Lao Kip',
            'active_status' => '0',
        ]);

        //99
        Currency ::create([
            'iso_4217_code' => 'LBP',
            'iso_3166_code' => 'lb',
            'iso_number' => '422',
            'currency_name' => 'Lebanese Pound',
            'active_status' => '0',
        ]);

        //100
        Currency ::create([
            'iso_4217_code' => 'LKR',
            'iso_3166_code' => 'lk',
            'iso_number' => '144',
            'currency_name' => 'Sri Lanka Rupee',
            'active_status' => '0',
        ]);

        //101
        Currency ::create([
            'iso_4217_code' => 'LRD',
            'iso_3166_code' => 'lr',
            'iso_number' => '430',
            'currency_name' => 'Liberian Dollar',
            'active_status' => '0',
        ]);

        //102
        Currency ::create([
            'iso_4217_code' => 'LSL',
            'iso_3166_code' => 'ls',
            'iso_number' => '426',
            'currency_name' => 'Loti',
            'active_status' => '0',
        ]);

        //103
        Currency ::create([
            'iso_4217_code' => 'LYD',
            'iso_3166_code' => 'ly',
            'iso_number' => '434',
            'currency_name' => 'Libyan Dinar',
            'active_status' => '0',
        ]);

        //104
        Currency ::create([
            'iso_4217_code' => 'MAD',
            'iso_3166_code' => 'ma',
            'iso_number' => '504',
            'currency_name' => 'Moroccan Dirham',
            'active_status' => '0',
        ]);

        //105
        Currency ::create([
            'iso_4217_code' => 'MDL',
            'iso_3166_code' => 'md',
            'iso_number' => '498',
            'currency_name' => 'Moldovan Leu',
            'active_status' => '0',
        ]);

        //106
        Currency ::create([
            'iso_4217_code' => 'MGA',
            'iso_3166_code' => 'mg',
            'iso_number' => '969',
            'currency_name' => 'Malagasy Ariary',
            'active_status' => '0',
        ]);

        //107
        Currency ::create([
            'iso_4217_code' => 'MKD',
            'iso_3166_code' => 'mk',
            'iso_number' => '807',
            'currency_name' => 'Denar',
            'active_status' => '0',
        ]);

        //108
        Currency ::create([
            'iso_4217_code' => 'MMK',
            'iso_3166_code' => 'mm',
            'iso_number' => '104',
            'currency_name' => 'Kyat',
            'active_status' => '0',
        ]);

        //109
        Currency ::create([
            'iso_4217_code' => 'MNT',
            'iso_3166_code' => 'mn',
            'iso_number' => '496',
            'currency_name' => 'Tugrik',
            'active_status' => '0',
        ]);

        //110
        Currency ::create([
            'iso_4217_code' => 'MOP',
            'iso_3166_code' => 'mo',
            'iso_number' => '446',
            'currency_name' => 'Pataca',
            'active_status' => '0',
        ]);

        //111
        Currency ::create([
            'iso_4217_code' => 'MRU',
            'iso_3166_code' => 'mr',
            'iso_number' => '929',
            'currency_name' => 'Ouguiya',
            'active_status' => '0',
        ]);

        //112
        Currency ::create([
            'iso_4217_code' => 'MUR',
            'iso_3166_code' => 'mu',
            'iso_number' => '480',
            'currency_name' => 'Mauritius Rupee',
            'active_status' => '0',
        ]);

        //113
        Currency ::create([
            'iso_4217_code' => 'MVR',
            'iso_3166_code' => 'mv',
            'iso_number' => '462',
            'currency_name' => 'Rufiyaa',
            'active_status' => '0',
        ]);

        //114
        Currency ::create([
            'iso_4217_code' => 'MWK',
            'iso_3166_code' => 'mw',
            'iso_number' => '454',
            'currency_name' => 'Malawi Kwacha',
            'active_status' => '0',
        ]);

        //115
        Currency ::create([
            'iso_4217_code' => 'MXV',
            'iso_3166_code' => 'mx',
            'iso_number' => '979',
            'currency_name' => 'Mexican Unidad de Inversion (UDI)',
            'active_status' => '0',
        ]);

        //116
        Currency ::create([
            'iso_4217_code' => 'MZN',
            'iso_3166_code' => 'mz',
            'iso_number' => '943',
            'currency_name' => 'Mozambique Metical',
            'active_status' => '0',
        ]);

        //117
        Currency ::create([
            'iso_4217_code' => 'NAD',
            'iso_3166_code' => 'na',
            'iso_number' => '516',
            'currency_name' => 'Namibia Dollar',
            'active_status' => '0',
        ]);

        //118
        Currency ::create([
            'iso_4217_code' => 'NGN',
            'iso_3166_code' => 'ng',
            'iso_number' => '566',
            'currency_name' => 'Naira',
            'active_status' => '0',
        ]);

        //119
        Currency ::create([
            'iso_4217_code' => 'NIO',
            'iso_3166_code' => 'ni',
            'iso_number' => '558',
            'currency_name' => 'Cordoba Oro',
            'active_status' => '0',
        ]);

        //120
        Currency ::create([
            'iso_4217_code' => 'NPR',
            'iso_3166_code' => 'np',
            'iso_number' => '524',
            'currency_name' => 'Nepalese Rupee',
            'active_status' => '0',
        ]);

        //121
        Currency ::create([
            'iso_4217_code' => 'OMR',
            'iso_3166_code' => 'om',
            'iso_number' => '512',
            'currency_name' => 'Rial Omani',
            'active_status' => '0',
        ]);

        //122
        Currency ::create([
            'iso_4217_code' => 'PAB',
            'iso_3166_code' => 'pa',
            'iso_number' => '590',
            'currency_name' => 'Balboa',
            'active_status' => '0',
        ]);

        //123
        Currency ::create([
            'iso_4217_code' => 'PEN',
            'iso_3166_code' => 'pe',
            'iso_number' => '604',
            'currency_name' => 'Sol',
            'active_status' => '0',
        ]);

        //124
        Currency ::create([
            'iso_4217_code' => 'PGK',
            'iso_3166_code' => 'pg',
            'iso_number' => '598',
            'currency_name' => 'Kina',
            'active_status' => '0',
        ]);

        //125
        Currency ::create([
            'iso_4217_code' => 'PKR',
            'iso_3166_code' => 'pk',
            'iso_number' => '586',
            'currency_name' => 'Pakistan Rupee',
            'active_status' => '0',
        ]);

        //126
        Currency ::create([
            'iso_4217_code' => 'PYG',
            'iso_3166_code' => 'py',
            'iso_number' => '600',
            'currency_name' => 'Guarani',
            'active_status' => '0',
        ]);

        //127
        Currency ::create([
            'iso_4217_code' => 'QAR',
            'iso_3166_code' => 'qa',
            'iso_number' => '634',
            'currency_name' => 'Qatari Rial',
            'active_status' => '0',
        ]);

        //128
        Currency ::create([
            'iso_4217_code' => 'RSD',
            'iso_3166_code' => 'rs',
            'iso_number' => '941',
            'currency_name' => 'Serbian Dinar',
            'active_status' => '0',
        ]);

        //129
        Currency ::create([
            'iso_4217_code' => 'RWF',
            'iso_3166_code' => 'rw',
            'iso_number' => '646',
            'currency_name' => 'Rwanda Franc',
            'active_status' => '0',
        ]);

        //130
        Currency ::create([
            'iso_4217_code' => 'SAR',
            'iso_3166_code' => 'sa',
            'iso_number' => '682',
            'currency_name' => 'Saudi Riyal',
            'active_status' => '0',
        ]);

        //131
        Currency ::create([
            'iso_4217_code' => 'SBD',
            'iso_3166_code' => 'sb',
            'iso_number' => '090',
            'currency_name' => 'Solomon Islands Dollar',
            'active_status' => '0',
        ]);

        //132
        Currency ::create([
            'iso_4217_code' => 'SCR',
            'iso_3166_code' => 'sc',
            'iso_number' => '690',
            'currency_name' => 'Seychelles Rupee',
            'active_status' => '0',
        ]);

        //133
        Currency ::create([
            'iso_4217_code' => 'SDG',
            'iso_3166_code' => 'sd',
            'iso_number' => '938',
            'currency_name' => 'Sudanese Pound',
            'active_status' => '0',
        ]);

        //134
        Currency ::create([
            'iso_4217_code' => 'SHP',
            'iso_3166_code' => 'sh',
            'iso_number' => '654',
            'currency_name' => 'Saint Helena Pound',
            'active_status' => '0',
        ]);

        //135
        Currency ::create([
            'iso_4217_code' => 'SLL',
            'iso_3166_code' => 'sl',
            'iso_number' => '694',
            'currency_name' => 'Leone',
            'active_status' => '0',
        ]);

        //136
        Currency ::create([
            'iso_4217_code' => 'SOS',
            'iso_3166_code' => 'so',
            'iso_number' => '706',
            'currency_name' => 'Somali Shilling',
            'active_status' => '0',
        ]);

        //137
        Currency ::create([
            'iso_4217_code' => 'SRD',
            'iso_3166_code' => 'sr',
            'iso_number' => '968',
            'currency_name' => 'Surinam Dollar',
            'active_status' => '0',
        ]);

        //138
        Currency ::create([
            'iso_4217_code' => 'STN',
            'iso_3166_code' => 'st',
            'iso_number' => '930',
            'currency_name' => 'Dobra',
            'active_status' => '0',
        ]);

        //139
        Currency ::create([
            'iso_4217_code' => 'SVC',
            'iso_3166_code' => 'sv',
            'iso_number' => '222',
            'currency_name' => 'El Salvador Colon',
            'active_status' => '0',
        ]);

        //140
        Currency ::create([
            'iso_4217_code' => 'SYP',
            'iso_3166_code' => 'sy',
            'iso_number' => '760',
            'currency_name' => 'Syrian Pound',
            'active_status' => '0',
        ]);

        //141
        Currency ::create([
            'iso_4217_code' => 'SZL',
            'iso_3166_code' => 'sz',
            'iso_number' => '748',
            'currency_name' => 'Lilangeni',
            'active_status' => '0',
        ]);

        //142
        Currency ::create([
            'iso_4217_code' => 'TJS',
            'iso_3166_code' => 'tj',
            'iso_number' => '972',
            'currency_name' => 'Somoni',
            'active_status' => '0',
        ]);

        //143
        Currency ::create([
            'iso_4217_code' => 'TMT',
            'iso_3166_code' => 'tm',
            'iso_number' => '934',
            'currency_name' => 'Turkmenistan New Manat',
            'active_status' => '0',
        ]);

        //144
        Currency ::create([
            'iso_4217_code' => 'TND',
            'iso_3166_code' => 'tn',
            'iso_number' => '788',
            'currency_name' => 'Tunisian Dinar',
            'active_status' => '0',
        ]);

        //145
        Currency ::create([
            'iso_4217_code' => 'TOP',
            'iso_3166_code' => 'to',
            'iso_number' => '776',
            'currency_name' => 'Pa’anga',
            'active_status' => '0',
        ]);

        //146
        Currency ::create([
            'iso_4217_code' => 'TTD',
            'iso_3166_code' => 'tt',
            'iso_number' => '780',
            'currency_name' => 'Trinidad and Tobago Dollar',
            'active_status' => '0',
        ]);

        //147
        Currency ::create([
            'iso_4217_code' => 'TWD',
            'iso_3166_code' => 'tw',
            'iso_number' => '901',
            'currency_name' => 'New Taiwan Dollar',
            'active_status' => '0',
        ]);

        //148
        Currency ::create([
            'iso_4217_code' => 'TZS',
            'iso_3166_code' => 'tz',
            'iso_number' => '834',
            'currency_name' => 'Tanzanian Shilling',
            'active_status' => '0',
        ]);

        //149
        Currency ::create([
            'iso_4217_code' => 'UAH',
            'iso_3166_code' => 'ua',
            'iso_number' => '980',
            'currency_name' => 'Hryvnia',
            'active_status' => '0',
        ]);

        //150
        Currency ::create([
            'iso_4217_code' => 'UGX',
            'iso_3166_code' => 'ug',
            'iso_number' => '800',
            'currency_name' => 'Uganda Shilling',
            'active_status' => '0',
        ]);

        //151
        Currency ::create([
            'iso_4217_code' => 'USN',
            'iso_3166_code' => 'us',
            'iso_number' => '997',
            'currency_name' => 'US Dollar (Next day)',
            'active_status' => '0',
        ]);

        //152
        Currency ::create([
            'iso_4217_code' => 'UYI',
            'iso_3166_code' => 'uy',
            'iso_number' => '940',
            'currency_name' => 'Uruguay Peso en Unidades Indexadas (UI)',
            'active_status' => '0',
        ]);

        //153
        Currency ::create([
            'iso_4217_code' => 'UYU',
            'iso_3166_code' => 'uy',
            'iso_number' => '858',
            'currency_name' => 'Peso Uruguayo',
            'active_status' => '0',
        ]);

        //154
        Currency ::create([
            'iso_4217_code' => 'UYW',
            'iso_3166_code' => 'uy',
            'iso_number' => '927',
            'currency_name' => 'Unidad Previsional',
            'active_status' => '0',
        ]);

        //155
        Currency ::create([
            'iso_4217_code' => 'UZS',
            'iso_3166_code' => 'uz',
            'iso_number' => '860',
            'currency_name' => 'Uzbekistan Sum',
            'active_status' => '0',
        ]);

        //156
        Currency ::create([
            'iso_4217_code' => 'VES',
            'iso_3166_code' => 've',
            'iso_number' => '928',
            'currency_name' => 'Bolívar Soberano',
            'active_status' => '0',
        ]);

        //157
        Currency ::create([
            'iso_4217_code' => 'VND',
            'iso_3166_code' => 'vn',
            'iso_number' => '704',
            'currency_name' => 'Dong',
            'active_status' => '0',
        ]);

        //158
        Currency ::create([
            'iso_4217_code' => 'VUV',
            'iso_3166_code' => 'vu',
            'iso_number' => '548',
            'currency_name' => 'Vatu',
            'active_status' => '0',
        ]);

        //159
        Currency ::create([
            'iso_4217_code' => 'WST',
            'iso_3166_code' => 'ws',
            'iso_number' => '882',
            'currency_name' => 'Tala',
            'active_status' => '0',
        ]);

        //160
        Currency ::create([
            'iso_4217_code' => 'YER',
            'iso_3166_code' => 'ye',
            'iso_number' => '886',
            'currency_name' => 'Yemeni Rial',
            'active_status' => '0',
        ]);

        //161
        Currency ::create([
            'iso_4217_code' => 'ZMW',
            'iso_3166_code' => 'zm',
            'iso_number' => '967',
            'currency_name' => 'Zambian Kwacha',
            'active_status' => '0',
        ]);

        //162
        Currency ::create([
            'iso_4217_code' => 'ZWL',
            'iso_3166_code' => 'zw',
            'iso_number' => '932',
            'currency_name' => 'Zimbabwe Dollar',
            'active_status' => '0',
        ]);


        //163
        Currency ::create([
            'iso_4217_code' => 'CNH',
            'iso_3166_code' => 'cnh',
            'iso_number' => 0,
            'currency_name' => 'Chinese yuan renminbi (offshore)',
            'active_status' => '0',
        ]);

        /*Added new from here*/
        //164
        Currency ::create([
            'iso_4217_code' => 'XOF',
            'iso_3166_code' => '',
            'iso_number' => 0,
            'currency_name' => 'West African CFA franc',
            'active_status' => '0',
        ]);

        //165
        Currency ::create([
            'iso_4217_code' => 'XCD',
            'iso_3166_code' => '',
            'iso_number' => 0,
            'currency_name' => 'Eastern Caribbean dollar',
            'active_status' => '0',
        ]);

        //166
        Currency ::create([
            'iso_4217_code' => 'SSP',
            'iso_3166_code' => '',
            'iso_number' => 0,
            'currency_name' => 'South Sudanese pound',
            'active_status' => '0',
        ]);

        //167
        Currency ::create([
            'iso_4217_code' => 'XAF',
            'iso_3166_code' => '',
            'iso_number' => 0,
            'currency_name' => 'Central African CFA franc',
            'active_status' => '0',
        ]);

        //168
        Currency ::create([
            'iso_4217_code' => 'GYD',
            'iso_3166_code' => 'gy',
            'iso_number' => 0,
            'currency_name' => 'Guyanese dollar',
            'active_status' => '0',
        ]);


    }
}