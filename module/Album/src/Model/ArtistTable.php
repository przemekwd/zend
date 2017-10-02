<?php

namespace Album\Model;

use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class ArtistTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($filter, $search)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($filter, $search) {
            if ($search) {
                $select->where([
                    new PredicateSet(
                        [
                            new Like('name', '%' . $search . '%'),
                            new Like('lastname', '%' . $search . '%'),
                            new Like('firstname', '%' . $search . '%'),
                        ],
                        PredicateSet::COMBINED_BY_OR
                    ),
                ]);
            }
            if ($filter) {
                $filter = explode(',', $filter);
                foreach ($filter as $f) {
                    $select->order($f);
                }
            }
        });

        return $resultSet;
    }

    public function getArtist($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveArtist(Artist $artist)
    {
        $data = array(
            'name' => $artist->name,
            'firstname'  => $artist->firstname,
            'lastname' => $artist->lastname,
            'birth_date' => $artist->birth_date,
            'country' => $artist->country,
            'band' => $artist->band,
        );

        $id = (int) $artist->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getArtist($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Artist id does not exist');
            }
        }
    }

    public function deleteArtist($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}