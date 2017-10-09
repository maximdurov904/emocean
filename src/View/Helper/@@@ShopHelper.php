<?php
namespace App\View\Helper;

use App\Model\Entity\ForumCategory;
use App\Model\Entity\ForumThread;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\View\View;

class ShopHelper extends Helper
{

    /**
     * Helpers used.
     *
     * @var array
     */
    public $helpers = ['Html'];

    /**
     * The HTML to output.
     *
     * @var string
     */
    public $html;

    /**
     * The thread counter for sub categories.
     *
     * @var int
     */
    public $threadCount = 0;

    /**
     * Construct method.
     *
     * @param \Cake\View\View $view The view that was fired.
     * @param array $config The config passed to the class.
     */
    public function __construct(View $view, $config = [])
    {
        parent::__construct($view, $config);
    }

    /**
     * Generate all the sub-categories.
     *
     * @param array $categories The categories to generate.
     * @param bool $reset Reset the HTML and the thread counter.
     *
     * @return void|string
     */
    public function generateCategories(array $categories = [], $reset = false)
    {
        if (empty($categories)) {
            return;
        }

        if ($reset === true) {
            $this->html = '';
            $this->threadCount = 0;
        }

        $this->html .= '<ul style="list-style: outside none none;box-sizing: content-box;min-width: 160px;">';

        foreach ($categories as $index => $child) {
            $this->threadCount += $child->thread_count;

            $this->html .= '<li class="main-cat-child">';
            $this->html .= $this->Html->link($child->title, [
                '_name' => 'forum-categories',
                'id' => $child->id,
                'slug' => $child->title
            ]);
            $this->html .= '</li>';
            if (is_array($child->children) && !empty($child->children)) {
                $this->generateCategories($child->children);
            }
        }

        $this->html .= '</ul>';

        $data = [];
        $data['thread_count'] = $this->threadCount;
        $data['html'] = $this->html;

        return $data;
    }

    /**
     * Check if a thread is readed or not by the current user.
     *
     * @param  App\Model\Entity\ForumThread $thread The thread to handle.
     *
     * @return bool
     */
    public function checkThreadReaded(ForumThread $thread)
    {
        if (!$this->request->session()->read('Auth.User.id')) {
            return false;
        }
        $this->ThreadsTrackers = TableRegistry::get('ForumThreadsTrackers');

        $tracker = $this->ThreadsTrackers
            ->find()
            ->where([
                'user_id' => $this->request->session()->read('Auth.User.id'),
                'thread_id' => $thread->id
            ])
            ->first();

        if (!is_null($tracker)) {
            if ($tracker->date < $thread->last_post_date) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Check if a category is readed or not by the current user.
     *
     * @param  App\Model\Entity\ForumCategory $category The category to handle.
     *
     * @return bool
     */
    public function checkCategoryReaded(ForumCategory $category)
    {
        if (!$this->request->session()->read('Auth.User.id')) {
            return false;
        }
        $this->CategoriesTrackers = TableRegistry::get('ForumCategoriesTrackers');

        $tracker = $this->CategoriesTrackers
            ->find()
            ->where([
                'user_id' => $this->request->session()->read('Auth.User.id'),
                'category_id' => $category->id
            ])
            ->first();

        if (!is_null($tracker)) {
            if ($tracker->nbunread >= 1) {
                return false;
            }

            return true;
        }

        return false;
    }
	
	
		function status($value) { 
		$output = '';
        if ($value == 1) {
           $output = 'Active';
        } else if ($value == 0) {
           $output = 'Not Active';
        } 
        return $output;
    }
	
	function countProduct($shop_id){
		$this->Products = TableRegistry::get('UserProducts');	
		if(!empty($this->request->session()->read('Search.Advanced'))){
			$searched_inputs = $this->request->session()->read('Search.Advanced');				
			$conditions = array();
			$name = array();
			foreach ($searched_inputs as $input => $v) {            
				// Now we need to loop into each store to see if they have got the product or not.			
				$name[] = array('Products.name LIKE'=>"%".$v['value']."%");			
			} 	
			if(!empty($name))
			{
				$conditions = ["OR"=>$name,'UserProducts.shop_id' => $shop_id,'UserProducts.status' => 1];
			}			
		}
        $count_product = $this->Products
            ->find()
			->contain(['Products'=>['fields'=>['Products.id','Products.name','Products.price']]])
            ->where([$conditions])          
            ->count();
		return $count_product;
	}
	
	function shopPrice($shop_id){
		$this->UserProducts = TableRegistry::get('UserProducts');	 
		 $count_product = $this->UserProducts
		->find()
		->where([
			'UserProducts.shop_id' => $shop_id,'UserProducts.status' => 1
		]);
		$total = 0;
		foreach($count_product as $value){
			$total += $value->price;
		}
		return $total;
	}
	
}
