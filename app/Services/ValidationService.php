<?php declare(strict_types=1);

namespace App\Services;

class ValidationService
{
    /**
     * @param string $input
     * @return bool
     */
    public function validateInput(string $input): bool
    {
        if(trim($input) == '' || $this->inputIsHtml($input)) {
            return true;
        }

        return false;
    }

    /**
     * Check for special chars in input
     * @param string $input
     * @return bool
     */
    private function inputIsHtml(string $input): bool
    {
        if (!is_array($input)) {
            if ($input !== strip_tags($input)) {
                return true;
            }
        }

        return false;
    }

}