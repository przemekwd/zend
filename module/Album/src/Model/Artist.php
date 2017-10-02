<?php
/**
 * Created by PhpStorm.
 * User: Przemysław Mincewicz
 * Date: 2017-10-02
 * Time: 12:36
 */

namespace Album\Model;


class Artist
{
    public $id;
    public $name;
    public $firstname;
    public $lastname;
    public $birth_date;
    public $country;
    public $band;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->firstname  = (!empty($data['firstname'])) ? $data['firstname'] : null;
        $this->lastname  = (!empty($data['lastname'])) ? $data['lastname'] : null;
        $this->birth_date  = (!empty($data['birth_date'])) ? $data['birth_date'] : null;
        $this->country  = (!empty($data['country'])) ? $data['country'] : null;
        $this->band  = (!empty($data['band'])) ? $data['band'] : null;
    }
}