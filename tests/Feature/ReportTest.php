<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'TestDataSeeder']);
    }

    /** @test */
    public function api_customersにGETメソッドでアクセスできる(): void
    {
        $response = $this->get('/api/customers');
        $response->assertStatus(200);
    }

    /** @test */
    public function api_customersにPOSTメソッドでアクセスできる(): void
    {
        $customer = [
            'name' => 'customer_name'
        ];

        $response = $this->postJson('api/customers', $customer);
        $response->assertStatus(200);
    }

    /** @test */
    public function api_customers_customers__idにGETメソッドでアクセスできる(): void
    {
        $response = $this->get('/api/customers/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function api_customers_customers__idにPUTメソッドでアクセスできる(): void
    {
        $response = $this->put('/api/customers/1');
        $response->assertStatus(200);
    }


    /** @test */
    public function api_customers_customers__idにDELETEメソッドでアクセスできる(): void
    {
        $response = $this->delete('/api/customers/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function api_reportsにGETメソッドでアクセスできる(): void
    {
        $response = $this->get('/api/reports');
        $response->assertStatus(200);
    }

    /** @test */
    public function api_reportsにPOSTメソッドでアクセスできる(): void
    {
        $response = $this->POST('/api/reports');
        $response->assertStatus(200);
    }

    /** @test */
    public function api_reports_reports__idにGETメソッドでアクセスできる(): void
    {
        $response = $this->get('/api/reports/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function api_reports_reports__idにPUTメソッドでアクセスできる(): void
    {
        $response = $this->put('/api/reports/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function api_reports_reports__idにDELETEメソッドでアクセスできる(): void
    {
        $response = $this->delete('/api/reports/1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_customers_GET_パラメータなしでJSON形式で返却する()
    {
        $response = $this->get('/api/customers');
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_customersGETステータスコード200で顧客のJSON形式で配列を返す()
    {
        $response = $this->get('api/customers');
        $customers = $response->json();

        // 配列が空でないことを確認
        $this->assertNotEmpty($customers, '顧客データが空です');

        $customer = $customers[0];
        $this->assertSame(['id', 'name'], array_keys($customer));
    }

    /**
     * @test
     */
    public function api_customersにGETメソッドでアクセスすると2件の顧客リストが返却される()
    {
        $response = $this->get('/api/customers');
        $response->assertJsonCount(2);
    }

    /**
     * @test
     */
    public function api_customersに顧客名をPOSTするとcustomersテーブルにそのデータが追加される()
    {
        $params = [
            'name' => '顧客名',
        ];

        $this->postJson('api/customers', $params);
        $this->assertDatabaseHas('customers', $params);
    }

    /**
     * @test
     */
    public function POST_api_customersにnameが空の場合は422UNPROCESSABLE_ENTITYが返却される()
    {
        $params = ['name' => ''];
        $response = $this->postJson('/api/customers', $params);
        $response->assertStatus(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function POST_api_customersのエラーレスポンスの確認()
    {
        $params = ['name' => ''];
        $response = $this->postJson('api/customers', $params);
        $error_response = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => [
                    'name は必須項目です'
                ],
            ],
        ];

        $response->assertExactJson($error_response);
    }
}
