<?php

namespace Modules\Admin\User\Models;

class LokasikerjaModel extends Model
{
    protected $table      = 'lokasi_kerja';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name', 'email'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}