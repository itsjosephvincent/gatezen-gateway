<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Afghanistan',
                'iso_2' => 'AF',
                'iso_3' => 'AFG',
                'phone_code' => 93,
            ],
            [
                'name' => 'Albania',
                'iso_2' => 'AL',
                'iso_3' => 'ALB',
                'phone_code' => 355,

            ],
            [
                'name' => 'Algeria',
                'iso_2' => 'DZ',
                'iso_3' => 'DZA',
                'phone_code' => 213,

            ],
            [
                'name' => 'American Samoa',
                'iso_2' => 'AS',
                'iso_3' => 'ASM',
                'phone_code' => '1-684',

            ],
            [
                'name' => 'Andorra',
                'iso_2' => 'AD',
                'iso_3' => 'AND',
                'phone_code' => 376,

            ],
            [
                'name' => 'Angola',
                'iso_2' => 'AO',
                'iso_3' => 'AGO',
                'phone_code' => 244,

            ],
            [
                'name' => 'Anguilla',
                'iso_2' => 'AI',
                'iso_3' => 'AIA',
                'phone_code' => '1-264',

            ],
            [
                'name' => 'Antarctica',
                'iso_2' => 'AQ',
                'iso_3' => 'ATA',
                'phone_code' => 672,

            ],
            [
                'name' => 'Antigua and Barbuda',
                'iso_2' => 'AG',
                'iso_3' => 'ATG',
                'phone_code' => '1-268',

            ],
            [
                'name' => 'Argentina',
                'iso_2' => 'AR',
                'iso_3' => 'ARG',
                'phone_code' => 54,

            ],
            [
                'name' => 'Armenia',
                'iso_2' => 'AM',
                'iso_3' => 'ARM',
                'phone_code' => 374,

            ],
            [
                'name' => 'Aruba',
                'iso_2' => 'AW',
                'iso_3' => 'ABW',
                'phone_code' => 297,

            ],
            [
                'name' => 'Australia',
                'iso_2' => 'AU',
                'iso_3' => 'AUS',
                'phone_code' => 61,

            ],
            [
                'name' => 'Austria',
                'iso_2' => 'AT',
                'iso_3' => 'AUT',
                'phone_code' => 43,

            ],
            [
                'name' => 'Azerbaijan',
                'iso_2' => 'AZ',
                'iso_3' => 'AZE',
                'phone_code' => 994,

            ],
            [
                'name' => 'Bahamas',
                'iso_2' => 'BS',
                'iso_3' => 'BHS',
                'phone_code' => '1-242',

            ],
            [
                'name' => 'Bahrain',
                'iso_2' => 'BH',
                'iso_3' => 'BHR',
                'phone_code' => 973,

            ],
            [
                'name' => 'Bangladesh',
                'iso_2' => 'BD',
                'iso_3' => 'BGD',
                'phone_code' => 880,

            ],
            [
                'name' => 'Barbados',
                'iso_2' => 'BB',
                'iso_3' => 'BRB',
                'phone_code' => '1-246',

            ],
            [
                'name' => 'Belarus',
                'iso_2' => 'BY',
                'iso_3' => 'BLR',
                'phone_code' => 375,

            ],
            [
                'name' => 'Belgium',
                'iso_2' => 'BE',
                'iso_3' => 'BEL',
                'phone_code' => 32,

            ],
            [
                'name' => 'Belize',
                'iso_2' => 'BZ',
                'iso_3' => 'BLZ',
                'phone_code' => 501,

            ],
            [
                'name' => 'Benin',
                'iso_2' => 'BJ',
                'iso_3' => 'BEN',
                'phone_code' => 229,

            ],
            [
                'name' => 'Bermuda',
                'iso_2' => 'BM',
                'iso_3' => 'BMU',
                'phone_code' => '1-441',

            ],
            [
                'name' => 'Bhutan',
                'iso_2' => 'BT',
                'iso_3' => 'BTN',
                'phone_code' => 975,

            ],
            [
                'name' => 'Bolivia',
                'iso_2' => 'BO',
                'iso_3' => 'BOL',
                'phone_code' => 591,

            ],
            [
                'name' => 'Bosnia and Herzegovina',
                'iso_2' => 'BA',
                'iso_3' => 'BIH',
                'phone_code' => 387,

            ],
            [
                'name' => 'Botswana',
                'iso_2' => 'BW',
                'iso_3' => 'BWA',
                'phone_code' => 267,

            ],
            [
                'name' => 'Brazil',
                'iso_2' => 'BR',
                'iso_3' => 'BRA',
                'phone_code' => 55,

            ],
            [
                'name' => 'British Indian Ocean Territory',
                'iso_2' => 'IO',
                'iso_3' => 'IOT',
                'phone_code' => 246,

            ],
            [
                'name' => 'British Virgin Islands',
                'iso_2' => 'VG',
                'iso_3' => 'VGB',
                'phone_code' => '1-284',

            ],
            [
                'name' => 'Brunei',
                'iso_2' => 'BN',
                'iso_3' => 'BRN',
                'phone_code' => 673,

            ],
            [
                'name' => 'Bulgaria',
                'iso_2' => 'BG',
                'iso_3' => 'BGR',
                'phone_code' => 359,

            ],
            [
                'name' => 'Burkina Faso',
                'iso_2' => 'BF',
                'iso_3' => 'BFA',
                'phone_code' => 226,

            ],
            [
                'name' => 'Burundi',
                'iso_2' => 'BI',
                'iso_3' => 'BDI',
                'phone_code' => 257,

            ],
            [
                'name' => 'Cambodia',
                'iso_2' => 'KH',
                'iso_3' => 'KHM',
                'phone_code' => 855,

            ],
            [
                'name' => 'Cameroon',
                'iso_2' => 'CM',
                'iso_3' => 'CMR',
                'phone_code' => 237,

            ],
            [
                'name' => 'Canada',
                'iso_2' => 'CA',
                'iso_3' => 'CAN',
                'phone_code' => 1,

            ],
            [
                'name' => 'Cape Verde',
                'iso_2' => 'CV',
                'iso_3' => 'CPV',
                'phone_code' => 238,

            ],
            [
                'name' => 'Cayman Islands',
                'iso_2' => 'KY',
                'iso_3' => 'CYM',
                'phone_code' => '1-345',

            ],
            [
                'name' => 'Central African Republic',
                'iso_2' => 'CF',
                'iso_3' => 'CAF',
                'phone_code' => 236,

            ],
            [
                'name' => 'Chad',
                'iso_2' => 'TD',
                'iso_3' => 'TCD',
                'phone_code' => 235,

            ],
            [
                'name' => 'Chile',
                'iso_2' => 'CL',
                'iso_3' => 'CHL',
                'phone_code' => 56,

            ],
            [
                'name' => 'China',
                'iso_2' => 'CN',
                'iso_3' => 'CHN',
                'phone_code' => 86,

            ],
            [
                'name' => 'Christmas Island',
                'iso_2' => 'CX',
                'iso_3' => 'CXR',
                'phone_code' => 61,

            ],
            [
                'name' => 'Cocos Islands',
                'iso_2' => 'CC',
                'iso_3' => 'CCK',
                'phone_code' => 61,

            ],
            [
                'name' => 'Colombia',
                'iso_2' => 'CO',
                'iso_3' => 'COL',
                'phone_code' => 57,

            ],
            [
                'name' => 'Comoros',
                'iso_2' => 'KM',
                'iso_3' => 'COM',
                'phone_code' => 269,

            ],
            [
                'name' => 'Cook Islands',
                'iso_2' => 'CK',
                'iso_3' => 'COK',
                'phone_code' => 682,

            ],
            [
                'name' => 'Costa Rica',
                'iso_2' => 'CR',
                'iso_3' => 'CRI',
                'phone_code' => 506,

            ],
            [
                'name' => 'Croatia',
                'iso_2' => 'HR',
                'iso_3' => 'HRV',
                'phone_code' => 385,

            ],
            [
                'name' => 'Cuba',
                'iso_2' => 'CU',
                'iso_3' => 'CUB',
                'phone_code' => 53,

            ],
            [
                'name' => 'Curacao',
                'iso_2' => 'CW',
                'iso_3' => 'CUW',
                'phone_code' => 599,

            ],
            [
                'name' => 'Cyprus',
                'iso_2' => 'CY',
                'iso_3' => 'CYP',
                'phone_code' => 357,

            ],
            [
                'name' => 'Czech Republic',
                'iso_2' => 'CZ',
                'iso_3' => 'CZE',
                'phone_code' => 420,

            ],
            [
                'name' => 'Democratic Republic of the Congo',
                'iso_2' => 'CD',
                'iso_3' => 'COD',
                'phone_code' => 243,

            ],
            [
                'name' => 'Denmark',
                'iso_2' => 'DK',
                'iso_3' => 'DNK',
                'phone_code' => 45,

            ],
            [
                'name' => 'Djibouti',
                'iso_2' => 'DJ',
                'iso_3' => 'DJI',
                'phone_code' => 253,

            ],
            [
                'name' => 'Dominica',
                'iso_2' => 'DM',
                'iso_3' => 'DMA',
                'phone_code' => '1-767',

            ],
            [
                'name' => 'Dominican Republic',
                'iso_2' => 'DO',
                'iso_3' => 'DOM',
                'phone_code' => '1-809, 1-829, 1-849',

            ],
            [
                'name' => 'East Timor',
                'iso_2' => 'TL',
                'iso_3' => 'TLS',
                'phone_code' => 670,

            ],
            [
                'name' => 'Ecuador',
                'iso_2' => 'EC',
                'iso_3' => 'ECU',
                'phone_code' => 593,

            ],
            [
                'name' => 'Egypt',
                'iso_2' => 'EG',
                'iso_3' => 'EGY',
                'phone_code' => 20,

            ],
            [
                'name' => 'El Salvador',
                'iso_2' => 'SV',
                'iso_3' => 'SLV',
                'phone_code' => 503,

            ],
            [
                'name' => 'Equatorial Guinea',
                'iso_2' => 'GQ',
                'iso_3' => 'GNQ',
                'phone_code' => 240,

            ],
            [
                'name' => 'Eritrea',
                'iso_2' => 'ER',
                'iso_3' => 'ERI',
                'phone_code' => 291,

            ],
            [
                'name' => 'Estonia',
                'iso_2' => 'EE',
                'iso_3' => 'EST',
                'phone_code' => 372,

            ],
            [
                'name' => 'Ethiopia',
                'iso_2' => 'ET',
                'iso_3' => 'ETH',
                'phone_code' => 251,

            ],
            [
                'name' => 'Falkland Islands',
                'iso_2' => 'FK',
                'iso_3' => 'FLK',
                'phone_code' => 500,

            ],
            [
                'name' => 'Faroe Islands',
                'iso_2' => 'FO',
                'iso_3' => 'FRO',
                'phone_code' => 298,

            ],
            [
                'name' => 'Fiji',
                'iso_2' => 'FJ',
                'iso_3' => 'FJI',
                'phone_code' => 679,

            ],
            [
                'name' => 'Finland',
                'iso_2' => 'FI',
                'iso_3' => 'FIN',
                'phone_code' => 358,

            ],
            [
                'name' => 'France',
                'iso_2' => 'FR',
                'iso_3' => 'FRA',
                'phone_code' => 33,

            ],
            [
                'name' => 'French Polynesia',
                'iso_2' => 'PF',
                'iso_3' => 'PYF',
                'phone_code' => 689,

            ],
            [
                'name' => 'Gabon',
                'iso_2' => 'GA',
                'iso_3' => 'GAB',
                'phone_code' => 241,

            ],
            [
                'name' => 'Gambia',
                'iso_2' => 'GM',
                'iso_3' => 'GMB',
                'phone_code' => 220,

            ],
            [
                'name' => 'Georgia',
                'iso_2' => 'GE',
                'iso_3' => 'GEO',
                'phone_code' => 995,

            ],
            [
                'name' => 'Germany',
                'iso_2' => 'DE',
                'iso_3' => 'DEU',
                'phone_code' => 49,

            ],
            [
                'name' => 'Ghana',
                'iso_2' => 'GH',
                'iso_3' => 'GHA',
                'phone_code' => 233,

            ],
            [
                'name' => 'Gibraltar',
                'iso_2' => 'GI',
                'iso_3' => 'GIB',
                'phone_code' => 350,

            ],
            [
                'name' => 'Greece',
                'iso_2' => 'GR',
                'iso_3' => 'GRC',
                'phone_code' => 30,

            ],
            [
                'name' => 'Greenland',
                'iso_2' => 'GL',
                'iso_3' => 'GRL',
                'phone_code' => 299,

            ],
            [
                'name' => 'Grenada',
                'iso_2' => 'GD',
                'iso_3' => 'GRD',
                'phone_code' => '1-473',

            ],
            [
                'name' => 'Guam',
                'iso_2' => 'GU',
                'iso_3' => 'GUM',
                'phone_code' => '1-671',

            ],
            [
                'name' => 'Guatemala',
                'iso_2' => 'GT',
                'iso_3' => 'GTM',
                'phone_code' => 502,

            ],
            [
                'name' => 'Guernsey',
                'iso_2' => 'GG',
                'iso_3' => 'GGY',
                'phone_code' => '44-1481',

            ],
            [
                'name' => 'Guinea',
                'iso_2' => 'GN',
                'iso_3' => 'GIN',
                'phone_code' => 224,

            ],
            [
                'name' => 'Guinea-Bissau',
                'iso_2' => 'GW',
                'iso_3' => 'GNB',
                'phone_code' => 245,

            ],
            [
                'name' => 'Guyana',
                'iso_2' => 'GY',
                'iso_3' => 'GUY',
                'phone_code' => 592,

            ],
            [
                'name' => 'Haiti',
                'iso_2' => 'HT',
                'iso_3' => 'HTI',
                'phone_code' => 509,

            ],
            [
                'name' => 'Honduras',
                'iso_2' => 'HN',
                'iso_3' => 'HND',
                'phone_code' => 504,

            ],
            [
                'name' => 'Hong Kong',
                'iso_2' => 'HK',
                'iso_3' => 'HKG',
                'phone_code' => 852,

            ],
            [
                'name' => 'Hungary',
                'iso_2' => 'HU',
                'iso_3' => 'HUN',
                'phone_code' => 36,

            ],
            [
                'name' => 'Iceland',
                'iso_2' => 'IS',
                'iso_3' => 'ISL',
                'phone_code' => 354,

            ],
            [
                'name' => 'India',
                'iso_2' => 'IN',
                'iso_3' => 'IND',
                'phone_code' => 91,

            ],
            [
                'name' => 'Indonesia',
                'iso_2' => 'ID',
                'iso_3' => 'IDN',
                'phone_code' => 62,

            ],
            [
                'name' => 'Iran',
                'iso_2' => 'IR',
                'iso_3' => 'IRN',
                'phone_code' => 98,

            ],
            [
                'name' => 'Iraq',
                'iso_2' => 'IQ',
                'iso_3' => 'IRQ',
                'phone_code' => 964,

            ],
            [
                'name' => 'Ireland',
                'iso_2' => 'IE',
                'iso_3' => 'IRL',
                'phone_code' => 353,

            ],
            [
                'name' => 'Isle of Man',
                'iso_2' => 'IM',
                'iso_3' => 'IMN',
                'phone_code' => '44-1624',

            ],
            [
                'name' => 'Israel',
                'iso_2' => 'IL',
                'iso_3' => 'ISR',
                'phone_code' => 972,

            ],
            [
                'name' => 'Italy',
                'iso_2' => 'IT',
                'iso_3' => 'ITA',
                'phone_code' => 39,

            ],
            [
                'name' => 'Ivory Coast',
                'iso_2' => 'CI',
                'iso_3' => 'CIV',
                'phone_code' => 225,

            ],
            [
                'name' => 'Jamaica',
                'iso_2' => 'JM',
                'iso_3' => 'JAM',
                'phone_code' => '1-876',

            ],
            [
                'name' => 'Japan',
                'iso_2' => 'JP',
                'iso_3' => 'JPN',
                'phone_code' => 81,

            ],
            [
                'name' => 'Jersey',
                'iso_2' => 'JE',
                'iso_3' => 'JEY',
                'phone_code' => '44-1534',

            ],
            [
                'name' => 'Jordan',
                'iso_2' => 'JO',
                'iso_3' => 'JOR',
                'phone_code' => 962,

            ],
            [
                'name' => 'Kazakhstan',
                'iso_2' => 'KZ',
                'iso_3' => 'KAZ',
                'phone_code' => 7,

            ],
            [
                'name' => 'Kenya',
                'iso_2' => 'KE',
                'iso_3' => 'KEN',
                'phone_code' => 254,

            ],
            [
                'name' => 'Kiribati',
                'iso_2' => 'KI',
                'iso_3' => 'KIR',
                'phone_code' => 686,

            ],
            [
                'name' => 'Kosovo',
                'iso_2' => 'XK',
                'iso_3' => 'XKX',
                'phone_code' => 383,

            ],
            [
                'name' => 'Kuwait',
                'iso_2' => 'KW',
                'iso_3' => 'KWT',
                'phone_code' => 965,

            ],
            [
                'name' => 'Kyrgyzstan',
                'iso_2' => 'KG',
                'iso_3' => 'KGZ',
                'phone_code' => 996,

            ],
            [
                'name' => 'Laos',
                'iso_2' => 'LA',
                'iso_3' => 'LAO',
                'phone_code' => 856,

            ],
            [
                'name' => 'Latvia',
                'iso_2' => 'LV',
                'iso_3' => 'LVA',
                'phone_code' => 371,

            ],
            [
                'name' => 'Lebanon',
                'iso_2' => 'LB',
                'iso_3' => 'LBN',
                'phone_code' => 961,

            ],
            [
                'name' => 'Lesotho',
                'iso_2' => 'LS',
                'iso_3' => 'LSO',
                'phone_code' => 266,

            ],
            [
                'name' => 'Liberia',
                'iso_2' => 'LR',
                'iso_3' => 'LBR',
                'phone_code' => 231,

            ],
            [
                'name' => 'Libya',
                'iso_2' => 'LY',
                'iso_3' => 'LBY',
                'phone_code' => 218,

            ],
            [
                'name' => 'Liechtenstein',
                'iso_2' => 'LI',
                'iso_3' => 'LIE',
                'phone_code' => 423,

            ],
            [
                'name' => 'Lithuania',
                'iso_2' => 'LT',
                'iso_3' => 'LTU',
                'phone_code' => 370,

            ],
            [
                'name' => 'Luxembourg',
                'iso_2' => 'LU',
                'iso_3' => 'LUX',
                'phone_code' => 352,

            ],
            [
                'name' => 'Macau',
                'iso_2' => 'MO',
                'iso_3' => 'MAC',
                'phone_code' => 853,

            ],
            [
                'name' => 'Macedonia',
                'iso_2' => 'MK',
                'iso_3' => 'MKD',
                'phone_code' => 389,

            ],
            [
                'name' => 'Madagascar',
                'iso_2' => 'MG',
                'iso_3' => 'MDG',
                'phone_code' => 261,

            ],
            [
                'name' => 'Malawi',
                'iso_2' => 'MW',
                'iso_3' => 'MWI',
                'phone_code' => 265,

            ],
            [
                'name' => 'Malaysia',
                'iso_2' => 'MY',
                'iso_3' => 'MYS',
                'phone_code' => 60,

            ],
            [
                'name' => 'Maldives',
                'iso_2' => 'MV',
                'iso_3' => 'MDV',
                'phone_code' => 960,

            ],
            [
                'name' => 'Mali',
                'iso_2' => 'ML',
                'iso_3' => 'MLI',
                'phone_code' => 223,

            ],
            [
                'name' => 'Malta',
                'iso_2' => 'MT',
                'iso_3' => 'MLT',
                'phone_code' => 356,

            ],
            [
                'name' => 'Marshall Islands',
                'iso_2' => 'MH',
                'iso_3' => 'MHL',
                'phone_code' => 692,

            ],
            [
                'name' => 'Mauritania',
                'iso_2' => 'MR',
                'iso_3' => 'MRT',
                'phone_code' => 222,

            ],
            [
                'name' => 'Mauritius',
                'iso_2' => 'MU',
                'iso_3' => 'MUS',
                'phone_code' => 230,

            ],
            [
                'name' => 'Mayotte',
                'iso_2' => 'YT',
                'iso_3' => 'MYT',
                'phone_code' => 262,

            ],
            [
                'name' => 'Mexico',
                'iso_2' => 'MX',
                'iso_3' => 'MEX',
                'phone_code' => 52,

            ],
            [
                'name' => 'Micronesia',
                'iso_2' => 'FM',
                'iso_3' => 'FSM',
                'phone_code' => 691,

            ],
            [
                'name' => 'Moldova',
                'iso_2' => 'MD',
                'iso_3' => 'MDA',
                'phone_code' => 373,

            ],
            [
                'name' => 'Monaco',
                'iso_2' => 'MC',
                'iso_3' => 'MCO',
                'phone_code' => 377,

            ],
            [
                'name' => 'Mongolia',
                'iso_2' => 'MN',
                'iso_3' => 'MNG',
                'phone_code' => 976,

            ],
            [
                'name' => 'Montenegro',
                'iso_2' => 'ME',
                'iso_3' => 'MNE',
                'phone_code' => 382,

            ],
            [
                'name' => 'Montserrat',
                'iso_2' => 'MS',
                'iso_3' => 'MSR',
                'phone_code' => '1-664',

            ],
            [
                'name' => 'Morocco',
                'iso_2' => 'MA',
                'iso_3' => 'MAR',
                'phone_code' => 212,

            ],
            [
                'name' => 'Mozambique',
                'iso_2' => 'MZ',
                'iso_3' => 'MOZ',
                'phone_code' => 258,

            ],
            [
                'name' => 'Myanmar',
                'iso_2' => 'MM',
                'iso_3' => 'MMR',
                'phone_code' => 95,

            ],
            [
                'name' => 'Namibia',
                'iso_2' => 'NA',
                'iso_3' => 'NAM',
                'phone_code' => 264,

            ],
            [
                'name' => 'Nauru',
                'iso_2' => 'NR',
                'iso_3' => 'NRU',
                'phone_code' => 674,

            ],
            [
                'name' => 'Nepal',
                'iso_2' => 'NP',
                'iso_3' => 'NPL',
                'phone_code' => 977,

            ],
            [
                'name' => 'Netherlands',
                'iso_2' => 'NL',
                'iso_3' => 'NLD',
                'phone_code' => 31,

            ],
            [
                'name' => 'Netherlands Antilles',
                'iso_2' => 'AN',
                'iso_3' => 'ANT',
                'phone_code' => 599,

            ],
            [
                'name' => 'New Caledonia',
                'iso_2' => 'NC',
                'iso_3' => 'NCL',
                'phone_code' => 687,

            ],
            [
                'name' => 'New Zealand',
                'iso_2' => 'NZ',
                'iso_3' => 'NZL',
                'phone_code' => 64,

            ],
            [
                'name' => 'Nicaragua',
                'iso_2' => 'NI',
                'iso_3' => 'NIC',
                'phone_code' => 505,

            ],
            [
                'name' => 'Niger',
                'iso_2' => 'NE',
                'iso_3' => 'NER',
                'phone_code' => 227,

            ],
            [
                'name' => 'Nigeria',
                'iso_2' => 'NG',
                'iso_3' => 'NGA',
                'phone_code' => 234,

            ],
            [
                'name' => 'Niue',
                'iso_2' => 'NU',
                'iso_3' => 'NIU',
                'phone_code' => 683,

            ],
            [
                'name' => 'North Korea',
                'iso_2' => 'KP',
                'iso_3' => 'PRK',
                'phone_code' => 850,

            ],
            [
                'name' => 'Northern Mariana Islands',
                'iso_2' => 'MP',
                'iso_3' => 'MNP',
                'phone_code' => '1-670',

            ],
            [
                'name' => 'Norway',
                'iso_2' => 'NO',
                'iso_3' => 'NOR',
                'phone_code' => 47,

            ],
            [
                'name' => 'Oman',
                'iso_2' => 'OM',
                'iso_3' => 'OMN',
                'phone_code' => 968,

            ],
            [
                'name' => 'Pakistan',
                'iso_2' => 'PK',
                'iso_3' => 'PAK',
                'phone_code' => 92,

            ],
            [
                'name' => 'Palau',
                'iso_2' => 'PW',
                'iso_3' => 'PLW',
                'phone_code' => 680,

            ],
            [
                'name' => 'Palestine',
                'iso_2' => 'PS',
                'iso_3' => 'PSE',
                'phone_code' => 970,

            ],
            [
                'name' => 'Panama',
                'iso_2' => 'PA',
                'iso_3' => 'PAN',
                'phone_code' => 507,

            ],
            [
                'name' => 'Papua New Guinea',
                'iso_2' => 'PG',
                'iso_3' => 'PNG',
                'phone_code' => 675,

            ],
            [
                'name' => 'Paraguay',
                'iso_2' => 'PY',
                'iso_3' => 'PRY',
                'phone_code' => 595,

            ],
            [
                'name' => 'Peru',
                'iso_2' => 'PE',
                'iso_3' => 'PER',
                'phone_code' => 51,

            ],
            [
                'name' => 'Philippines',
                'iso_2' => 'PH',
                'iso_3' => 'PHL',
                'phone_code' => 63,

            ],
            [
                'name' => 'Pitcairn',
                'iso_2' => 'PN',
                'iso_3' => 'PCN',
                'phone_code' => 64,

            ],
            [
                'name' => 'Poland',
                'iso_2' => 'PL',
                'iso_3' => 'POL',
                'phone_code' => 48,

            ],
            [
                'name' => 'Portugal',
                'iso_2' => 'PT',
                'iso_3' => 'PRT',
                'phone_code' => 351,

            ],
            [
                'name' => 'Puerto Rico',
                'iso_2' => 'PR',
                'iso_3' => 'PRI',
                'phone_code' => '1-787, 1-939',

            ],
            [
                'name' => 'Qatar',
                'iso_2' => 'QA',
                'iso_3' => 'QAT',
                'phone_code' => 974,

            ],
            [
                'name' => 'Republic of the Congo',
                'iso_2' => 'CG',
                'iso_3' => 'COG',
                'phone_code' => 242,

            ],
            [
                'name' => 'Reunion',
                'iso_2' => 'RE',
                'iso_3' => 'REU',
                'phone_code' => 262,

            ],
            [
                'name' => 'Romania',
                'iso_2' => 'RO',
                'iso_3' => 'ROU',
                'phone_code' => 40,

            ],
            [
                'name' => 'Russia',
                'iso_2' => 'RU',
                'iso_3' => 'RUS',
                'phone_code' => 7,

            ],
            [
                'name' => 'Rwanda',
                'iso_2' => 'RW',
                'iso_3' => 'RWA',
                'phone_code' => 250,

            ],
            [
                'name' => 'Saint Barthelemy',
                'iso_2' => 'BL',
                'iso_3' => 'BLM',
                'phone_code' => 590,

            ],
            [
                'name' => 'Saint Helena',
                'iso_2' => 'SH',
                'iso_3' => 'SHN',
                'phone_code' => 290,

            ],
            [
                'name' => 'Saint Kitts and Nevis',
                'iso_2' => 'KN',
                'iso_3' => 'KNA',
                'phone_code' => '1-869',

            ],
            [
                'name' => 'Saint Lucia',
                'iso_2' => 'LC',
                'iso_3' => 'LCA',
                'phone_code' => '1-758',

            ],
            [
                'name' => 'Saint Martin',
                'iso_2' => 'MF',
                'iso_3' => 'MAF',
                'phone_code' => 590,

            ],
            [
                'name' => 'Saint Pierre and Miquelon',
                'iso_2' => 'PM',
                'iso_3' => 'SPM',
                'phone_code' => 508,

            ],
            [
                'name' => 'Saint Vincent and the Grenadines',
                'iso_2' => 'VC',
                'iso_3' => 'VCT',
                'phone_code' => '1-784',

            ],
            [
                'name' => 'Samoa',
                'iso_2' => 'WS',
                'iso_3' => 'WSM',
                'phone_code' => 685,

            ],
            [
                'name' => 'San Marino',
                'iso_2' => 'SM',
                'iso_3' => 'SMR',
                'phone_code' => 378,

            ],
            [
                'name' => 'Sao Tome and Principe',
                'iso_2' => 'ST',
                'iso_3' => 'STP',
                'phone_code' => 239,

            ],
            [
                'name' => 'Saudi Arabia',
                'iso_2' => 'SA',
                'iso_3' => 'SAU',
                'phone_code' => 966,

            ],
            [
                'name' => 'Senegal',
                'iso_2' => 'SN',
                'iso_3' => 'SEN',
                'phone_code' => 221,

            ],
            [
                'name' => 'Serbia',
                'iso_2' => 'RS',
                'iso_3' => 'SRB',
                'phone_code' => 381,

            ],
            [
                'name' => 'Seychelles',
                'iso_2' => 'SC',
                'iso_3' => 'SYC',
                'phone_code' => 248,

            ],
            [
                'name' => 'Sierra Leone',
                'iso_2' => 'SL',
                'iso_3' => 'SLE',
                'phone_code' => 232,

            ],
            [
                'name' => 'Singapore',
                'iso_2' => 'SG',
                'iso_3' => 'SGP',
                'phone_code' => 65,

            ],
            [
                'name' => 'Sint Maarten',
                'iso_2' => 'SX',
                'iso_3' => 'SXM',
                'phone_code' => '1-721',

            ],
            [
                'name' => 'Slovakia',
                'iso_2' => 'SK',
                'iso_3' => 'SVK',
                'phone_code' => 421,

            ],
            [
                'name' => 'Slovenia',
                'iso_2' => 'SI',
                'iso_3' => 'SVN',
                'phone_code' => 386,

            ],
            [
                'name' => 'Solomon Islands',
                'iso_2' => 'SB',
                'iso_3' => 'SLB',
                'phone_code' => 677,

            ],
            [
                'name' => 'Somalia',
                'iso_2' => 'SO',
                'iso_3' => 'SOM',
                'phone_code' => 252,

            ],
            [
                'name' => 'South Africa',
                'iso_2' => 'ZA',
                'iso_3' => 'ZAF',
                'phone_code' => 27,

            ],
            [
                'name' => 'South Korea',
                'iso_2' => 'KR',
                'iso_3' => 'KOR',
                'phone_code' => 82,

            ],
            [
                'name' => 'South Sudan',
                'iso_2' => 'SS',
                'iso_3' => 'SSD',
                'phone_code' => 211,

            ],
            [
                'name' => 'Spain',
                'iso_2' => 'ES',
                'iso_3' => 'ESP',
                'phone_code' => 34,

            ],
            [
                'name' => 'Sri Lanka',
                'iso_2' => 'LK',
                'iso_3' => 'LKA',
                'phone_code' => 94,

            ],
            [
                'name' => 'Sudan',
                'iso_2' => 'SD',
                'iso_3' => 'SDN',
                'phone_code' => 249,

            ],
            [
                'name' => 'Suriname',
                'iso_2' => 'SR',
                'iso_3' => 'SUR',
                'phone_code' => 597,

            ],
            [
                'name' => 'Svalbard and Jan Mayen',
                'iso_2' => 'SJ',
                'iso_3' => 'SJM',
                'phone_code' => 47,

            ],
            [
                'name' => 'Swaziland',
                'iso_2' => 'SZ',
                'iso_3' => 'SWZ',
                'phone_code' => 268,

            ],
            [
                'name' => 'Sweden',
                'iso_2' => 'SE',
                'iso_3' => 'SWE',
                'phone_code' => 46,

            ],
            [
                'name' => 'Switzerland',
                'iso_2' => 'CH',
                'iso_3' => 'CHE',
                'phone_code' => 41,

            ],
            [
                'name' => 'Syria',
                'iso_2' => 'SY',
                'iso_3' => 'SYR',
                'phone_code' => 963,

            ],
            [
                'name' => 'Taiwan',
                'iso_2' => 'TW',
                'iso_3' => 'TWN',
                'phone_code' => 886,

            ],
            [
                'name' => 'Tajikistan',
                'iso_2' => 'TJ',
                'iso_3' => 'TJK',
                'phone_code' => 992,

            ],
            [
                'name' => 'Tanzania',
                'iso_2' => 'TZ',
                'iso_3' => 'TZA',
                'phone_code' => 255,

            ],
            [
                'name' => 'Thailand',
                'iso_2' => 'TH',
                'iso_3' => 'THA',
                'phone_code' => 66,

            ],
            [
                'name' => 'Togo',
                'iso_2' => 'TG',
                'iso_3' => 'TGO',
                'phone_code' => 228,

            ],
            [
                'name' => 'Tokelau',
                'iso_2' => 'TK',
                'iso_3' => 'TKL',
                'phone_code' => 690,

            ],
            [
                'name' => 'Tonga',
                'iso_2' => 'TO',
                'iso_3' => 'TON',
                'phone_code' => 676,

            ],
            [
                'name' => 'Trinidad and Tobago',
                'iso_2' => 'TT',
                'iso_3' => 'TTO',
                'phone_code' => '1-868',

            ],
            [
                'name' => 'Tunisia',
                'iso_2' => 'TN',
                'iso_3' => 'TUN',
                'phone_code' => 216,

            ],
            [
                'name' => 'Turkey',
                'iso_2' => 'TR',
                'iso_3' => 'TUR',
                'phone_code' => 90,

            ],
            [
                'name' => 'Turkmenistan',
                'iso_2' => 'TM',
                'iso_3' => 'TKM',
                'phone_code' => 993,

            ],
            [
                'name' => 'Turks and Caicos Islands',
                'iso_2' => 'TC',
                'iso_3' => 'TCA',
                'phone_code' => '1-649',

            ],
            [
                'name' => 'Tuvalu',
                'iso_2' => 'TV',
                'iso_3' => 'TUV',
                'phone_code' => 688,

            ],
            [
                'name' => 'U.S. Virgin Islands',
                'iso_2' => 'VI',
                'iso_3' => 'VIR',
                'phone_code' => '1-340',

            ],
            [
                'name' => 'Uganda',
                'iso_2' => 'UG',
                'iso_3' => 'UGA',
                'phone_code' => 256,

            ],
            [
                'name' => 'Ukraine',
                'iso_2' => 'UA',
                'iso_3' => 'UKR',
                'phone_code' => 380,

            ],
            [
                'name' => 'United Arab Emirates',
                'iso_2' => 'AE',
                'iso_3' => 'ARE',
                'phone_code' => 971,

            ],
            [
                'name' => 'United Kingdom',
                'iso_2' => 'GB',
                'iso_3' => 'GBR',
                'phone_code' => 44,

            ],
            [
                'name' => 'United States',
                'iso_2' => 'US',
                'iso_3' => 'USA',
                'phone_code' => 1,

            ],
            [
                'name' => 'Uruguay',
                'iso_2' => 'UY',
                'iso_3' => 'URY',
                'phone_code' => 598,

            ],
            [
                'name' => 'Uzbekistan',
                'iso_2' => 'UZ',
                'iso_3' => 'UZB',
                'phone_code' => 998,

            ],
            [
                'name' => 'Vanuatu',
                'iso_2' => 'VU',
                'iso_3' => 'VUT',
                'phone_code' => 678,

            ],
            [
                'name' => 'Vatican',
                'iso_2' => 'VA',
                'iso_3' => 'VAT',
                'phone_code' => 379,

            ],
            [
                'name' => 'Venezuela',
                'iso_2' => 'VE',
                'iso_3' => 'VEN',
                'phone_code' => 58,

            ],
            [
                'name' => 'Vietnam',
                'iso_2' => 'VN',
                'iso_3' => 'VNM',
                'phone_code' => 84,

            ],
            [
                'name' => 'Wallis and Futuna',
                'iso_2' => 'WF',
                'iso_3' => 'WLF',
                'phone_code' => 681,

            ],
            [
                'name' => 'Western Sahara',
                'iso_2' => 'EH',
                'iso_3' => 'ESH',
                'phone_code' => 212,

            ],
            [
                'name' => 'Yemen',
                'iso_2' => 'YE',
                'iso_3' => 'YEM',
                'phone_code' => 967,

            ],
            [
                'name' => 'Zambia',
                'iso_2' => 'ZM',
                'iso_3' => 'ZMB',
                'phone_code' => 260,

            ],
            [
                'name' => 'Zimbabwe',
                'iso_2' => 'ZW',
                'iso_3' => 'ZWE',
                'phone_code' => 263,

            ],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                [
                    'name' => $country['name'],
                    'phone_code' => $country['phone_code'],
                    'iso_2' => $country['iso_2'],
                    'iso_3' => $country['iso_3'],
                ]
            );
        }
    }
}
