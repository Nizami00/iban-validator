<?php declare(strict_types=1);

namespace App\Services;

use App\Logger;
use App\Models\Country;
use Iban\Validation\CountryInfo;
use Iban\Validation\Validator;
use Iban\Validation\Iban;
use NNV\RestCountries;

class InputInitializeService
{
    /**
     * Show user input validation
     */
    const INPUT_VALIDATION_ERROR = 'Please input correct data!';

    /**
     * Exception response to user
     */
    const INITIALIZING_ERROR = 'Something went wrong, conctact us';

    /**
     * @var \App\Models\Iban|null
     */
    protected ?\App\Models\Iban $iban = null;

    /**
     * @var Country|null
     */
    protected ?Country $country = null;

    /**
     * @var null|string
     */
    protected ?string $violationMessage = null;

    /**
     * @return \App\Models\Iban|null
     */
    public function getIban(): ?\App\Models\Iban
    {
        return $this->iban;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @return null|string
     */
    public function getViolationMessage(): ?string
    {
        return $this->violationMessage;
    }

    /**
     * @param string $iban
     * @param bool $inputViolation
     * @return void
     * @throws \Exception
     */
    public function processIbanInput(string $iban, bool $inputViolation): void
    {
        $isIban = null;

        //if input violation is present don't send request
        try {
            if ($inputViolation) {
                $this->violationMessage = self::INPUT_VALIDATION_ERROR;
            } else {
                $isIban = $this->initializeIban($iban);
            }

            if ($isIban) {
                if ($isIban instanceof Iban) {
                    $this->iban = new \App\Models\Iban($isIban);
                    $this->country = new Country($isIban->countryCode());
                }else {
                    $this->violationMessage = $isIban;
                }
            }
        } catch (\Exception $e) {
            Logger::getLogger()->log($e->getMessage());
            $this->violationMessage = self::INITIALIZING_ERROR;
        }
    }

    /**
     * Validate and return response from api
     *
     * @param string $iban
     * @return string|Iban
     */
    private function initializeIban(string $iban)
    {
        $iban = trim($iban);
        $iban = new Iban($iban);
        $validator = new Validator();

        $violationMessage = null;

        if (!$validator->validate($iban)) {
            foreach ($validator->getViolations() as $violation) {
                $violationMessage = $violation;
            }
        }

        return $violationMessage ?? $iban;
    }
}