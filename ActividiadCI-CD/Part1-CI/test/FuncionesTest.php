<?php 

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/funciones.php';

class FuncionesTest extends TestCase {
    public function testSumar() {
        $this->assertEquals(4, sumar(2,2));
        $this->assertEquals(0, sumar(-1, 1));
    }
}
?>