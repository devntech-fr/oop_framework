<?php

class IndexTest
{
    public function testHello()
    {
        $_GET['name'] = "Toto";
        ob_start();
        include 'index.php';
        $content = ob_get_clean();
//        $this->assertEquals("Hello Toto", $content);
    }
}
