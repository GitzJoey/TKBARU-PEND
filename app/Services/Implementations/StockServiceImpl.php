<?php
/**
 * Created by PhpStorm.
 * User: gitzj
 * Date: 5/17/2018
 * Time: 1:47 PM
 */

namespace App\Services\Implementations;

use App\Models\Stock;
use App\Models\Receipt;

use App\Services\StockService;
use Carbon\Carbon;

class StockServiceImpl implements StockService
{
    public function addStockByReceipt(Receipt $r)
    {
        foreach ($r->receiptDetails as $rd) {
            $productId = $rd->item->product->id;
            $receiptDetailId = $rd->id;
            $warehouseId = $rd->receipt()->first()->purchaseOrder()->first()->warehouse_id;

            $sList = Stock::whereProductId($productId)
                ->where('owner_id', '=', $receiptDetailId)
                ->where('owner_type', '=', 'App\Models\ReceiptDetail')->get();

            $baseProductUnitId = $this->getBaseProductUnitId($rd->item->product);
            $displayProductUnitId = $this->getDisplayProductUnitId($rd->item->product);

            if (count($sList) == 0) {
                //NEW
                $stock = new Stock();
                $stock->company_id = $rd->company_id;
                $stock->warehouse_id = $warehouseId;
                $stock->product_id = $productId;
                $stock->base_product_unit_id = $baseProductUnitId;
                $stock->display_product_unit_id = $displayProductUnitId;
                $stock->is_current = 1;
                $stock->quantity_in = $rd->base_netto;
                $stock->quantity_out = 0;
                $stock->quantity_current = $rd->base_netto;

                $rd->stock()->save($stock);
            } else {
                $stockId = 0;
                $this->resetCurrentStock($stockId);

                $stock = new Stock();
                $stock->company_id = $rd->company_id;
                $stock->warehouse_id = '';
                $stock->product_id = $productId;
                $stock->base_product_unit_id = $rd->item->product->base_product_unit_id;
                $stock->display_product_unit_id = $rd->item->product->display_product_unit_id;
                $stock->is_current = 1;
                $stock->quantity_in = $rd->base_netto;
                $stock->quantity_out = 0;
                $stock->quantity_current = $rd->base_netto;

                $rd->stock()->save($stock);
            }
        }
    }

    public function substractStockByDeliver()
    {

    }

    public function getAllCurrentStock($warehouseId = '')
    {
        if ($warehouseId == -'') {
            return Stock::get();
        } else {
            return Stock::whereWarehouseId($warehouseId)->get();
        }
    }

    public function resetCurrentStock($stockId)
    {
        $stock = Stock::find($stockId);
        $stock->is_current = 0;

        $stock->updated_by = Auth::user()->id;
        $stock->updated_at = Carbon::now();

        $stock->save();
    }

    private function getBaseProductUnitId($product)
    {
        foreach ($product->productUnits as $pu) {
            if ($pu->is_base) {
                return $pu->id;
            }
        }
    }

    private function getDisplayProductUnitId($product)
    {
        foreach ($product->productUnits as $pu) {
            if ($pu->display) {
                return $pu->id;
            }
        }
    }
}