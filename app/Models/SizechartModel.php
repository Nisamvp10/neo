<?php
namespace App\Models;
use CodeIgniter\Model;
class SizechartModel extends Model {
    protected $table = 'product_sizes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'product_id',
        'size_name',
        'width',
        'height',
        'extra_price',
        'multiplier',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($search = '', $filter = ''){
        $this->select('id,title,size,width,height,price,multiplier');
        if($search) {
            $this->like('title',$search);
        }
        if($filter) {
            $this->where('is_active',$filter);
        }
        return $this->findAll();
    }
}