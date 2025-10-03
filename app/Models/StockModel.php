<?php
// app/Models/StockModel.php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model {

    protected $table = 'stocks';
    protected $primaryKey = 'idStocks';
    protected $allowedFields = ['store', 'category', 'stock'];

    public function getStockLevel($store, $category) {
        return $this->where('store', $store)
                    ->where('category', $category)
                    ->first();
    }

    public function recommendAdjustments() {
        $stocks = $this->findAll();
        $recommendations = [];

        foreach ($stocks as $stock) {
            if ($stock['stock'] > 100) {
                $recommendations[] = [
                    'store' => $stock['store'],
                    'category' => $stock['category'],
                    'recommendation' => 'Réduire le stock'
                ];
            } elseif ($stock['stock'] < 50) {
                $recommendations[] = [
                    'store' => $stock['store'],
                    'category' => $stock['category'],
                    'recommendation' => 'Augmenter le stock'
                ];
            }
        }

        return $recommendations;
    }

    public function getStockHistory($store, $category) {
        return $this->db->table('stock_history')
                        ->select('date, stock')
                        ->where('store', $store)
                        ->where('category', $category)
                        ->orderBy('date', 'ASC')
                        ->get()
                        ->getResultArray();
    }
    
}
