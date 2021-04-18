<?php declare(strict_types=1);

use Iban\Validation\Iban;
use Iban\Validation\Validator;
use PHPUnit\Framework\TestCase;

final class IbanValidationTests extends TestCase
{
    /**
     * @var Iban $iban
     */
    private Iban $iban;

    /**
     * @var Validator
     */
    private Validator $validator;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->validator = new Validator();
        //valid IBAN
        $this->iban = new Iban('LV97HABA0012345678910');
    }

    /**
     * @return void
     */
    public function testValidIban()
    {
        //test string
        $this->assertTrue($this->validator->validate('LV97HABA0012345678910'));
    }

    /**
     * @return void
     */
    public function testInvalidIban()
    {
        $invalidIban = 'PEW111321312312321';
        $this->assertFalse($this->validator->validate($invalidIban));
    }

    /**
     * @param string $iban
     * @param string $countryCode
     * @param string $bban
     * @param string $bbanIdentifier
     * @dataProvider ibanProvider
     *
     * @return void
     */
    public function testIbanInitializer(
        string $iban,
        string $countryCode,
        string $bban,
        string $bbanIdentifier
    ) {
        $iban = new Iban($iban);

        $this->assertEquals($countryCode, $iban->countryCode());
        $this->assertEquals($bban, $iban->bban());
        $this->assertEquals($bbanIdentifier, $iban->bbanBankIdentifier());
    }

    /**
     * @return Generator
     */
    public function ibanProvider(): Generator
    {
        yield [
            'IBAN LV97HABA0012345678910',
            'LV',
            'HABA0012345678910',
            'HABA'
        ];
    }
}