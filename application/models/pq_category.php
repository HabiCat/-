<?php
/**
 * Created by PhpStorm.
 * User: 111job
 * Date: 14-8-2
 * Time: 下午3:46
 */

class Pq_category extends CI_Model {

    public static $categories = array();

    public function __construct($params = array()) {
        parent::__construct();
        $this->load->database();
        self::$categories = $this->getcategories();
    }

    /*
    * 获取所有栏目
    *
    **/
    public function getcategories() {
        $query = $this->db->query("select * from t_pq_category order by displayorder asc");
        $result = $query->result_array();

        return $result;
    }

}