<?php

namespace Album\Form;

use Zend\Form\Form as Form;

class AlbumForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('album');
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Album title',
            ],
        ]);
        $this->add([
            'name' => 'artist',
            'type' => 'text',
            'options' => [
                'label' => 'Artist',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Artist',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submit',
            ],
        ]);
        //$this->setAttribute('method', 'GET');
    }
}

