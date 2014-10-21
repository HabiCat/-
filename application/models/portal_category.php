<?php
/**
 * Created by PhpStorm.
 * User: 111job
 * Date: 14-7-30
 * Time: 下午4:38
 */
class Portal_category extends CI_Model {

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
        $query = $this->db->query("select * from t_portal_category");
        $result = $query->result_array();

        return $result;
    }

    /**
     * 获取栏目深度
     *
     * @param $id
     * @return int
     */
    public function getlevel($id, $level = 0) {
        foreach(self::$categories as $v) {
            if($v['catid'] == $id) {
                foreach(self::$categories as $v1) {
                    if($v1['catid'] == $v['upid']) {
                        $level = $this->getlevel($v1['catid'], $level+1);
                    }
                }
            }
        }

        return $level;
    }

    /***
     * 获取指定ID下级栏目
     *
     * @param $id
     */
    public function getchildids($id) {
        $ids = array();
        foreach(self::$categories as $v) {
            if($v['upid'] == $id) {
                $ids[] = $v['catid'];
            }
        }

        return $ids;
    }

}