<?php
namespace App\Models;

use CodeIgniter\Model;

class CartItemCustomizationModel extends Model
{
    protected $table = 'cart_item_customizations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
     'cart_item_id',
     'custom_text',
     'font_id',
     'font_name',
     'font_price',
     'color_id',
     'color_name',
     'colour_price',
     'size_id',
     'size_name',
     'size_price',
     'preview_image',
     'calculated_price',
     'cust_datas',
     'created_at',
     'updated_at'
    ];
    public function getCartItemCustomizations($cartItemId)
    {
        return $this->where('cart_item_id', $cartItemId)->findAll();
    }
    public function insertCartItemCustomization($data)
    {
        return $this->insert($data);
    }
    public function deleteCartItemCustomization($cartItemId)
    {
        return $this->where('cart_item_id', $cartItemId)->delete();
    }
    public function getCartItemCustomization($cartItemId, $customizationId)
    {
        return $this->where('cart_item_id', $cartItemId)
            ->where('id', $customizationId)
            ->first();
    }
    public function countCartItemCustomizations($cartItemId)
    {
        return $this->where('cart_item_id', $cartItemId)->countAllResults();
    }
}