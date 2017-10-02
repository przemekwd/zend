<?php

namespace Album\Controller;

use Album\Form\ArtistForm;
use Album\Model\Artist;
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
        $form = new ArtistForm();
        $form->get('submit')->setValue('Dodaj artystę');
        $form->get('submit')->setAttribute('class', 'btn btn-success');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return [
                'form' => $form,
                'error' => false,
            ];
        } else {
            $data = $request->getPost();
        }

        $artist = new Artist();
        $form->setInputFilter($artist->getInputFilter());
        $form->setData($data);

        if (!$form->isValid()) {
            debugbar_log($form->getMessages());
            return [
                'form' => $form,
                'error' => true,
            ];
        }

        $artist->exchangeArray($form->getData());
        $this->table->saveArtist($artist);

        return $this->redirect()->toRoute('artist');
    }

    public function editAction()
    {

    }

    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        return new ViewModel([
            'artist' => $this->table->getArtist($id),
        ]);
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