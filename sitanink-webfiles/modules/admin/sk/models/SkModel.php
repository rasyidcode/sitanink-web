<?php

namespace Modules\Admin\Sk\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\ConnectionInterface;

class SkModel
{

    protected $db;

    /**
     * @var BaseBuilder
     */
    private BaseBuilder $builder;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->builder = $this->db->table('generated_docs');
    }

    /**
     * Create new generated docs
     * 
     * @param array $data
     * 
     * @return int|null
     */
    public function create(array $data, $returnId = false) : ?int
    {
        $this
            ->builder
            ->insert($data);
        
        if ($returnId) {
            $row = $this
                ->db
                ->query('SELECT LAST_INSERT_ID() as last_id')
                ->getRowObject() ?? 0;

            return $row
                ->last_id ?? 0;
        }

        return null;
    }

    /**
     * Create doc attachments
     * 
     * @param array $data
     * 
     * @return void
     */
    public function createAttachments(array $data)
    {
        $this
            ->db
            ->table('generated_doc_attachments')
            ->insertBatch($data);
    }

}