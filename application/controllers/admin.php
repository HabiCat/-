<?php
//error_reporting(0);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/phpass-0.1/PasswordHash.php');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->helper('url');
        //$this->load->database();
        //$this->load->library('session');
        //$this->load->library('XUtils');
        //$this->config->load('profiler');

//        if(!$this->session->userdata('adminid')) {
//            $this->xutils->message('error', '请登录后在操作', site_url('common/login'));
//        }
    }

    public function index() {

        $this->load->view('admin/index');
    }

    public function category() {
        $this->load->view('admin/category', array('datalist' => $this->getcategorylevel(0, $this->getcategories(), 0)));
    }

    public function categorybatch($command = '', $id = 0) {
        if ($this->xutils->method() == 'GET') {
            $ids = intval($id);
        } elseif ($this->xutils->method() == 'POST') {
            $command = trim($_POST['command']);
            $ids = isset($_POST['id']) ? $_POST['id'] : '';
            is_array($ids) && $ids = implode(',', $ids);
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除掉选项');
                $query = $this->db->query('delete from t_pq_category where id in (' . $ids . ')');
                if($this->db->affected_rows() > 0) {
                    $this->xutils->message('success', '删除成功');
                } else {
                    $this->xutils->message('error', '删除失败');
                }
                break;
            case 'sortOrder':
                foreach($_POST['sortOrder'] as $k => $v) {
                    $this->db->query('update t_pq_category set sort_order = ' . $v . ' where id = '. $k);
                }

                $this->xutils->message('success', '排序更新成功');
                break;
            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function categorycreate() {
        if($this->xutils->method() == 'POST') {
            $_POST['Catalog']['create_time'] = time();
            $this->db->insert('pq_category', $_POST['Catalog']);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '栏目创建成功');
            }
        }
        $this->load->view('admin/categorycreate', array('datalist' => $this->getcategorylevel(0, $this->getcategories(), 0)));
    }

    public function categoryedit($id) {
        if($this->xutils->method() == 'POST') {
            $this->db->update('pq_category', $_POST['Catalog'], 'id = '. $id);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '栏目更新成功');
            }
        }
        $this->load->view('admin/categoryedit', array('result' => $this->getcategory($id), 'datalist' => $this->getcategorylevel(0, $this->getcategories(), 0)));
    }

    public function post() {
        $this->load->view('admin/post', $this->getpostinfo('admin/post?'));
    }

    public function postcreate() {
        if($this->xutils->method() == 'POST') {
			
            $_POST['Post']['create_time'] = time();
            $_POST['Post']['last_update_time'] = time();
            $_POST['Post']['user_id'] = $this->session->userdata('adminid');
            !$_POST['Post']['intro'] && $_POST['Post']['intro'] = strip_tags(mb_substr($_POST['Post']['content'], 0, 100));

            if($_FILES['cover']['size'] > 0) {
                $config['upload_path'] = './uploads/post_cover/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);
                $this->upload->do_upload('cover');

                $data = array('upload_data' => $this->upload->data());
                $_POST['Post']['attach_file'] = 'post_cover/' . $data['upload_data']['file_name'];
            }

            $keywords = $this->getkeywords();
			
            if(!empty($keywords)) {
                foreach($keywords as $kw) {
                    $_POST['Post']['content'] = str_replace($kw['keywords'], '<a href="' . $kw['url'] . '">' . $kw['keywords'] . '</a>', $_POST['Post']['content']);
                }
            }
			
			/* tags空格处理 */
			if(isset($_POST['Post']['tags']) && $_POST['Post']['tags'])
			{
				 $_POST['Post']['tags'] = preg_replace('/\\s{1,}/i',',',trim($_POST['Post']['tags']));
			}
			
            if(isset($_POST['editsubmit']) && $_POST['editsubmit']) {
                $_POST['Post']['preview'] = 1;
                $data = $this->db->query('select id from t_pq_post where title like "%' . $_POST['Post']['title'] . '%"')->row_array();
                if(!empty($data)) {
                    $this->db->update('pq_post', $_POST['Post'], 'id = '. $data['id']);
                    $this->xutils->message("success", '文章发布成功');
                }
            }

            $this->db->insert('pq_post', $_POST['Post']);
            if($this->db->affected_rows()) {
                if(isset($_POST['previewsubmit']) && $_POST['previewsubmit']) {
                    redirect(site_url('previewpost/' . $this->db->insert_id()));
                }

                $this->xutils->message("success", '文章发布成功');
            }
        }
        $this->load->view('admin/postcreate', array('categories' => $this->getcategorylevel(0, $this->getcategories(), 0)));
    }

    public function postedit($id = 0) {
        if(!$id) $this->xutils->message('error', '操作错误');
        if($this->xutils->method() == 'POST') {
            !preg_replace("/\\s{1,}/i","",$_POST['Post']['intro']) && $_POST['Post']['intro'] = strip_tags(mb_substr($_POST['Post']['content'], 0, 100));
            $_POST['Post']['last_update_time'] = time();

            $_POST['Post']['attach_file'] = $_POST['hiddencover'];
            if($_FILES['cover']['size'] > 0) {
                $config['upload_path'] = './uploads/post_cover/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);
                $this->upload->do_upload('cover');

                $data = array('upload_data' => $this->upload->data());
                $_POST['Post']['attach_file'] = 'post_cover/' . $data['upload_data']['file_name'];
            }

            $keywords = $this->getkeywords();

            if(!empty($keywords)) {
                foreach($keywords as $kw) {
                    $url = str_replace('/', '\/', $kw['url']);
                    if(preg_match_all('/<a href="' . $url . '">' . $kw['keywords'] . '<\/a>/u', $_POST['Post']['content'], $m1)) {
                        continue;
                    } else {
                        $_POST['Post']['content'] = str_replace($kw['keywords'], '<a href="' . $kw['url'] . '">' . $kw['keywords'] . '</a>', $_POST['Post']['content']);
                    }
                }
            }

            /* tags空格处理 */
            if(isset($_POST['Post']['tags']) && $_POST['Post']['tags'])
            {
                $_POST['Post']['tags'] = preg_replace('/\\s{1,}/i',',',trim($_POST['Post']['tags']));
            }

            $_POST['Post']['preview'] = 1;

            $this->db->update('pq_post', $_POST['Post'], 'id = '. $id);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '文章更新成功', site_url('admin/post'));
            }
        }

        $post = $this->getpost($id);

        $this->load->view('admin/postedit', array('post' => $post, 'categories' => $this->getcategorylevel(0, $this->getcategories(), 0)));
    }

    public function postbatch($command = '', $id = 0) {
        if($this->xutils->method() == 'GET') {
            $ids = $id;
        } elseif ($this->xutils->method() == 'POST') {
            $command = $this->input->post('command');
            $ids = $this->input->post('id');;
            is_array($ids) && $ids = implode(',', $ids);
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除的选项');
                $this->db->delete('pq_post', 'id in (' . $ids . ')');
                 if($this->db->affected_rows()) {
                     $this->xutils->message("success", '文章删除成功');
                 } else {
                     $this->xutils->message('error', '文章删除失败');
                 }
                break;
            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function postuploadimg() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('imgFile')) {
            echo json_encode(array('error' => 1, 'message' => $this->upload->display_errors()));
        } else {
            $data = array('upload_data' => $this->upload->data());
            echo json_encode(array('error' => 0, 'url' => '/uploads/' . $data['upload_data']['file_name']));
        }

    }

    public function userlist($page = 1) {
        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/post');
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 5;
        $start = ($page - 1) * $config['per_page'];
        $totel = $this->db->query('select count(id) as t from t_users')->row_array();
        $config['total_rows'] = $totel['t'];

        $query = $this->db->query('select * from t_users order by id desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('admin/userlist', array('datalist' => $result, 'page' => $this->pagination->create_links()));
    }

    public function usercreate() {
        if($this->xutils->method() == 'POST') {
            if(!$_POST['Admin']['username'])
                $this->xutils->message("error", '用户名不能为空');

            if(!$_POST['Admin']['password'])
                $this->xutils->message("error", '密码不能为空');

            $_POST['Admin']['password'] = $this->setpasswd($_POST['Admin']['password']);

            $_POST['Admin']['created'] = date('Y-m-d H:i:s', time());
            $_POST['Admin']['last_login'] = date('Y-m-d H:i:s', time());
            $this->db->insert('users', $_POST['Admin']);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '用户添加成功');
            }
        }
        $this->load->view('admin/usercreate');
    }

    public function useredit($id) {
        if(!$id) $this->xutils->message('error', '操作错误');
        if($this->xutils->method() == 'POST') {
            if($_POST['Admin']['password'])
                $_POST['Admin']['password'] = $this->setpasswd($_POST['Admin']['password']);
            else
                unset($_POST['Admin']['password']);

            $_POST['Admin']['modified'] = date('Y-m-d H:i:s', time());
            $this->db->update('users', $_POST['Admin'], 'id = '. $id);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '用户信息更新成功', site_url('admin/userlist'));
            }
        }
        $query = $this->db->query('select * from t_users where id = ' . $id);
        $result = $query->row_array();

        $this->load->view('admin/useredit', array('user' => $result));
    }

    public function userbatch($command = '', $id = 0) {
        if($this->xutils->method() == 'GET') {
            $ids = $id;
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除的选项');
                $this->db->delete('users', 'id in (' . $ids . ')');
                if($this->db->affected_rows()) {
                    $this->xutils->message("success", '用户删除成功');
                } else {
                    $this->xutils->message('error', '用户删除失败');
                }
                break;
            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function setpasswd($password) {
        $hasher = new PasswordHash(
            $this->config->item('phpass_hash_strength', 'tank_auth'),
            $this->config->item('phpass_hash_portable', 'tank_auth'));
        return $hasher->HashPassword($password);
    }

    public function special() {
        $query = $this->db->query('select * from t_pq_special');
        $result = $query->result_array();

        $this->load->view('admin/special', array('datalist' => $result));
    }

    public function specialcreate() {
        if($this->xutils->method() == 'POST') {
            $_POST['Special']['createtime'] = time();
            $this->db->insert('pq_special', $_POST['Special']);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '专题发布成功');
            }
        }

        $this->load->view('admin/specialcreate');
    }

    public function specialedit($id) {
        if(!$id) $this->xutils->message('error', '操作错误');
        if($this->xutils->method() == 'POST') {
            $this->db->update('pq_special', $_POST['Special'], 'specid = '. $id);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '专题更新成功', site_url('admin/special'));
            }
        }
        $query = $this->db->query('select * from t_pq_special where specid = ' . $id);
        $result = $query->row_array();

        $this->load->view('admin/specialedit', array('special' => $result));
    }


    public function specialbatch($command = '', $id = 0) {
        if ($this->xutils->method() == 'GET') {
            $ids = intval($id);
        } elseif ($this->xutils->method() == 'POST') {
            $command = trim($_POST['command']);
            $ids = isset($_POST['id']) ? $_POST['id'] : '';
            is_array($ids) && $ids = implode(',', $ids);
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除掉选项');
                $query = $this->db->query('delete from t_pq_special where specid in (' . $ids . ')');
                if($this->db->affected_rows() > 0) {
                    $this->xutils->message('success', '删除成功');
                } else {
                    $this->xutils->message('error', '删除失败');
                }
                break;
            case 'sortOrder':
                foreach($_POST['sortOrder'] as $k => $v) {
                    $this->db->query('update t_pq_special set displayorder = ' . $v . ' where specid = '. $k);
                }

                $this->xutils->message('success', '排序更新成功');
                break;
            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function postlist() {
        $this->load->view('admin/postlist', $this->getpostinfo('admin/postlist?'));
    }


    public function getpostinfo($url) {
        $query_string = '';
        if($this->input->get('catalogId'))
            $query_string .= '&catalogId=' . $this->input->get('catalogId');
        if($this->input->get('title'))
            $query_string .= '&title=' . $this->input->get('title');

        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $where = 1;
        if($this->input->get('catalogId'))
            $where .= ' AND post.catalog_id = ' . $this->input->get('catalogId');
        if($this->input->get('title'))
            $where .= ' AND post.title like "%' . $this->input->get('title') . '%"';

        $this->load->library('pagination');
       // $config['base_url'] = site_url($url . $query_string);
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $totel = $this->db->query('select count(*) as t from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where '. $where)->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select post.*, catalog.catalog_name from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where '. $where . ' order by post.id desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);
        return array('posts' => $result, 'categories' => $this->getcategorylevel(0, $this->getcategories(), 0), 'page' => $this->pagination->create_links());
    }

    public function companylist() {
        $query_string = '';
        if($this->input->get('companyname'))
            $query_string .= '&companyname=' . $this->input->get('companyname');

        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $where = 1;
        if($this->input->get('companyname'))
            $where .= ' AND companyname like "%' . $this->input->get('companyname') . '%"';

        $this->load->library('pagination');
        //$config['base_url'] = site_url('admin/companylist?' . $query_string);
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $totel = $this->db->query('select count(*) as t from t_pq_company where '. $where)->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select * from t_pq_company where '. $where . ' order by companyid desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('admin/companylist', array('datalist' => $result, 'page' => $this->pagination->create_links()));
    }

    public function companycreate() {
        if($this->xutils->method() == 'POST') {
            $_POST['Company']['createtime'] = time();

            unset($_POST['job_Industry']);
            unset($_POST['job_Company']);
            unset($_POST['job_Area']);

            $_POST['Company']['sector'] = $_POST['IndustryValue'];
            $_POST['Company']['nature'] = $_POST['natureCompanyValue'];
            $_POST['Company']['area'] = $_POST['areaValue'];

            if($_FILES['banner']['size'] > 0) {
                $config['upload_path'] = './uploads/company_banner/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);
                $this->upload->do_upload('banner');

                $data = array('upload_data' => $this->upload->data());
                $_POST['Company']['banner'] = 'company_banner/' . $data['upload_data']['file_name'];
            }

            $this->db->insert('pq_company', $_POST['Company']);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '公司添加成功');
            }
        }

        $this->load->view('admin/companycreate');
    }

    public function companyedit($id) {
        if(!$id) $this->xutils->message('error', '操作错误');
        if($this->xutils->method() == 'POST') {
            unset($_POST['job_Industry']);
            unset($_POST['job_Company']);
            unset($_POST['job_Area']);

            $_POST['Company']['sector'] = $_POST['IndustryValue'];
            $_POST['Company']['nature'] = $_POST['natureCompanyValue'];
            $_POST['Company']['area'] = $_POST['areaValue'];

            $_POST['Company']['banner'] = $_POST['hiddenbanner'];
            if($_FILES['banner']['size'] > 0) {
                $config['upload_path'] = './uploads/company_banner/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);
                $this->upload->do_upload('banner');
                //if(!$this->upload->do_upload('banner')) {
               // } else {
                $data = array('upload_data' => $this->upload->data());
                $_POST['Company']['banner'] = 'company_banner/' . $data['upload_data']['file_name'];
                //}
            }

            $this->db->update('pq_company', $_POST['Company'], 'companyid = '. $id);

            if($this->db->affected_rows()) {
                $this->xutils->message("success", '公司信息更新成功', site_url('admin/companylist'));
            }
        }

        $query = $this->db->query('select * from t_pq_company where companyid = ' . $id);
        $result = $query->row_array();

        $this->load->view('admin/companyedit', array('data' => $result));
    }

    public function companybatch($command = '', $id = 0) {
        if ($this->xutils->method() == 'GET') {
            $ids = intval($id);
        } elseif ($this->xutils->method() == 'POST') {
            $command = trim($_POST['command']);
            $ids = isset($_POST['id']) ? $_POST['id'] : '';
            is_array($ids) && $ids = implode(',', $ids);
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除掉选项');
                $query = $this->db->query('delete from t_pq_company where companyid in (' . $ids . ')');
                if($this->db->affected_rows() > 0) {
                    $this->xutils->message('success', '删除成功');
                } else {
                    $this->xutils->message('error', '删除失败');
                }
                break;
            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function postwork($id) {
        if(!$id) $this->xutils->message('error', '操作错误');
        if($this->xutils->method() == 'POST') {
            $_POST['Work']['companyid'] = $id;
            $_POST['Work']['timepub'] = time();
            $_POST['Work']['timerefresh'] = time();
            $_POST['Work']['welfare'] = $_POST['Work']['welfare'] ? implode(',', $_POST['Work']['welfare']) : '';

            unset($_POST['job_Type1']);
            unset($_POST['job_Area']);
            unset($_POST['job_Company']);
            unset($_POST['live_Area']);
            unset($_POST['job_Edu']);

            $_POST['Work']['protocol'] = $_POST['p_type'];

            $_POST['Work']['jobkey'] = $_POST['jobTypeValue1'];
            $_POST['Work']['areakey'] = $_POST['jobAreaValue'];
            $_POST['Work']['jobnaturekey'] = $_POST['jobCompanyValue'];
            $_POST['Work']['birthaddress'] = $_POST['liveAreaValue'];
            $_POST['Work']['edukey'] = $_POST['jobEduValue'];

            $_POST['Work']['timefrom'] = $_POST['Work']['timefrom'] ? strtotime($_POST['Work']['timefrom']) : time();
            $_POST['Work']['timeto'] = $_POST['Work']['timeto'] ? strtotime($_POST['Work']['timeto']) : (time() + 30 * 24 * 60 * 60);
            $this->db->insert('pq_company_work', $_POST['Work']);
            if($_POST['Work']['protocol']) {
                $this->db->insert('pq_protocol', array('workid' => $this->db->insert_id(), 'content' => $_POST['protocol_content']));
            }
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '职位添加成功');
            }
        }

        $this->load->view('admin/postwork', array('companyid' => $id));
    }

    public function worklist($id) {
        if(!$id) $this->xutils->message('error', '操作错误');
        $query_string = '';
        if($this->input->get('workname'))
            $query_string .= '&workname=' . $this->input->get('workname');

        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $where = 'w.companyid = ' . $id;
        if($this->input->get('workname'))
            $where .= ' AND w.workname like "%' . $this->input->get('workname') . '%"';

        $this->load->library('pagination');
        //$config['base_url'] = site_url('admin/worklist?' . $query_string);
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $totel = $this->db->query('select count(*) as t from t_pq_company_work as w left join t_pq_company as c on w.companyid = c.companyid where '. $where)->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select w.*, c.companyname from t_pq_company_work as w left join t_pq_company as c on w.companyid = c.companyid where '. $where . ' order by companyid desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('admin/worklist', array('datalist' => $result, 'page' => $this->pagination->create_links() , 'companyid' => $id));
    }

    public function workedit($workid) {
        if(!$workid) $this->xutils->message('error', '操作错误');

        $query = $this->db->query('select * from t_pq_company_work w left join t_pq_protocol p on w.autoid = p.workid where w.autoid = ' . $workid);
        $result = $query->row_array();

        if($this->xutils->method() == 'POST') {
            $_POST['Work']['timerefresh'] = time();
            $_POST['Work']['welfare'] = $_POST['Work']['welfare'] ? implode(',', $_POST['Work']['welfare']) : '';

            unset($_POST['job_Type1']);
            unset($_POST['job_Area']);
            unset($_POST['job_Company']);
            unset($_POST['live_Area']);
            unset($_POST['job_Edu']);

            $_POST['Work']['protocol'] = $_POST['p_type'];

            $_POST['Work']['jobkey'] = $_POST['jobTypeValue1'];
            $_POST['Work']['areakey'] = $_POST['jobAreaValue'];
            $_POST['Work']['jobnaturekey'] = $_POST['jobCompanyValue'];
            $_POST['Work']['birthaddress'] = $_POST['liveAreaValue'];
            $_POST['Work']['edukey'] = $_POST['jobEduValue'];

            $_POST['Work']['timefrom'] = $_POST['Work']['timefrom'] ? strtotime($_POST['Work']['timefrom']) : time();
            $_POST['Work']['timeto'] = $_POST['Work']['timeto'] ? strtotime($_POST['Work']['timeto']) : (time() + 30 * 24 * 60 * 60);

            $this->db->update('pq_company_work', $_POST['Work'], 'autoid = '. $workid);
            $count = $this->db->affected_rows();
            //$this->db->update('pq_protocol', array())

            if($_POST['Work']['protocol']) {
                if($result['id']) {
                    $this->db->update('pq_protocol', array('workid' => $workid, 'content' => $_POST['protocol_content']), 'id = '. $result['id']);
                } else {
                    $this->db->insert('pq_protocol', array('workid' => $workid, 'content' => $_POST['protocol_content']));
                }
            }
            //print_r($this->db->affected_rows());exit;
            if($count > 0) {
                $this->xutils->message("success", '职位信息更新成功', site_url('admin/worklist/' . $result['companyid']));
            }
        }


        $this->load->view('admin/workedit', array('rs' => $result));
     }

    public function workbatch($command = '', $id = 0) {
        if ($this->xutils->method() == 'GET') {
            $ids = intval($id);
        } elseif ($this->xutils->method() == 'POST') {
            $command = trim($_POST['command']);
            $ids = isset($_POST['id']) ? $_POST['id'] : '';
            is_array($ids) && $ids = implode(',', $ids);
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除掉选项');
                $query = $this->db->query('delete from t_pq_company_work where autoid in (' . $ids . ')');
                if($this->db->affected_rows() > 0) {
                    $this->xutils->message('success', '删除成功');
                } else {
                    $this->xutils->message('error', '删除失败');
                }
                break;
            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function replylist() {
        $query_string = '';
        if($this->input->get('name'))
            $query_string .= '&name=' . $this->input->get('name');

        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $where = 'isp = 1';
        if($this->input->get('name'))
            $where .= ' AND name like "%' . $this->input->get('name') . '%"';

        $this->load->library('pagination');
        //$config['base_url'] = site_url('admin/replylist?' . $query_string);
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $totel = $this->db->query('select count(*) as t from t_pq_reply where '. $where)->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select * from t_pq_reply where '. $where . ' order by replytime desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('admin/replylist', array('datalist' => $result, 'page' => $this->pagination->create_links()));
    }

    public function replybatch($command = '', $id = 0) {
        if ($this->xutils->method() == 'GET') {
            $ids = intval($id);
        } elseif ($this->xutils->method() == 'POST') {
            $command = trim($_POST['command']);
            $ids = isset($_POST['id']) ? $_POST['id'] : '';
            is_array($ids) && $ids = implode(',', $ids);
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除掉选项');
                $query = $this->db->query('delete from t_pq_reply where id in (' . $ids . ')');
                if($this->db->affected_rows() > 0) {
                    $this->xutils->message('success', '删除成功');
                } else {
                    $this->xutils->message('error', '删除失败');
                }
                break;
            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function applylist() {
        $query_string = '';
        if($this->input->get('name'))
            $query_string .= '&name=' . $this->input->get('name');

        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $where = 'isp = 0';
        if($this->input->get('name'))
            $where .= ' AND name like "%' . $this->input->get('name') . '%"';

        $this->load->library('pagination');
        //$config['base_url'] = site_url('admin/replylist?' . $query_string);
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $totel = $this->db->query('select count(*) as t from t_pq_reply where '. $where)->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select * from t_pq_reply where '. $where . ' order by replytime desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('admin/replylist', array('datalist' => $result, 'page' => $this->pagination->create_links()));
    }

    public function messages($page = 1) {
        $this->load->library('pagination');
        $config['base_url'] = site_url('admin/messagelist');
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $totel = $this->db->query('select count(m.id) as t from t_pq_message as m left join t_customer_person_new as p on m.userid = p.autoid')->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select m.*, p.useraccount as t from t_pq_message as m left join t_customer_person_new as p on m.userid = p.autoid order by m.createtime desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('admin/messagelist', array('datalist' => $result, 'page' => $this->pagination->create_links()));
    }

    public function messageedit($mid) {
        if(!$mid) $this->xutils->message('error', '操作错误');
        if($this->xutils->method() == 'POST') {
            $this->db->update('pq_message', $_POST['M'], 'id = ' . $mid);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '留言回复更新成功', site_url('admin/message'));
            }
        }

        $result = $this->db->query('select * from t_pq_message where id = ' . $mid)->row_array();

        $this->load->view('admin/messageedit', array('data' => $result));
    }

    public function messagebatch($command = '', $id = 0) {
        if ($this->xutils->method() == 'GET') {
            $ids = intval($id);
        } elseif ($this->xutils->method() == 'POST') {
            $command = trim($_POST['command']);
            $ids = isset($_POST['id']) ? $_POST['id'] : '';
            is_array($ids) && $ids = implode(',', $ids);
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除掉选项');
                $query = $this->db->query('delete from t_pq_message where id in (' . $ids . ')');
                if($this->db->affected_rows() > 0) {
                    $this->xutils->message('success', '删除成功');
                } else {
                    $this->xutils->message('error', '删除失败');
                }
                break;
            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function setting() {
        if($this->xutils->method() == 'POST') {
            foreach($this->input->post('Setting') as $k => $v) {
                $this->db->update('pq_setting', array('values' => $v), 'keys = "' . $k . '"');
            }

            $this->xutils->message("success", '更新成功', site_url('admin/setting'));
        }

        $data = $this->db->query('select * from t_pq_setting')->result_array();
        foreach($data as $v) {
            $globaldata[$v['keys']] = $v['values'];
        }

        $this->load->view('admin/setting', array('globaldata' => $globaldata));
    }

    public function keywords() {
        $query_string = '';
        $where = 1;
        if($this->input->get('keywords')) {
            $query_string .= '&keywords=' . $this->input->get('keywords');
            $where .= ' AND keywords like "%' . $this->input->get('keywords') . '%"';
        }

        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $this->load->library('pagination');
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $totel = $this->db->query('select count(*) as t from t_pq_keywords where '. $where)->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select * from t_pq_keywords where '. $where . ' order by id desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);
        $this->load->view('admin/keywordslist', array('result' => $result, 'page' => $this->pagination->create_links()));
    }

    public function keywordscreate() {
        if($this->xutils->method() == 'POST') {
            $this->db->insert('pq_keywords', $_POST['Keywords']);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '关键词添加成功', site_url('admin/keywords'));
            }
        }

        $this->load->view('admin/keywordscreate');
    }

    public function keywordsedit($id) {
        if(!$id) $this->xutils->message('error', '操作错误');
        if($this->xutils->method() == 'POST') {
            $this->db->update('pq_keywords', $_POST['Keywords'], 'id = '. $id);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '关键字更新成功', site_url('admin/keywords'));
            }
        }
        $query = $this->db->query('select * from t_pq_keywords where id = ' . $id);
        $result = $query->row_array();

        $this->load->view('admin/keywordsedit', array('result' => $result));
    }

    public function keywordsbatch($command = '', $id = 0) {
        if ($this->xutils->method() == 'GET') {
            $ids = intval($id);
        } elseif ($this->xutils->method() == 'POST') {
            $command = trim($_POST['command']);
            $ids = isset($_POST['id']) ? $_POST['id'] : '';
            is_array($ids) && $ids = implode(',', $ids);
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除掉选项');
                $query = $this->db->query('delete from t_pq_keywords where id in (' . $ids . ')');
                if($this->db->affected_rows() > 0) {
                    $this->xutils->message('success', '删除成功');
                } else {
                    $this->xutils->message('error', '删除失败');
                }
                break;
            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function ads() {
        $query_string = '';
        if($this->input->get('pos'))
            $query_string .= '&pos=' . $this->input->get('pos');
        if($this->input->get('title'))
            $query_string .= '&title=' . $this->input->get('title');

        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 1;
        $where = 1;
        if($this->input->get('pos'))
            $where .= ' AND pos = ' . $this->input->get('pos');
        if($this->input->get('title'))
            $where .= ' AND title like "%' . $this->input->get('title') . '%"';

        $this->load->library('pagination');
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 5;
        $config['page_query_string'] = TRUE;
        $totel = $this->db->query('select count(*) as t from t_pq_ads where '. $where)->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select * from t_pq_ads where '. $where . ' order by id desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);
        return $this->load->view('admin/adslist', array('result' => $result, 'page' => $this->pagination->create_links()));
    }

    public function adscreate() {
        if($this->xutils->method() == 'POST') {
            $_POST['Ads']['timefrom'] = strtotime( $_POST['Ads']['timefrom']);
            $_POST['Ads']['timeto'] = strtotime( $_POST['Ads']['timeto']);

            if($_FILES['img']['size'] > 0) {
                $config['upload_path'] = './uploads/ads/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);
                $this->upload->do_upload('img');

                $data = array('upload_data' => $this->upload->data());
                $_POST['Ads']['attach_file'] = 'ads/' . $data['upload_data']['file_name'];
            }

            $this->db->insert('pq_ads', $_POST['Ads']);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '广告发布成功');
            }
        }
        $this->load->view('admin/adscreate');
    }

    public function adsedit($id) {
        if(!$id) $this->xutils->message('error', '操作错误');
        if($this->xutils->method() == 'POST') {
            $_POST['Ads']['timefrom'] = strtotime( $_POST['Ads']['timefrom']);
            $_POST['Ads']['timeto'] = strtotime( $_POST['Ads']['timeto']);

            $_POST['Ads']['img'] = $_POST['hiddenimg'];
            if($_FILES['img']['size'] > 0) {
                $config['upload_path'] = './uploads/ads/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);
                $this->upload->do_upload('img');

                $data = array('upload_data' => $this->upload->data());
                $_POST['Ads']['img'] = 'ads/' . $data['upload_data']['file_name'];
            }

            $this->db->update('pq_ads', $_POST['Ads'], 'id = '. $id);

            if($this->db->affected_rows()) {
                $this->xutils->message("success", '广告信息更新成功', site_url('admin/ads'));
            }
        }

        $query = $this->db->query('select * from t_pq_ads where id = ' . $id);
        $result = $query->row_array();

        $this->load->view('admin/adsedit', array('data' => $result));
    }

    public function adsbatch($command = '', $id = 0, $status = 0) {
        if ($this->xutils->method() == 'GET') {
            $ids = intval($id);
        } elseif ($this->xutils->method() == 'POST') {
            $command = trim($_POST['command']);
            $ids = isset($_POST['id']) ? $_POST['id'] : '';
            is_array($ids) && $ids = implode(',', $ids);
        }

        switch($command) {
            case 'delete':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除掉选项');
                $query = $this->db->query('delete from t_pq_keywords where id in (' . $ids . ')');
                if($this->db->affected_rows() > 0) {
                    $this->xutils->message('success', '删除成功');
                } else {
                    $this->xutils->message('error', '删除失败');
                }
                break;
            case 'status':
                if(empty($ids)) $this->xutils->message('error', '请选择要删除掉选项');
                $this->db->update('pq_ads', array('status' => $status) , 'id = '. $id);
                if($this->db->affected_rows() > 0) {
                    $this->xutils->message('success', '更改成功');
                } else {
                    $this->xutils->message('error', '更改失败');
                }
                break;

            default:
                $this->xutils->message('error', '操作失败');
                break;
        }
    }

    public function resume() {
        $userid 		= $this->input->get('text_user')    ? 	trim($this->input->get('text_user'))	:	"";
        $name	  		= $this->input->get('text_name')		? 	trim($this->input->get('text_name'))	:	"";
        $resume	  		= $this->input->get('text_resume') 	? 	trim($this->input->get('text_resume'))	:	"";
        $sex			= $this->input->get('sex') 	 		?   trim($this->input->get('sex')) 			:   "";
        $agekey			= $this->input->get('agekey') 		?   trim($this->input->get('agekey'))		:   "";
        $marry			= $this->input->get('marry') 			?   trim($this->input->get('marry'))		:   "";
        $mobile	  		= $this->input->get('text_mobile') 	? 	trim($this->input->get('text_mobile'))	:	"";
        $email	  		= $this->input->get('text_email') 	? 	trim($this->input->get('text_email'))  	:	"";
        $qq	  			= $this->input->get('text_qq') 		? 	trim($this->input->get('text_qq'))		:	"";
        $resumeid 		= $this->input->get('text_resumeid')	? 	trim($this->input->get('text_resumeid')):	"";
        $page			= $this->input->get('page')			?	trim($this->input->get('page'))		: 	1;
        $text_num		= $this->input->get('text_num')		?	trim($this->input->get('text_num'))		:	"";
        $jobname 		= $this->input->get('jobname') 		?	$this->input->get('jobname') 			: 	0;
        $keywords =$this->input->get('keywords') ? trim($this->input->get('keywords')) : '';
        $data = array(
            'userid' => $userid,
            'name' => $name,
            'resume' => $resume,
            'sex' => $sex,
            'agekey' => $agekey,
            'marry' => $marry,
            'mobile' => $mobile,
            'email' => $email,
            'qq' => $qq,
            'resumeid' => $resumeid,
            'text_num' => $text_num,
            'jobname' => $jobname,
            'keywords' => $keywords,
        );

        $sql = "";
        $sql .= " SELECT COUNT(*) t FROM t_resume_info_new AS i ";
        $sql .= " LEFT JOIN t_resume_careerwill_new AS c ON i.personid=c.personid";
        $sql .= " WHERE i.flag=1 ";
        if($userid!="")		{$sql.=" AND i.useraccount LIKE '%".$userid."%'";}  		//查找该用户的账号
        if($name!="")		{$sql.=" AND i.personname LIKE '%".$name."%'";}				//查找用户姓名的简历
        if($sex!="")		{$sql.=" AND i.sex='".$sex."' ";}							//查找性别的简历
        if($agekey!="")		{$sql.=" AND i.agekey LIKE '%".$agekey."%'";}				//查找年龄号的简历
        if($marry!="")		{$sql.=" AND i.marry='".$marry."' ";}						//查找婚姻的简历
        if($mobile!="")		{$sql.=" AND i.mobile LIKE '%".$mobile."%'";}				//查找手机号的简历
        if($email!="")		{$sql.=" AND i.email LIKE '%".$email."%'";}					//查找邮箱的简历
        if($qq!="")			{$sql.=" AND i.qq LIKE '%".$qq."%'";}						//查找QQ的简历
        if($resumeid!="")	{$sql.=" AND i.autoid LIKE '%".$resumeid."%'";} 			//查找简历ID的简历
        if($text_num!="")	{$sql.=" AND i.resumenum LIKE '%".$text_num."%'";}
        if($jobname!=0)     {$sql.=" AND c.jobkey=$jobname";}
        if($keywords!=''){	//关键词搜索求职意向
            $tmpArray = array();
            foreach( $DATA_jobmanagement as $k => $v ){
                $tmpArray[]=$k.'-'.$v;
            }

            $tmpString = implode(',',$tmpArray);
            $data = $this->xutils->string_strpos($tmpString,$keywords);

            if( strpos($tmpString,$keywords)!==false ){
                foreach( $DATA_jobmanagement as $k => $v ){
                    if( strpos($v,$keywords)!==false ){
                        $keyarr[]=$k;
                        $jobTypeValue = '';
                        $type = '';
                    }
                }
                $sql.= " AND c.`jobkey` in (".implode(',', $keyarr).") ";
            }
        }

        $totel = $this->db->query($sql)->row_array();

        $this->load->library('pagination');
        $query_string =  $this->input->server('QUERY_STRING') ? preg_replace('/&page=(\d+)/', '' , $this->input->server('QUERY_STRING')) : '';
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $sql="";
        $sql.=" SELECT i.*,c.jobkey FROM t_resume_info_new AS i ";
        $sql.=" LEFT JOIN t_resume_careerwill_new AS c ON i.personid=c.personid";
        $sql.=" WHERE i.flag=1 ";
        if($userid!="")		{$sql.=" AND i.useraccount LIKE '%".$userid."%'";}  		//查找该用户的账号
        if($name!="")		{$sql.=" AND i.personname LIKE '%".$name."%'";}				//查找用户姓名的简历
        if($sex!="")		{$sql.=" AND i.sex='".$sex."' ";}							//查找性别的简历
        if($agekey!="")		{$sql.=" AND i.agekey LIKE '%".$agekey."%'";}				//查找年龄号的简历
        if($marry!="")		{$sql.=" AND i.marry='".$marry."' ";}						//查找婚姻的简历
        if($mobile!="")		{$sql.=" AND i.mobile LIKE '%".$mobile."%'";}				//查找手机号的简历
        if($email!="")		{$sql.=" AND i.email LIKE '%".$email."%'";}					//查找邮箱的简历
        if($qq!="")			{$sql.=" AND i.qq LIKE '%".$qq."%'";}						//查找QQ的简历
        if($resumeid!="")	{$sql.=" AND i.autoid LIKE '%".$resumeid."%'";} 			//查找简历ID的简历
        if($text_num!="")	{$sql.=" AND i.resumenum LIKE '%".$text_num."%'";}
        if($jobname!=0)	{$sql.=" AND c.jobkey=$jobname";}

        if($keywords!=''){	//关键词搜索求职意向
            $tmpArray = array();
            foreach( $DATA_jobmanagement as $k => $v ){
                $tmpArray[]=$k.'-'.$v;
            }

            $tmpString = implode(',',$tmpArray);
            $data = $this->xutils->string_strpos($tmpString,$keywords);

            if( strpos($tmpString,$keywords)!==false ){
                foreach( $DATA_jobmanagement as $k => $v ){
                    if( strpos($v,$keywords)!==false ){
                        $keyarr[]=$k;
                        $jobTypeValue = '';
                        $type = '';
                    }
                }
                $sql.= " AND c.`jobkey` in (".implode(',', $keyarr).") ";
            }
        }

        $query = $this->db->query($sql . ' order by i.timerefresh desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('admin/resume', array('result' => $result, 'data' => $data, 'page' => $this->pagination->create_links()));
    }

    public function labor() {
        $p_name  		= $this->input->get('text_name') 	? 	trim($this->input->get("text_name"))  			:	"";				//用户姓名
        $select_sex 	= $this->input->get('select_sex')	? 	$this->input->get("select_sex")				: 	2;				//会员性别
        $select_age		= $this->input->get('select_age')	? 	$this->input->get("select_age")				: 	"";		//年龄
        $text_place		= $this->input->get('text_place')	?	$this->input->get('text_place')			:	"";				//地点
        $select_job 	= $this->input->get("select_job") 	? 	trim($this->input->get("select_job"))			:	"";				//工作岗位
        $text_from	  	= $this->input->get("text_from") 		? 	trim($this->input->get("text_from"))  			:	"";			//首次登录时间
        $text_to	  	= $this->input->get("text_to") 		? 	trim($this->input->get("text_to"))  			:	"";				//最后登录时间
        $page			= $this->input->get('page')			?	trim($this->input->get('page'))		: 	1;
        $data = array(
            'p_name' => $p_name,
            'select_sex' => $select_sex,
            'select_age' => $select_age,
            'text_place' => $text_place,
            'select_job' => $select_job,
            'text_from' => $text_from,
            'text_to' => $text_to,
        );

        $sql=" ";
        $sql.=" SELECT * FROM t_tong_person ";
        $sql.=" WHERE 1=1 ";

        if($p_name!="")	{$sql.=" AND p_name LIKE '%".$p_name."%'";}
        if($select_sex!=2){ $sql.=" AND p_sex IN(".$select_sex.")"; }
        if($select_age!=''){$sql.=" AND p_age IN(".$select_age.")";}
        if($text_place!=''){$sql.=" AND p_place LIKE '%".$text_place."%'";}
        if($select_job!=''&&$select_job!='0'){$sql.=" AND p_job LIKE '$select_job%'";}
        if($text_from!="")	{$sql.=" AND intime>='".$text_from."'";}
        if($text_to!="")	{$sql.=" AND intime<='".$text_to."'";}

        $this->load->library('pagination');
        $query_string =  $this->input->server('QUERY_STRING') ? preg_replace('/&page=(\d+)/', '' , $this->input->server('QUERY_STRING')) : '';
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['total_rows'] = count($this->db->query($sql)->result_array());
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query($sql . ' order by intime desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('admin/labor', array('result' => $result, 'data' => $data, 'page' => $this->pagination->create_links()));

    }


    /*public function getcaptcha() {
        $this->load->helper('captcha');

        $vals = array(
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            //'img_width' => '150',
            //'img_height' => 30,
            'expiration' => 7200
        );

        $cap = create_captcha($vals);
        $this->session->set_userdata('captcha', $cap['word']);
        return base_url() . 'captcha/' . $cap['time'] . '.jpg';
    }
    */


    /*
     * 获取关键词
     * */
    public function getkeywords() {
        return $this->db->query('select * from t_pq_keywords')->result_array();
    }

    /**
     * 获取栏目深度
     */
    public function getcategorylevel($id, $data, $level = 0) {
        static $list = array();
        foreach($data as $k => $v) {
            if($id == $v['parent_id']) {
                $list[$k] = $v;
                $list[$k]['str_repeat'] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                $this->getcategorylevel($v['id'], $data, $level + 1);
            }
        }
        return $list;
    }

    /*
     * 获取单篇文章
     *
     * */
    public function getpost($id) {
        $query = $this->db->query('select post.*, catalog.id as cid from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where post.id = '. $id);

        return $query->row_array();
    }

    /*
     * 获取单条栏目信息
     *
     * */
    public function getcategory($id) {
        $query = $this->db->query('select * from t_pq_category where id = ' . $id . ' order by sort_order asc');
        $result = $query->row_array();

        return $result;

    }

    /*
     * 获取所有栏目信息
     *
     * */
    public function getcategories() {
        $query = $this->db->query('select * from t_pq_category order by sort_order asc');
        $result = $query->result_array();

        return $result;
    }



}
