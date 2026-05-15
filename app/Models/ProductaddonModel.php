<?php
namespace App\Models;
use CodeIgniter\Model;
class ProductaddonModel extends Model{
    protected $table = 'product_addons';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'product_id',
        'addon_name',
        'addon_image',
        'addon_price',
        'description',
        'created_at',
        'updated_at',
    ];

}