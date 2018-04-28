<?php
/**
 * Created by PhpStorm.
 * User: TKBARU
 * Date: 4/13/2018
 * Time: 9:37 PM
 */

namespace App\Services\Implementations;

use App\Models\Item;
use App\Models\Expense;
use App\Models\PurchaseOrder;

use DB;
use Auth;
use Config;
use Exception;
use Carbon\Carbon;

use App\Services\PurchaseOrderService;

class PurchaseOrderServiceImpl implements PurchaseOrderService
{

    public function create(
            $code,
            $po_type,
            $po_created,
            $shipping_date,
            $supplier_type,
            $items,
            $expenses,
            $supplier_id,
            $walk_in_supplier,
            $walk_in_supplier_detail,
            $warehouse_id,
            $disc_total_value,
            $status,
            $remarks,
            $internal_remarks,
            $private_remarks
    )
    {
        DB::beginTransaction();

        try {
            if ($supplier_type == 'SUPPLIERTYPE.R'){
                $supplier_id = empty($supplier_id) ? 0 : $supplier_id;
                $walk_in_supplier = '';
                $walk_in_supplier_detail = '';
            } else {
                $supplier_id = 0;
            }

            $params = [
                'code' => $code,
                'po_type' => $po_type,
                'po_created' => date('Y-m-d H:i:s', strtotime($po_created)),
                'shipping_date' => date('Y-m-d H:i:s', strtotime($shipping_date)),
                'supplier_type' => $supplier_type,
                'walk_in_supplier' => $walk_in_supplier,
                'walk_in_supplier_detail' => $walk_in_supplier_detail,
                'remarks' => $remarks,
                'internal_remarks' => $internal_remarks,
                'private_remarks' => $private_remarks,
                'status' => 'POSTATUS.WA',
                'supplier_id' => $supplier_id,
                'vendor_trucking_id' => empty($vendor_trucking_id) ? 0 : $vendor_trucking_id,
                'warehouse_id' => $warehouse_id,
                'company_id' => Auth::user()->company->id,
                'disc_value' => $disc_total_value,
            ];

            $po = PurchaseOrder::create($params);

            for ($i = 0; $i < count($items); $i++) {
                $item = new Item();
                $item->product_id = $items[$i]["product_id"];
                $item->company_id = $items[$i]["company_id"];
                $item->selected_product_unit_id = $items[$i]["selected_product_unit_id"];
                $item->base_product_unit_id = $items[$i]["base_product_unit_id"];
                $item->conversion_value = $items[$i]["conversion_value"];
                $item->quantity = $items[$i]["quantity"];
                $item->discount = $items[$i]["discount"];
                $item->price = $items[$i]["price"];
                $item->to_base_quantity = $item->quantity * $item->conversion_value;

                $po->items()->save($item);
            }

            for($i = 0; $i < count($expenses); $i++){
                $expense = new Expense();
                $expense->name = $expenses[$i]["name"];
                $expense->type = $expenses[$i]["type"];
                $expense->is_internal_expense = !empty($expenses[$i]["is_internal_expense"]);
                $expense->amount = $expenses[$i]["amount"];
                $expense->remarks = $expenses[$i]["remarks"];

                $po->expenses()->save($expense);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function read()
    {
        return PurchaseOrder::get();
    }

    public function update(
        $id,
        $code,
        $po_type,
        $po_created,
        $shipping_date,
        $supplier_type,
        $items,
        $expenses,
        $supplier_id,
        $walk_in_supplier,
        $walk_in_supplier_detail,
        $warehouse_id,
        $disc_total_value,
        $status,
        $remarks,
        $internal_remarks,
        $private_remarks
    )
    {
        // TODO: Implement update() method.
    }

    public function generatePOCode()
    {
        $result = '';

        do
        {
            $length = Config::get('const.TRXCODE.LENGTH');
            $generatedString = '';
            $characters = array_merge(Config::get('const.RANDOMSTRINGRANGE.ALPHABET'), Config::get('const.RANDOMSTRINGRANGE.NUMERIC'));
            $max = sizeof($characters) - 1;

            for ($i = 0; $i < $length; $i++) {
                $generatedString .= $characters[mt_rand(0, $max)];
            }

            $temp_result = strtoupper($generatedString);

            $po = PurchaseOrder::whereCode($temp_result);
            if (empty($po->first())) {
                $result = $temp_result;
            }
        } while (empty($result));

        return $result;
    }

    public function getLastPODates($limit = 50)
    {
        $po = PurchaseOrder::all()->groupBy(function ($po) {
            return $po->po_created->format('d-M-y');
        })->take($limit)->map(function($item) {
            return $item->all()[0]->po_created->format('d/m/y');
        });

        return $po;
    }

    public function searchPOByDate($date)
    {
        $date = Carbon::parse($date)->format('Y-m-d');

        $purchaseOrders = PurchaseOrder::with([ 'items.product', 'supplier.profiles', 'receipts.item.product',
            'receipts.item.selectedUnit' => function($q) { $q->with('unit')->withTrashed(); }
        ])->where('po_created', 'like', '%'.$date.'%')->get();

        return $purchaseOrders;
    }
}