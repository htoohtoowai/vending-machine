<?php
namespace Web\Tests;

use PHPUnit\Framework\TestCase;
use Web\Controllers\ProductsController;
use Web\Models\Product;
use Web\Models\Transaction;
use Web\Traits\AdminCheckTrait;
use PHPUnit\Framework\MockObject\MockObject;

class ProductsControllerTest extends TestCase
{
    private ProductsController $controller;
    private MockObject $productModel;
    private MockObject $transactionModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productModel = $this->createMock(Product::class);
        $this->transactionModel = $this->createMock(Transaction::class);

        $this->controller = new ProductsController();
        $this->controller->model = $this->productModel;
        $this->controller->modelTransaction = $this->transactionModel;
    }

    public function testIndex(): void
    {
        $this->productModel->method('all')->willReturn([]);
        $this->productModel->method('count')->willReturn(0);

        ob_start();
        $this->controller->index();
        $output = ob_get_clean();

        $this->assertStringContainsString('views/product/list.php', $output);
    }

    public function testCreatePostSuccess(): void
    {
        $this->productModel->expects($this->once())
            ->method('create')
            ->with('Product A', 100.00, 10);

        $_POST['name'] = 'Product A';
        $_POST['price'] = 100.00;
        $_POST['quantity'] = 10;

        $_SESSION = [];

        $this->controller->create();

        $this->assertEquals('Product created successfully!', $_SESSION['success_message']);
    }

    public function testCreatePostValidationFailure(): void
    {
        $_POST['name'] = '';
        $_POST['price'] = 'invalid';
        $_POST['quantity'] = -1;

        $this->expectException(\InvalidArgumentException::class);

        $this->controller->create();
    }

    public function testUpdatePostSuccess(): void
    {
        $this->productModel->expects($this->once())
            ->method('update')
            ->with(1, 'Updated Product', 150.00, 15);

        $_POST['name'] = 'Updated Product';
        $_POST['price'] = 150.00;
        $_POST['quantity'] = 15;

        $_SESSION = [];

        $this->controller->update(1);

        $this->assertEquals('Product updated successfully!', $_SESSION['success_message']);
    }

    public function testDeleteSuccess(): void
    {
        $this->productModel->expects($this->once())
            ->method('delete')
            ->with(1);

        $_SESSION = [];

        $this->controller->delete(1);

        $this->assertEquals('Product deleted successfully!', $_SESSION['success_message']);
    }

    public function testPurchaseSuccess(): void
    {
        $this->productModel->method('get')->willReturn(['id' => 1, 'name' => 'Product A', 'price' => 100.00, 'quantity_available' => 10]);
        $this->productModel->expects($this->once())
            ->method('update')
            ->with(1, 'Product A', 100.00, 5);
        $this->transactionModel->expects($this->once())
            ->method('log')
            ->with(1, 1, 5, 500.00);

        $_SESSION = [];

        $this->controller->purchase(1, 1, 5);

        $this->assertEquals('Purchase completed successfully!', $_SESSION['success_message']);
    }

    public function testPurchaseFailure(): void
    {
        $this->productModel->method('get')->willReturn(['id' => 1, 'name' => 'Product A', 'price' => 100.00, 'quantity_available' => 0]);

        $this->expectException(\Exception::class);

        $this->controller->purchase(1, 1, 5);
    }
}
