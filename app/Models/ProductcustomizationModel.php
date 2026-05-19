<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductcustomizationModel extends Model
{
    protected $table      = 'product_fonts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id','font_name','font_file','preview_image','base_price','extra_letter_price','status'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}