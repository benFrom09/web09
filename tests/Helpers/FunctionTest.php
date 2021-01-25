<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Response;

class FunctionTest extends TestCase
{
    public function setUp():void {
        $this->response = new Response();
    }
    public function test_view_function_render_file() {
        $view = view($this->response,'pages.example',['name' =>'Twig']);
        $this->assertInstanceOf(Response::class,$view);
        $this->assertEquals($view->getStatusCode(),200);
        
    }
    public function test_view_function_return_exception() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("VIEW_RENDERER_Exception: cannot find pages/exam.html.twig");
        $view = view($this->response,'pages.exam',['name' =>'Twig']);
        
    }
}