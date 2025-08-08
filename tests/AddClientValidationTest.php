<?php

use PHPUnit\Framework\TestCase;

class AddClientValidationTest extends TestCase
{
    private string $script;

    protected function setUp(): void
    {
        $this->script = __DIR__ . '/../public/add_client.php';
    }

    private function runScript(array $post): string
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = $post;
        putenv('TEST_MODE=1');
        $cwd = getcwd();
        chdir(__DIR__ . '/../public');
        ob_start();
        include 'add_client.php';
        $output = ob_get_clean();
        chdir($cwd);
        return $output;
    }

    public function testInvalidPhoneShowsError(): void
    {
        $output = $this->runScript([
            'firstName' => 'Jan',
            'lastName'  => 'Kowalski',
            'company'   => 'Firma',
            'phone'     => '123abc456',
        ]);

        $this->assertStringContainsString('Uzupełnij wszystkie pola poprawnie (9 cyfr).', $output);
    }

    public function testValidDataShowsSuccess(): void
    {
        $output = $this->runScript([
            'firstName' => 'Jan',
            'lastName'  => 'Kowalski',
            'company'   => 'Firma',
            'phone'     => '123456789',
        ]);

        $this->assertStringContainsString('Klient dodany pomyślnie!', $output);
    }
}
