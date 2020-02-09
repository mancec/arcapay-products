<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Product;
use App\Model\Entity\ProductRating;
use Cake\Utility\Xml;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use \Cake\Database\Expression\QueryExpression;
use Cake\Controller\Component\RequestHandlerComponent;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 * * @property \App\Model\Table\ProductsTable $ProductRating
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{

    public $paginate = [
        'limit' => 5,
        'order' => [
            'Articles.title' => 'asc'
        ]
    ];

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
        // find products rating
        $sum = 0;
        $count = 0;
        foreach ($product['product_ratings'] as $score)
        {
            $sum = $sum + $score->score;
            $count++;
        }
        if($count > 0) {
            $rating = $sum / $count;
        }
        else{
            $rating = 0;
        }

        $nameArr = explode(' ',trim($product['name']));
        $descriptionArr = explode(' ',trim($product['description']));
        $name = $nameArr[0];
        $description = $descriptionArr[0];

        $conditions = array(
            'OR' =>  array('name LIKE' => "$name%", 'id !=' => $id),
            array('description LIKE' => "$description%", 'id !=' => $id),
        );

        $related = $this->paginate($this->Products->find('all', array(
            'conditions' => $conditions )),['limit' => '4']);
        $this->set('product', $product);
        $this->set('related', $related);
        $this->set('rating', $rating);
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
            $file = $this->request->GetData('photo');

            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions

                if(in_array($ext, $arr_ext))
                {
                    list($width, $height) = getimagesize($this->request->GetData('photo.tmp_name'));
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $file['name']);
                    $product['photo'] = $file['name'];
                    $product['width'] = $width;
                    $product['height'] = $height;
                }
                else
                {
                    $this->Flash->error(__('Wrong file extension.'));
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
            if (empty($this->request->GetData('photo.name')))
                {
                    $photo = $product['photo'];
                    $product = $this->Products->patchEntity($product, $this->request->getData());
                    $product['photo'] = $photo;
                } else {

                list($width, $height) = getimagesize($this->request->GetData('photo.tmp_name'));
                $file = $this->request->GetData('photo');
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                $arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions

                if (in_array($ext, $arr_ext)) {
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $file['name']);
                    $photo = $file['name'];
                    $product = $this->Products->patchEntity($product, $this->request->getData(),['photo' => $photo]);
                    $product['photo'] = $photo;
                    $product['width'] = $width;
                    $product['height'] = $height;
                }


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
            unlink(WWW_ROOT .'/img/'.$product['photo']);
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function convert()
    {

        $products = $this->Products->find()->all();
        if(!empty($product)) {
            $productlist = array();
            foreach ($products as $product) {
                $prod['id'] = $product['id'];
                $prod['name'] = $product['name'];
                $prod['price'] = $product['price'];
                $prod['description'] = $product['description'];
                $prod['photo'] = $product['photo'];

                $productlist['Products']['product'][] = $prod;
            }
            try {
                $xmlObject = Xml::fromArray($productlist,
                    ['pretty' => 'true']);
            } catch (\Cake\Utility\Exception\XmlException $e) {
                throw new InternalErrorException();
            }
            $xmlObject->asXML('webroot/files/products.xml');
        }
        else
            $this->Flash->error(__('There are no products to export'));

        return $this->redirect(
            ['controller' => 'Products', 'action' => 'index']
        );
    }

    public function readJson()
    {
        $json = file_get_contents('https://raw.githubusercontent.com/wedeploy-examples/supermarket-web-example/master/products.json');
        $obj = json_decode($json, true);
        if (!empty($obj)) {


            foreach ($obj as $e) {
                $rating = TableRegistry::getTableLocator()->get('ProductRatings')->newEntity();
                $product = $this->Products->newEntity();
                $product['name'] = $e['title'];
                $product['price'] = $e['price'];
                $product['description'] = $e['description'];
                $product['photo'] = $e['filename'];
                $product['width'] = $e['width'];
                $product['height'] = $e['height'];

                $rating['score'] = $e['rating'];
                $saved = $this->Products->save($product);
                $Product_id = $saved->id;
                $rating['product_id'] = $Product_id;
                TableRegistry::getTableLocator()->get('ProductRatings')->save($rating);
            }
        }
        else {
            $this->Flash->error(__('Could not read Json information.'));
        }
        $this->redirect('/products');
    }
}
