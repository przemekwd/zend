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
        $filter = $this->params()->fromPost('filter');
        $search = $this->params()->fromPost('search');

        return new ViewModel([
            'artists' => $this->table->fetchAll($filter, $search),
            'search' => $search,
        ]);
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function showAction()
    {

    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('artist');
        }

        $this->table->deleteArtist($id);

        return $this->redirect()->toRoute('artist');
    }
}