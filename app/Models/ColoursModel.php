<?php
namespace App\Models;

use CodeIgniter\Model;

class ColoursModel extends Model
{
    protected $table = 'product_colors';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'product_id', 
        'color_name', 
        'color_code', 
        'preview_image', 
        'extra_price', 
        'status', 
        'created_at', 
        'updated_at',
    ];

}