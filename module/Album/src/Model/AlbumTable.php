<?php

namespace Album\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface as TableGatewayInterface;

class AlbumTable
{
    private $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway) 
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    public function getAlbum($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                    'Nie ma rekordu w tabeli o identyfikatorze %d',
                    $id
            ));
        }
        
        return $row;
    }
    
    public function saveAlbum(Album $album)
    {
        $data = [
            'artist' => $album->artist,
            'title' => $album->title,
        ];
        
        $id = (int) $album->id;
        
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }
        
        if (!$this->getAlbum($id)) {
            throw new RuntimeException(sprintf(
                    'Nie można zaktualizować albumu o id %d. Podany album nie istnieje',
                    $id
            ));
        }
        
        $this->tableGateway->update($data, ['id' => $id]);
    }
    
    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}

