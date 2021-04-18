<?php declare(strict_types=1);

namespace App\Models;

class Iban
{
    /**
     * @var string
     */
    protected string $ibanNumber;

    /**
     * @var int
     */
    protected int $bban;

    /**
     * @var int
     */
    protected int $bankIdentifier;

    /**
     * Iban constructor.
     * @param \Iban\Validation\Iban $iban
     */
    public function __construct(\Iban\Validation\Iban $iban)
    {
        $this->ibanNumber = $iban->format(\Iban\Validation\Iban::FORMAT_PRINT);
        $this->bban = (int)$iban->bban();
        $this->bankIdentifier = (int)$iban->bbanBankIdentifier();
    }

    /**
     * @return string
     */
    public function getIbanNumber(): string
    {
        return $this->ibanNumber;
    }

    /**
     * @param string $ibanNumber
     */
    public function setIbanNumber(string $ibanNumber): void
    {
        $this->ibanNumber = $ibanNumber;
    }

    /**
     * @return int
     */
    public function getBban(): int
    {
        return $this->bban;
    }

    /**
     * @param int $bban
     */
    public function setBban(int $bban): void
    {
        $this->bban = $bban;
    }

    /**
     * @return int
     */
    public function getBankIdentifier(): int
    {
        return $this->bankIdentifier;
    }

    /**
     * @param int $bankIdentifier
     */
    public function setBankIdentifier(int $bankIdentifier): void
    {
        $this->ibanNumber = $bankIdentifier;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country)
    {
        $this->country = $country;
    }
}