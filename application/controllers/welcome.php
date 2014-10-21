<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    static public $tree;
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        //$this->load->library('tree', $list);

        $this->load->model('Portal_category');

        $data = $this->Portal_category->getcategories();
        //$this->get_tree(0, $data, 0);
        //foreach($this->Portal_category->getcategories() as $key => $value) {
        //    $categories[$key] = $value;
        //    $categories[$key]['level'] = $this->Portal_category->getlevel($value['catid']);
        //    $categories[$key]['children'] = $this->Portal_category->getchildids($value['catid']);
        //}
        //echo '<pre>';
        //print_r($categories);
        //echo '</pre>';
        //foreach ($categories as $key=>$value) {
        //    if($value['level'] == 0) {
        //        echo $this->showcategoryrow($key, 0, '');
        //    }
        //}
        //print_r($this->Breadcrumbs(16, $data));
		//$this->load->view('welcome_message');
	}

    public function get_tree($id, $data, $level = 0) {
        if(empty($data)) return false;
        foreach($data as $k => $v) {
            if($id == $v['upid']) {
                self::$tree[] = str_repeat('..', $level) . $v['catname'];
                $this->get_tree($v['catid'], $data, $level+1);
            }

        }
    }


    public function reply() {
        $comment = array(
            array('id' => 1, 'name' => '张先生', 'contents' => '111', 'pid' => 0),
            array('id' => 2, 'name' => '黄先生', 'contents' => '222', 'pid' => 1),
            array('id' => 3, 'name' => '张先生', 'contents' => '333', 'pid' => 2),
            array('id' => 4, 'name' => '黄先生', 'contents' => '444', 'pid' => 3),
            array('id' => 5, 'name' => '李先生', 'contents' => '555', 'pid' => 1),
            array('id' => 6, 'name' => '刘先生', 'contents' => '666', 'pid' => 2),
            array('id' => 7, 'name' => '陈先生', 'contents' => '777', 'pid' => 4),
        );

       $this->get_comments(0, $comment, '');
    }


    public function get_comments($id, $comments, $name, $level = 0) {
        if(empty($comments)) return false;

        foreach($comments as $v) {
            if($id == $v['pid']) {
                echo str_repeat('..', $level) . $v['name'] . '回复' . $name .':' . $v['contents'] . '<br />';
                $this->get_comments($v['id'], $comments, $v['name'], $level + 1);
            }
        }
     }

    public function show($id) {
        print_r($id);
    }

    public function Breadcrumbs($id, $data) {
        static $arr = array();
        foreach($data as $v) {
            if($v['catid'] == $id) {
                $arr[] = $v['catname'];
                $this->Breadcrumbs($v['upid'], $data);
            }
        }
        return $arr;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */