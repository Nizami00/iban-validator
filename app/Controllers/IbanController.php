<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\InputInitializeService;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Iban\Validation\Validator;
use Iban\Validation\Iban;
use App\Services\ValidationService;

class IbanController
{

    public function view()
    {
        return require_once __DIR__ . '/../Views/main.view.php';
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function validate()
    {
        $iban = $_POST['iban'] ?? null;
        $validationService = new ValidationService();
        $inputViolation = $validationService->validateInput($iban);

        $inputInitializeService = new InputInitializeService();
        $inputInitializeService->processIbanInput($iban, $inputViolation);

        $data = [
            'iban' => $inputInitializeService->getIban(),
            'country' => $inputInitializeService->getCountry(),
            'violationMessage' => $inputInitializeService->getViolationMessage()
        ];

        return require_once __DIR__ . '/../Views/main.view.php';
    }
}