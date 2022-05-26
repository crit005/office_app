<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('country_and_currency');
            $table->string('code');
            $table->string('symbol');
            $table->string('status')->default('ENABLED');
            $table->integer('oder')->default(0);
        });

        DB::table('currencies')->insert(
            array(
                ['country_and_currency' => 'Albania Lek', 'code' => 'ALL', 'symbol' => 'Lek', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Afghanistan Afghani', 'code' => 'AFN', 'symbol' => '؋', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Argentina Peso', 'code' => 'ARS', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Aruba Guilder', 'code' => 'AWG', 'symbol' => 'ƒ', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Australia Dollar', 'code' => 'AUD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Azerbaijan Manat', 'code' => 'AZN', 'symbol' => '₼', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Bahamas Dollar', 'code' => 'BSD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Barbados Dollar', 'code' => 'BBD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Belarus Ruble', 'code' => 'BYN', 'symbol' => 'Br', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Belize Dollar', 'code' => 'BZD', 'symbol' => 'BZ$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Bermuda Dollar', 'code' => 'BMD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Bolivia Bolíviano', 'code' => 'BOB', 'symbol' => '$b', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Bosnia and Herzegovina Convertible Mark', 'code' => 'BAM', 'symbol' => 'KM', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Botswana Pula', 'code' => 'BWP', 'symbol' => 'P', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Bulgaria Lev', 'code' => 'BGN', 'symbol' => 'лв', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Brazil Real', 'code' => 'BRL', 'symbol' => 'R$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Brunei Darussalam Dollar', 'code' => 'BND', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Cambodia Riel', 'code' => 'KHR', 'symbol' => '៛', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Canada Dollar', 'code' => 'CAD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Cayman Islands Dollar', 'code' => 'KYD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Chile Peso', 'code' => 'CLP', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'China Yuan Renminbi', 'code' => 'CNY', 'symbol' => '¥', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Colombia Peso', 'code' => 'COP', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Costa Rica Colon', 'code' => 'CRC', 'symbol' => '₡', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Croatia Kuna', 'code' => 'HRK', 'symbol' => 'kn', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Cuba Peso', 'code' => 'CUP', 'symbol' => '₱', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Czech Republic Koruna', 'code' => 'CZK', 'symbol' => 'Kč', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Denmark Krone', 'code' => 'DKK', 'symbol' => 'kr', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Dominican Republic Peso', 'code' => 'DOP', 'symbol' => 'RD$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'East Caribbean Dollar', 'code' => 'XCD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Egypt Pound', 'code' => 'EGP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'El Salvador Colon', 'code' => 'SVC', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Euro Member Countries', 'code' => 'EUR', 'symbol' => '€', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Falkland Islands (Malvinas) Pound', 'code' => 'FKP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Fiji Dollar', 'code' => 'FJD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Ghana Cedi', 'code' => 'GHS', 'symbol' => '¢', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Gibraltar Pound', 'code' => 'GIP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Guatemala Quetzal', 'code' => 'GTQ', 'symbol' => 'Q', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Guernsey Pound', 'code' => 'GGP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Guyana Dollar', 'code' => 'GYD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Honduras Lempira', 'code' => 'HNL', 'symbol' => 'L', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Hong Kong Dollar', 'code' => 'HKD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Hungary Forint', 'code' => 'HUF', 'symbol' => 'Ft', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Iceland Krona', 'code' => 'ISK', 'symbol' => 'kr', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'India Rupee', 'code' => 'INR', 'symbol' => '₹', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Indonesia Rupiah', 'code' => 'IDR', 'symbol' => 'Rp', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Iran Rial', 'code' => 'IRR', 'symbol' => '﷼', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Isle of Man Pound', 'code' => 'IMP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Israel Shekel', 'code' => 'ILS', 'symbol' => '₪', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Jamaica Dollar', 'code' => 'JMD', 'symbol' => 'J$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Japan Yen', 'code' => 'JPY', 'symbol' => '¥', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Jersey Pound', 'code' => 'JEP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Kazakhstan Tenge', 'code' => 'KZT', 'symbol' => 'лв', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Korea (North) Won', 'code' => 'KPW', 'symbol' => '₩', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Korea (South) Won', 'code' => 'KRW', 'symbol' => '₩', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Kyrgyzstan Som', 'code' => 'KGS', 'symbol' => 'лв', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Laos Kip', 'code' => 'LAK', 'symbol' => '₭', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Lebanon Pound', 'code' => 'LBP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Liberia Dollar', 'code' => 'LRD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Macedonia Denar', 'code' => 'MKD', 'symbol' => 'ден', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Malaysia Ringgit', 'code' => 'MYR', 'symbol' => 'RM', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Mauritius Rupee', 'code' => 'MUR', 'symbol' => '₨', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Mexico Peso', 'code' => 'MXN', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Mongolia Tughrik', 'code' => 'MNT', 'symbol' => '₮', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Moroccan-dirham', 'code' => 'MNT', 'symbol' => ' د.إ', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Mozambique Metical', 'code' => 'MZN', 'symbol' => 'MT', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Namibia Dollar', 'code' => 'NAD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Nepal Rupee', 'code' => 'NPR', 'symbol' => '₨', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Netherlands Antilles Guilder', 'code' => 'ANG', 'symbol' => 'ƒ', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'New Zealand Dollar', 'code' => 'NZD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Nicaragua Cordoba', 'code' => 'NIO', 'symbol' => 'C$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Nigeria Naira', 'code' => 'NGN', 'symbol' => '₦', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Norway Krone', 'code' => 'NOK', 'symbol' => 'kr', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Oman Rial', 'code' => 'OMR', 'symbol' => '﷼', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Pakistan Rupee', 'code' => 'PKR', 'symbol' => '₨', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Panama Balboa', 'code' => 'PAB', 'symbol' => 'B/.', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Paraguay Guarani', 'code' => 'PYG', 'symbol' => 'Gs', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Peru Sol', 'code' => 'PEN', 'symbol' => 'S/.', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Philippines Peso', 'code' => 'PHP', 'symbol' => '₱', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Poland Zloty', 'code' => 'PLN', 'symbol' => 'zł', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Qatar Riyal', 'code' => 'QAR', 'symbol' => '﷼', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Romania Leu', 'code' => 'RON', 'symbol' => 'lei', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Russia Ruble', 'code' => 'RUB', 'symbol' => '₽', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Saint Helena Pound', 'code' => 'SHP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Saudi Arabia Riyal', 'code' => 'SAR', 'symbol' => '﷼', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Serbia Dinar', 'code' => 'RSD', 'symbol' => 'Дин.', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Seychelles Rupee', 'code' => 'SCR', 'symbol' => '₨', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Singapore Dollar', 'code' => 'SGD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Solomon Islands Dollar', 'code' => 'SBD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Somalia Shilling', 'code' => 'SOS', 'symbol' => 'S', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'South Korean Won', 'code' => 'KRW', 'symbol' => '₩', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'South Africa Rand', 'code' => 'ZAR', 'symbol' => 'R', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Sri Lanka Rupee', 'code' => 'LKR', 'symbol' => '₨', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Sweden Krona', 'code' => 'SEK', 'symbol' => 'kr', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Switzerland Franc', 'code' => 'CHF', 'symbol' => 'CHF', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Suriname Dollar', 'code' => 'SRD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Syria Pound', 'code' => 'SYP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Taiwan New Dollar', 'code' => 'TWD', 'symbol' => 'NT$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Thailand Baht', 'code' => 'THB', 'symbol' => '฿', 'status' => 'ENABLED', 'oder' => 2],
                ['country_and_currency' => 'Trinidad and Tobago Dollar', 'code' => 'TTD', 'symbol' => 'TT$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Turkey Lira', 'code' => 'TRY', 'symbol' => '₺', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Tuvalu Dollar', 'code' => 'TVD', 'symbol' => '$', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Ukraine Hryvnia', 'code' => 'UAH', 'symbol' => '₴', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'UAE-Dirham', 'code' => 'AED', 'symbol' => ' د.إ', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'United Kingdom Pound', 'code' => 'GBP', 'symbol' => '£', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'United States Dollar', 'code' => 'USD', 'symbol' => '$', 'status' => 'ENABLED', 'oder' => 1],
                ['country_and_currency' => 'Uruguay Peso', 'code' => 'UYU', 'symbol' => '$U', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Uzbekistan Som', 'code' => 'UZS', 'symbol' => 'лв', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Venezuela Bolívar', 'code' => 'VEF', 'symbol' => 'Bs', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Viet Nam Dong', 'code' => 'VND', 'symbol' => '₫', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Yemen Rial', 'code' => 'YER', 'symbol' => '﷼', 'status' => 'DISABLED', 'oder' => 0],
                ['country_and_currency' => 'Zimbabwe Dollar', 'code' => 'ZWD', 'symbol' => 'Z$', 'status' => 'DISABLED', 'oder' => 0]
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
