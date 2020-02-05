<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProductRatings Controller
 *
 * @property \App\Model\Table\ProductRatingsTable $ProductRatings
 *
 * @method \App\Model\Entity\ProductRating[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductRatingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products']
        ];
        $productRatings = $this->paginate($this->ProductRatings);

        $this->set(compact('productRatings'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Rating id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productRating = $this->ProductRatings->get($id, [
            'contain' => ['Products']
        ]);

        $this->set('productRating', $productRating);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productRating = $this->ProductRatings->newEntity();
        if ($this->request->is('post')) {
            $productRating = $this->ProductRatings->patchEntity($productRating, $this->request->getData());
            if ($this->ProductRatings->save($productRating)) {
                $this->Flash->success(__('The product rating has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product rating could not be saved. Please, try again.'));
        }
        $products = $this->ProductRatings->Products->find('list', ['limit' => 200]);
        $this->set(compact('productRating', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Rating id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productRating = $this->ProductRatings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productRating = $this->ProductRatings->patchEntity($productRating, $this->request->getData());
            if ($this->ProductRatings->save($productRating)) {
                $this->Flash->success(__('The product rating has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product rating could not be saved. Please, try again.'));
        }
        $products = $this->ProductRatings->Products->find('list', ['limit' => 200]);
        $this->set(compact('productRating', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Rating id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productRating = $this->ProductRatings->get($id);
        if ($this->ProductRatings->delete($productRating)) {
            $this->Flash->success(__('The product rating has been deleted.'));
        } else {
            $this->Flash->error(__('The product rating could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
