<?php
namespace App\Models;

use CodeIgniter\Model;

class CartAddonItemsModel extends Model
{
    protected $table = 'cart_item_addons';
    protected $primaryKey = 'id';
    protected $allowedFields = [
       'cart_item_id',
       'addon_id',
       'addon_name',
       'addon_price',
       'created_at'
    ];
    public function getCartAddonItems($cartItemId)
    {
        return $this->where('cart_item_id', $cartItemId)->findAll();
    }
}