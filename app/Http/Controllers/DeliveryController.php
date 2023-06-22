<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    private const NOVAPOST_URL = "novaposhta.test/api/delivery";

    public function acceptDeliveryInfo(Request $request)
    {
        $novapost_data = response()->json([
            'customer_name' => $request->name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'sender_address' => env('SENDER_ADDRESS'),
            'delivery_address' => $request->address
        ]);

        \Illuminate\Support\Facades\Http::withHeaders([
            'content-type' => 'application/json',
        ])->post(self::NOVAPOST_URL, $novapost_data);

        /* Для будущей реализации можно сохранять данные о доставке в бд, чтоб в будущем
        клиенту не пришлось вводить данные заново */

        $data = $request->only([
            'name', 'phone', 'email', 'address'
        ]);

        Delivery::query()->create($data);

        /* Если курьерок будет несколько можно добавить проверку if или case switch,
        чтоб определить какая курьерка выбрана */

        /* Если курьерок будет много лучше выделить функции с ними в отдельный трейт. Можно также перебирать варианты
        с помощью if или switch case, но лучшим вариантом будет создать некоторый массив, где ключ это
        название курьерной службы, а значение - функция которая отправляет туда данные*/

        /* Чтобы избежать проблем с доставкой заказов, можно создать дополнительную таблицу, куда будут вноситься
        записи про отправку данных в службу доставки */
    }
}
