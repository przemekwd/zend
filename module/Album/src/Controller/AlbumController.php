<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController as AbstractActionController;
use Zend\View\Model\ViewModel as ViewModel;
use Album\Model\Album;
use Album\Model\AlbumTable;
use Album\Form\AlbumForm;

class AlbumController extends AbstractActionController
{
    private $table;
    
    public function __construct(AlbumTable $table) 
    {
        $this->table = $table;
    }
    
    public function indexAction() 
    {
        return new ViewModel([
            'albums' => $this->table->fetchAll()
        ]);
    }
    
    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');
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
        
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        
        if (!$form->isValid()) {
            debugbar_log($form->getMessages());
            return [
                'form' => $form,
                'error' => true,
            ];
        }
        
        $album->exchangeArray($form->getData());
        $this->table->saveAlbum($album);
        
        return $this->redirect()->toRoute('album');
    }
    
    public function editAction()
    {
        $params = $this->params()->fromRoute();
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if ($id === 0) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }
        
        try {
            $album = $this->table->getAlbum($id);
        } catch (Exception $ex) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }
        
        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->get('submit')->setAttribute('class', 'btn btn-warning');
        
        $request = $this->getRequest();
        $returnData = ['id' => $id, 'form' => $form, 'error' => false];
        
        if (!$request->isPost()) {
            return $returnData;
        }
        
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());
        
        if (!$form->isValid()) {
            $returnData['error'] = true;
            return $returnData;
        }
        
        $this->table->saveAlbum($album);
        
        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return [
                'id'    => $id,
                'album' => $this->table->getAlbum($id),
            ];
        }

        $del = $request->getPost('del', 'No');
        if ($del == 'Yes') {
            $id = (int) $request->getPost('id');
            $this->table->deleteAlbum($id);
        }

        // Redirect to list of albums
        return $this->redirect()->toRoute('album');
    }
}


