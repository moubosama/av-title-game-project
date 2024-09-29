<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function getCustomers(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Customer::query()->select(['id', 'name'])->get());
    }

    public function postCustomers(Request $request)
    {
        $this->validate(
            $request,
            ['name' => 'required'],
            ['name.required' => ':attribute は必須項目です']
        );

        $customer = new Customer();
        $customer->name = $request->json('name');
        $customer->save();
    }

    public function getCustomer() {
        // 顧客情報を取得する処理
    }

    public function putCustomer() {
        // 顧客情報を更新する処理
    }

    public function deleteCustomer() {
        // 顧客情報を削除する処理
    }

    public function getReports() {
        // レポートを取得する処理
    }

    public function postReport() {
        // レポートを作成する処理
    }

    public function getReport() {
        // 特定のレポートを取得する処理
    }

    public function putReport() {
        // レポートを更新する処理
    }

    public function deleteReport() {
        // レポートを削除する処理
    }


}
