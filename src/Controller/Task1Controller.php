<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;


class Task1Controller extends AppController
{

    public function index()
    {
        //$p = TableRegistry::getTableLocator()->get('products');
        //$a = $p->find('all', ['contain' => 'ProductRatings'])->toArray();
        //debug($a);
    }
}
