<?php

namespace Album\Model;

use Zend\Filter\StringTrim as StringTrim;
use Zend\Filter\StripTags as StripTags;
use Zend\Filter\ToInt as ToInt;
use Zend\InputFilter\InputFilter as InputFilter;
use Zend\Validator\StringLength as StringLength;

class Album
{
    public $id;
    public $artist;
    public $title;
    
    private $inputFilter;
    
    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->artist = !empty($data['artist']) ? $data['artist'] : null;
        $this->title = !empty($data['title']) ? $data['title'] : null;
    }
    
    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'artist' => $this->artist,
            'title' => $this->title,
        ];
    }
    
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }
        
        $inputFilter = new InputFilter();
        
        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'artist',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
        
        $this->inputFilter = $inputFilter;
        
        return $this->inputFilter;
    }
}

