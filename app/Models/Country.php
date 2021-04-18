<?php declare(strict_types=1);

namespace App\Models;

use NNV\RestCountries;

class Country
{
    /**
     * @var string
     */
    protected string $countryName;

    /**
     * @var string
     */
    protected string $capitalCity;

    /**
     * @var string
     */
    protected string $region;

    /**
     * @var array
     */
    protected array $currencyDetails;

    public function __construct(string $countryCode)
    {
        $restCountries = new RestCountries;

        /** @var \stdClass $countryInfo */
        $countryInfo = $restCountries->byCodes(strtolower($countryCode));

        $this->countryName = $countryInfo->name;
        $this->capitalCity = $countryInfo->capital;
        $this->region = $countryInfo->region;
        $this->currencyDetails = $countryInfo->currencies;
    }

    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * @param string $countryName
     */
    public function setCountryName(string $countryName)
    {
        $this->countryName = $countryName;
    }

    /**
     * @return string
     */
    public function getCapitalCity(): string
    {
        return $this->capitalCity;
    }

    /**
     * @param string $capitalCity
     */
    public function setCapitalCity(string $capitalCity)
    {
        $this->capitalCity = $capitalCity;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region)
    {
        $this->region = $region;
    }

    /**
     * @return array
     */
    public function getCurrencyDetails(): array
    {
        return $this->currencyDetails;
    }

    /**
     * @param array $currencyDetails
     */
    public function setCurrencyDetails(array $currencyDetails)
    {
        $this->currencyDetails = $currencyDetails;
    }
}