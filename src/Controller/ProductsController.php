<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Product;
use Cake\Utility\Xml;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $products = $this->paginate($this->Products);

        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['ProductRatings']
        ]);

        $this->set('product', $product);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();

        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            list($width, $height) = getimagesize($this->request->GetData('photo.tmp_name'));
            $file = $this->request->GetData('photo');

            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions

            if(in_array($ext, $arr_ext))
            {
                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $file['name']);
                $product['photo'] = $file['name'];
            }
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }



    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function convert()
    {
        //$products = TableRegistry::getTableLocator()->get('Products')->find()->all();
        // debug($products);
        $products = $this->Products->get('Products')->find()->all();
        $productlist =array();
        foreach ($products as $product) {
            $prod['id'] = $product['id'];
            $prod['name'] = $product['name'];
            $prod['price'] = $product['price'];
            $prod['description'] = $product['description'];
            $prod['photo'] = $product['photo'];

            $productlist['Products']['product'][] = $prod;


        }
        //debug($productlist);
        $xmlObject = Xml::fromArray($productlist);
        $xmlString = $xmlObject->asXML();

        debug($xmlString);
        // $xmlObject = Xml::fromArray($xmlArray);
        //$xmlString = $xmlObject->asXML();
        // dd($xmlString);
        // $xmlArray =  Product::->find('all');
        // dd($xmlArray);
        // $xml1 = Xml::fromArray($query);
    }
}
