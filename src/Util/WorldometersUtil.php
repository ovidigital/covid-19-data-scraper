<?php

namespace OviDigital\Covid19DataScraper\Util;

class WorldometersUtil {

    public static function getCountryUrl(string $countryCode)
    {
        $slugs = self::getCountrySlugs();

        if (!isset($slugs[$countryCode])) {
            throw new \InvalidArgumentException('Could not find country slug for provided country code.');
        }

        return sprintf('https://www.worldometers.info/coronavirus/country/%s/', $slugs[$countryCode]);
    }

    /**
     * Get the country slugs indexed by country code.
     *
     * ```js
     * var data = [];
     * jQuery('#main_table_countries_today a.mt_a').each(function(){
     *   var urlParts = this.href.split('/');
     *   data.push(urlParts[urlParts.length -2]);
     * });
     * console.log("'" + data.join("',\n'") + "',");
     * ```
     */
    public static function getCountrySlugs()
    {
        return [
            'AF' => 'afghanistan',
            'AL' => 'albania',
            'DZ' => 'algeria',
            'AD' => 'andorra',
            'AO' => 'angola',
            'AI' => 'anguilla',
            'AG' => 'antigua-and-barbuda',
            'AR' => 'argentina',
            'AM' => 'armenia',
            'AW' => 'aruba',
            'AU' => 'australia',
            'AT' => 'austria',
            'AZ' => 'azerbaijan',
            'BS' => 'bahamas',
            'BH' => 'bahrain',
            'BD' => 'bangladesh',
            'BB' => 'barbados',
            'BY' => 'belarus',
            'BE' => 'belgium',
            'BZ' => 'belize',
            'BJ' => 'benin',
            'BM' => 'bermuda',
            'BT' => 'bhutan',
            'BO' => 'bolivia',
            'BA' => 'bosnia-and-herzegovina',
            'BW' => 'botswana',
            'BR' => 'brazil',
            'IO' => 'british-virgin-islands',
            'BN' => 'brunei-darussalam',
            'BG' => 'bulgaria',
            'BF' => 'burkina-faso',
            'BI' => 'burundi',
            'CV' => 'cabo-verde',
            'KH' => 'cambodia',
            'CM' => 'cameroon',
            'CA' => 'canada',
            'CF' => 'central-african-republic',
            'BQ' => 'caribbean-netherlands',
            'KY' => 'cayman-islands',
            'TD' => 'chad',
            //'' => 'channel-islands',
            'CL' => 'chile',
            'CN' => 'china',
            'CO' => 'colombia',
            'CG' => 'congo',
            'CR' => 'costa-rica',
            'HR' => 'croatia',
            'CU' => 'cuba',
            'CW' => 'curacao',
            'CY' => 'cyprus',
            'CZ' => 'czech-republic',
            'DK' => 'denmark',
            'DJ' => 'djibouti',
            'DM' => 'dominica',
            'DO' => 'dominican-republic',
            'CD' => 'democratic-republic-of-the-congo',
            'EC' => 'ecuador',
            'EG' => 'egypt',
            'SV' => 'el-salvador',
            'GQ' => 'equatorial-guinea',
            'ER' => 'eritrea',
            'EE' => 'estonia',
            'SZ' => 'swaziland',
            'ET' => 'ethiopia',
            'FO' => 'faeroe-islands',
            'FK' => 'falkland-islands-malvinas',
            'FJ' => 'fiji',
            'FI' => 'finland',
            'FR' => 'france',
            'GF' => 'french-guiana',
            'PF' => 'french-polynesia',
            'GA' => 'gabon',
            'GM' => 'gambia',
            'GE' => 'georgia',
            'DE' => 'germany',
            'GH' => 'ghana',
            'GI' => 'gibraltar',
            'GR' => 'greece',
            'GD' => 'grenada',
            'GP' => 'guadeloupe',
            'GT' => 'guatemala',
            'GN' => 'guinea',
            'GW' => 'guinea-bissau',
            'GY' => 'guyana',
            'HT' => 'haiti',
            'HN' => 'honduras',
            'HK' => 'china-hong-kong-sar',
            'HU' => 'hungary',
            'IS' => 'iceland',
            'IN' => 'india',
            'ID' => 'indonesia',
            'IR' => 'iran',
            'IQ' => 'iraq',
            'IE' => 'ireland',
            'IM' => 'isle-of-man',
            'IL' => 'israel',
            'IT' => 'italy',
            'CI' => 'cote-d-ivoire',
            'JM' => 'jamaica',
            'JP' => 'japan',
            'JO' => 'jordan',
            'KZ' => 'kazakhstan',
            'KE' => 'kenya',
            'KW' => 'kuwait',
            'KG' => 'kyrgyzstan',
            'LA' => 'laos',
            'LV' => 'latvia',
            'LB' => 'lebanon',
            'LR' => 'liberia',
            'LY' => 'libya',
            'LI' => 'liechtenstein',
            'LT' => 'lithuania',
            'LU' => 'luxembourg',
            'MO' => 'china-macao-sar',
            'MG' => 'madagascar',
            'MW' => 'malawi',
            'MY' => 'malaysia',
            'MV' => 'maldives',
            'ML' => 'mali',
            'MT' => 'malta',
            'MQ' => 'martinique',
            'MR' => 'mauritania',
            'MU' => 'mauritius',
            'YT' => 'mayotte',
            'MX' => 'mexico',
            'MD' => 'moldova',
            'MC' => 'monaco',
            'MN' => 'mongolia',
            'ME' => 'montenegro',
            'MS' => 'montserrat',
            'MA' => 'morocco',
            'MZ' => 'mozambique',
            'MM' => 'myanmar',
            'NA' => 'namibia',
            'NP' => 'nepal',
            'NL' => 'netherlands',
            'NC' => 'new-caledonia',
            'NZ' => 'new-zealand',
            'NI' => 'nicaragua',
            'NE' => 'niger',
            'NG' => 'nigeria',
            'MK' => 'macedonia',
            'NO' => 'norway',
            'OM' => 'oman',
            'PK' => 'pakistan',
            'PW' => 'state-of-palestine',
            'PA' => 'panama',
            'PG' => 'papua-new-guinea',
            'PY' => 'paraguay',
            'PE' => 'peru',
            'PH' => 'philippines',
            'PL' => 'poland',
            'PT' => 'portugal',
            'QA' => 'qatar',
            'RO' => 'romania',
            'RU' => 'russia',
            'RW' => 'rwanda',
            'RE' => 'reunion',
            'KR' => 'south-korea',
            'KN' => 'saint-kitts-and-nevis',
            'LC' => 'saint-lucia',
            'MF' => 'saint-martin',
            'PM' => 'saint-pierre-and-miquelon',
            'SM' => 'san-marino',
            'ST' => 'sao-tome-and-principe',
            'SA' => 'saudi-arabia',
            'SN' => 'senegal',
            'RS' => 'serbia',
            'SC' => 'seychelles',
            'SL' => 'sierra-leone',
            'SG' => 'singapore',
            'SX' => 'sint-maarten',
            'SK' => 'slovakia',
            'SI' => 'slovenia',
            'SO' => 'somalia',
            'ZA' => 'south-africa',
            'SS' => 'south-sudan',
            'ES' => 'spain',
            'LK' => 'sri-lanka',
            'BL' => 'saint-barthelemy',
            'VC' => 'saint-vincent-and-the-grenadines',
            'SD' => 'sudan',
            'SR' => 'suriname',
            'SE' => 'sweden',
            'CH' => 'switzerland',
            'SY' => 'syria',
            'TW' => 'taiwan',
            'TZ' => 'tanzania',
            'TH' => 'thailand',
            'TL' => 'timor-leste',
            'TG' => 'togo',
            'TT' => 'trinidad-and-tobago',
            'TN' => 'tunisia',
            'TR' => 'turkey',
            'TC' => 'turks-and-caicos-islands',
            'AE' => 'united-arab-emirates',
            'UG' => 'uganda',
            'GB' => 'uk',
            'UA' => 'ukraine',
            'UY' => 'uruguay',
            'US' => 'us',
            'UZ' => 'uzbekistan',
            'VA' => 'holy-see',
            'VE' => 'venezuela',
            'VN' => 'viet-nam',
            'EH' => 'western-sahara',
            'YE' => 'yemen',
            'ZM' => 'zambia',
            'ZW' => 'zimbabwe',
        ];
    }
}
