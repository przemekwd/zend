<?php

namespace Album\Controller;

use Album\Model\ArtistTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel as ViewModel;

class ArtistController extends AbstractActionController
{
    private $table;

    public function __construct(ArtistTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'artists' => $this->table->fetchAll()
        ]);
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}