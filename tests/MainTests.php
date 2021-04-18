<?php declare(strict_types=1);

use App\Logger;
use App\Services\InputInitializeService;
use App\Services\ValidationService;
use PHPUnit\Framework\TestCase;

final class MainTests extends TestCase
{
    public function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__);
    }

    /**
     * @dataProvider inputProvider
     */
    public function testInputValidatorService(string $html, string $blankInput, string $valid)
    {
        $validationService = new ValidationService();

        $this->assertTrue($validationService->validateInput($html));
        $this->assertTrue($validationService->validateInput($blankInput));
        $this->assertFalse($validationService->validateInput($valid));
    }

    /**
     * @throws Exception
     */
    public function testValidationMessage()
    {
        $inputInitializeService = new InputInitializeService();
        $inputInitializeService->processIbanInput('LV97HABA0012345678910', true);

        $this->assertEquals('Please input correct data!', $inputInitializeService->getViolationMessage());
    }

    /**
     * @throws Exception
     */
    public function testObjectCreation()
    {
        $inputInitializeServiceValid = new InputInitializeService();
        $inputInitializeServiceValid->processIbanInput('LV97HABA0012345678910', false);

        $this->assertInstanceOf(\App\Models\Iban::class, $inputInitializeServiceValid->getIban());
        $this->assertInstanceOf(\App\Models\Country::class, $inputInitializeServiceValid->getCountry());
    }

    public function testInvalidObjectCreation()
    {
        $inputInitializeServiceInvalid = new InputInitializeService();
        $inputInitializeServiceInvalid->processIbanInput('PEW111111', false);

        $this->assertNull($inputInitializeServiceInvalid->getIban());
        $this->assertNull($inputInitializeServiceInvalid->getCountry());
        $this->assertIsString($inputInitializeServiceInvalid->getViolationMessage());
    }

    public function testLogger()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $e = new Exception('This is test of Logger');
        Logger::getLogger()->log($e->getMessage());
        $this->assertStringNotEqualsFile($_ENV['ROOT_PATH'] . '/logs/iban_app.log', '');

    }

    /**
     * @return Generator
     */
    public function inputProvider(): Generator
    {
        yield [
            'h1>test</h1>',
            '   ',
            'LV97HABA0012345678910'
        ];
    }
}