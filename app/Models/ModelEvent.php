<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelEvent extends Model
{
    protected $table                = 'tbl_event';
    protected $primaryKey           = 'id';
    protected $allowedFields        = ['judul', 'deskripsi', 'gambar', 'status'];

    public function getEvent() 
    {
        return $this->table('tbl_event')->select('id, judul, deskripsi, gambar, status');
    }
}
