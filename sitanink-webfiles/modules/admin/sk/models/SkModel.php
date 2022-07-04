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
     * Update generated docs
     * 
     * @param int $id
     * @param array $data
     * 
     * @return void
     */
    public function update(int $id, array $data)
    {
        $this
            ->builder
            ->where('id', $id)
            ->update($data);
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

    /**
     * Delete doc attachments by doc_id
     * 
     * @param int $docId
     * 
     * @return void
     */
    public function deleteAttachmentsByDocId(int $docId)
    {
        $this
            ->db
            ->table('generated_doc_attachments')
            ->where('id_generated_doc', $docId)
            ->delete();
    }

    /**
     * Get attachments by id_sk
     * 
     * @param int $docId
     * 
     * @return array
     */
    public function getAttachmentsByDocId(int $docId)
    {
        return $this
            ->db
            ->table('generated_doc_attachments')
            ->where('id_generated_doc', $docId)
            ->get()
            ->getResultObject();
    }

    /**
     * Get generated doc with the attachments, by id
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getWithBerkas(int $id) : ?object
    {
        return $this
            ->builder
            ->select('
                berkas.*
            ')
            ->join('berkas', 'generated_docs.id_berkas = berkas.id', 'left')
            ->where('generated_docs.id', $id)
            ->get()
            ->getRowObject();
    }

    /**
     * Count total sk
     * 
     * @return int
     */
    public function countTotal() : int
    {
        return $this
            ->builder
            ->countAllResults();
    }

    /**
     * Get by id
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function get(int $id)
    {
        return $this
            ->builder
            ->where('id', $id)
            ->get()
            ->getRowObject();
    }

    /**
     * Delete by id
     * 
     * @param int $id
     * 
     * @return void
     */
    public function delete(int $id)
    {
        return $this
            ->builder
            ->where('id', $id)
            ->delete();
    }

}