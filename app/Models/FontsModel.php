<?php
namespace App\Models;
use CodeIgniter\Model;
class FontsModel extends Model{
    protected $table = 'fonts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'font_name'
    ];
}
