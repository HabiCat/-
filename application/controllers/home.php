<?php
/**
 * Created by PhpStorm.
 * User: 111job
 * Date: 14-8-2
 * Time: 下午1:48
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Home extends CI_Controller {
    //public $userid = 34376;
    public $title;
    public $keyword;
    public $description;

    public function __construct() {
        parent::__construct();

        $data = $this->db->query('select * from t_pq_setting')->result_array();
        foreach($data as $v) {
            $this->$v['keys'] = $v['values'];
        }
    }

    public function index() {
        $works = $this->db->query('select w.*, c.companyname, c.banner from t_pq_company_work w left join t_pq_company c on w.companyid = c.companyid order by w.autoid desc LIMIT 6')->result_array();
        
		/* 首页现在只需要4个最新职位，同时推荐职位为华中人才网的职位 */
		$recommendworks = array();
        foreach($works as $v) {
            if(count($recommendworks) > 5) break;
            !isset($recommendworks[$v['companyid']][0]) && $recommendworks[$v['companyid']][0] = array($v['companyid'], $v['companyname']);
            if(count($recommendworks[$v['companyid']]) <= 3)
                $recommendworks[$v['companyid']][] = $v;
        }
		/* 注释结束 */
		
		$query = $this->db->query('select post.*, catalog.catalog_name from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where catalog.id in (1, 2, 3, 5) and post.preview = 1 order by post.id desc limit 6');
        $pedias = $query->result_array();

		
        $wonderfulnews = $this->db->query('select * from t_pq_post order by id limit 8')->result_array();
        $adv = $this->getads(array(1,2,5));
		
		$this->load->view('index', array('works' => $works, 'pedias' => $pedias, 'recommendworks' => $recommendworks, 'wonderfulnews' => $wonderfulnews, 'adv' => $adv));
    }

    public function news() {
		
        $this->load->library('Page');
		
        $where = ' catalog.id not in (1, 2, 3, 5) and post.preview = 1';
        $page_config['perpage'] = 8;     //每页条数
        $page_config['part'] = 4;        //当前页前后链接数量
        $page_config['seg'] = 3;         //参数取 index.php之后的段数，默认为3，即index.php/control/function/18 这种形式
        $page_config['nowindex'] = $this->uri->segment($page_config['seg']) ? $this->uri->segment($page_config['seg']) : 1;//当前页
        $page_config['url'] = 'news';  //url

        $countnum = $this->db->query('select count(*) as t from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where '. $where)->row_array();                //得到记录总数--应该是调用model中的某方法得来的。这里省略。
        $page_config['total'] = $countnum['t'];

        $start = ($page_config['nowindex'] - 1) * $page_config['perpage'];
        $query = $this->db->query('select post.*, catalog.catalog_name from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where '. $where . ' order by post.id desc limit ' . $start . ',' . $page_config['perpage']);
        $result = $query->result_array();

        $this->page->initialize($page_config);

        $page = $this->page->show(2);

        $adv = $this->getads(3);

        $this->load->view('news', array('list' => $result, 'wiki' => $this->wk(), 'page' => $page, 'adv' => $adv, 'selfurl' => $selfurl));
    }

    public function lists($cid) {
        $data = $this->getnews($cid);

        $this->load->view('news', array('list' => $data['result'], 'wiki' => $this->wk(),'page' => $data['page']));
    }

    public function wks($cid) {
        $data = $this->getnews($cid);

        $this->load->view('wiki', array('list' => $data['result'], 'wiki' => $this->wk(),'page' => $data['page']));
    }

    public function getnews($cid) {
        $this->load->library('Page');

        $where = 'post.catalog_id = ' . $cid;
        $page_config['perpage'] = 8;     //每页条数
        $page_config['part'] = 4;        //当前页前后链接数量
        $page_config['seg'] = 4;         //参数取 index.php之后的段数，默认为3，即index.php/control/function/18 这种形式
        $page_config['nowindex'] = $this->uri->segment($page_config['seg']) ? $this->uri->segment($page_config['seg']) : 1;//当前页
        $page_config['url'] = 'home/n';  //url

        $countnum = $this->db->query('select count(*) as t from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where '. $where)->row_array();                //得到记录总数--应该是调用model中的某方法得来的。这里省略。
        $page_config['total'] = $countnum['t'];

        $start = ($page_config['nowindex'] - 1) * $page_config['perpage'];
        $query = $this->db->query('select post.*, catalog.catalog_name from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where '. $where . ' order by post.id desc limit ' . $start . ',' . $page_config['perpage']);
        $result = $query->result_array();

        $this->page->initialize($page_config);

        $page = $this->page->show(2);

        return array('result' => $result, 'page' => $page);
    }

    public function wiki() {

        $this->load->library('Page');

        $where = ' catalog.id in (1, 2, 3, 5) and post.preview = 1';

        $page_config['perpage'] = 8;     //每页条数
        $page_config['part'] = 4;        //当前页前后链接数量
        $page_config['seg'] = 3;         //参数取 index.php之后的段数，默认为3，即index.php/control/function/18 这种形式
        $page_config['nowindex'] = $this->uri->segment($page_config['seg']) ? $this->uri->segment($page_config['seg']) : 1;//当前页
        $page_config['url'] = 'wiki';  //url

        $countnum = $this->db->query('select count(*) as t from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where '. $where)->row_array();                //得到记录总数--应该是调用model中的某方法得来的。这里省略。
        $page_config['total'] = $countnum['t'];

        $start = ($page_config['nowindex'] - 1) * $page_config['perpage'];
        $query = $this->db->query('select post.*, catalog.catalog_name from t_pq_post post left join t_pq_category catalog on post.catalog_id = catalog.id where '. $where . ' order by post.id desc limit ' . $start . ',' . $page_config['perpage']);
        $result = $query->result_array();
		
        $this->page->initialize($page_config);

        $page = $this->page->show(2);

        $adv = $this->getads(3);

        $this->load->view('wiki', array('list' => $result, 'wiki' => $this->wk(), 'page' => $page, 'adv' => $adv));
    }
	
    public function wk() {
        $wikis = $this->db->query('select * from t_pq_post where catalog_id in (2, 3, 5) and preview = 1')->result_array();
        $arr = array();
        foreach($wikis as $v) {
            $arr[$v['catalog_id']][] = $v;
        }

        return array('cs' => $arr[2], 'al' => $arr[3], 'fl' => $arr[5]);
    }


    /*
     * 浏览计数
     * */
    public function viewcount($id) {
        $this->db->query('update t_pq_post set view_count = view_count+1 where id = ' . $id);
    }

    public function post($id) {
        $this->viewcount($id);

        $post = $this->db->query('select * from t_pq_post where id = ' . $id . ' and preview <> 0')->row_array();
        $categories = $this->db->query('select * from t_pq_category')->result_array();
        $breadcrumbs = array_reverse($this->getbreadcrumbs($post['catalog_id'], $categories), true);
        if($post['tags'])
            $post['tags'] = explode(',', $post['tags']);

        $where = 'id <> ' . $id . ' and preview <> 0';
        $flag = '';
        if(!empty($post['tags'])) {
            $where .= ' and ';
            foreach($post['tags'] as $v) {
                $where .= $flag . ' content like "%' . $v . '%" ';
                $flag = 'or';
            }
        }
        $interestnews = $this->db->query('select * from t_pq_post where ' . $where . ' order by id limit 5')->result_array();

        $title = $post['title'];
        $description = $post['intro'];
        $keyword = $post['seo_keywords'];

        $pagenews = array();
        if(preg_match('/<hr(.*?)\/>/', $post['content'], $match)) {
            $pagenews = explode('$', preg_replace('/<hr(.*?)\/>/', '$', $post['content']));
        }

        $this->load->view('post', array('post' => $post, 'pagenews' => $pagenews, 'title' => $title, 'description' => $description, 'keyword' => $keyword,'adv' => $this->getads(6), 'categories' => $categories, 'breadcrumbs' => $breadcrumbs, 'interestnews' => $interestnews, 'wiki' => $this->wk()));
    }

    public function previewpost($id) {
        $post = $this->db->query('select * from t_pq_post where id = ' . $id . ' and preview = 0')->row_array();
        $categories = $this->db->query('select * from t_pq_category')->result_array();
        $breadcrumbs = array_reverse($this->getbreadcrumbs($post['catalog_id'], $categories), true);
        if($post['tags'])
            $post['tags'] = explode(',', $post['tags']);

        $where = 'id <> ' . $id . ' and preview <> 0';
        $flag = '';
        if(!empty($post['tags'])) {
            $where .= ' and ';
            foreach($post['tags'] as $v) {
                $where .= $flag . ' content like "%' . $v . '%" ';
                $flag = 'or';
            }
        }
        $interestnews = $this->db->query('select * from t_pq_post where ' . $where . ' order by id limit 5')->result_array();

        $title = $post['title'];
        $description = $post['intro'];
        $keyword = $post['seo_keywords'];

        $this->load->view('post', array('post' => $post, 'title' => $title, 'description' => $description, 'keyword' => $keyword,'adv' => $this->getads(6), 'categories' => $categories, 'breadcrumbs' => $breadcrumbs, 'interestnews' => $interestnews, 'wiki' => $this->wk()));
    }

    public function jobs() {

        $this->load->library('Page');

        $page_config['perpage'] = 8;     //每页条数
        $page_config['part'] = 4;        //当前页前后链接数量
        $page_config['seg'] = 3;         //参数取 index.php之后的段数，默认为3，即index.php/control/function/18 这种形式
        $page_config['nowindex'] = $this->uri->segment($page_config['seg']) ? $this->uri->segment($page_config['seg']) : 1;//当前页
        $page_config['url'] = 'jobs';  //url

        $countnum = $this->db->query('select count(*) as t from t_pq_company_work w left join t_pq_company c on w.companyid = c.companyid order by w.autoid desc')->row_array();                //得到记录总数--应该是调用model中的某方法得来的。这里省略。
        $page_config['total'] = $countnum['t'];

        $start = ($page_config['nowindex'] - 1) * $page_config['perpage'];
        $query = $this->db->query('select w.*, c.companyname, c.banner from t_pq_company_work w left join t_pq_company c on w.companyid = c.companyid order by w.autoid desc limit ' . $start . ',' . $page_config['perpage']);
        $result = $query->result_array();

        $this->page->initialize($page_config);

        $page = $this->page->show(2);

        $works = $this->db->query('select w.*, c.companyname from t_pq_company_work w left join t_pq_company c on w.companyid = c.companyid order by w.autoid desc')->result_array();
        $recommendworks = array();
        foreach($works as $v) {
            if(count($recommendworks) > 5) break;
            !isset($recommendworks[$v['companyid']][0]) && $recommendworks[$v['companyid']][0] = array($v['companyid'], $v['companyname']);
            if(count($recommendworks[$v['companyid']]) <= 3)
                $recommendworks[$v['companyid']][] = $v;
        }

		$adv = $this->getads(array(4));
		
        $this->load->view('jobs', array('works' => $result, 'recommendworks' => $recommendworks, 'page' => $page, 'adv' => $adv));
    }

    public function job($id) {
        $job = $this->db->query('select * from t_pq_company_work w left join t_pq_company c on w.companyid = c.companyid where autoid = ' . $id)->row_array();

        $similarjobs = $this->db->query('select * from t_pq_company_work w left join t_pq_company c on w.companyid = c.companyid where w.autoid != ' . $id . ' and w.workname like "%' . $job['workname'] . '%"')->result_array();

        //$jobmanagemen = $this->config->item('jobmanagemen');
        $likejobs = $this->db->query('select * from t_pq_company_work w left join t_pq_company c on w.companyid = c.companyid where w.autoid != ' . $id . ' and w.jobkey = ' . $job['jobkey'])->result_array();

        $this->load->view('job', array('job' => $job, 'similarjobs' => $similarjobs, 'likejobs' => $likejobs));
    }

    /*
     * 获取面包屑
     * */
    public function getbreadcrumbs($id, $data) {
        static $arr = array();
        foreach($data as $v) {
            if($v['id'] == $id) {
                $arr[$v['id']] = $v['catalog_name'];
                $this->getbreadcrumbs($v['parent_id'], $data);
            }
        }
        return $arr;
    }

    public function setpersoninfo($person_autoid, $useraccount) {
        set_cookie(array('name' => 'online', 'value' => 'time', 'expire' => time() + 1200, 'path' => '/', 'domain' => ''));
        set_cookie(array('name' => 'user_type', 'value' => 'person', 'expire' => time() + 3600, 'path' => '/', 'domain' => ''));
        set_cookie(array('name' => 'person_autoid', 'value' => $this->security->xss_clean($person_autoid), 'expire' => time() + 3600, 'path' => '/', 'domain' => ''));
        set_cookie(array('name' => 'person_username', 'value' => $this->security->xss_clean($useraccount), 'expire' => time() + 3600, 'path' => '/', 'domain' => ''));
    }

    public function deletepersoninfo() {
        delete_cookie('online');
        delete_cookie('user_type');
        delete_cookie('person_autoid');
        delete_cookie('person_username');
    }

    public function protocol($id) {

        $result = $this->db->query('select w.autoid, w.workname, p.content from t_pq_company_work w left join t_pq_protocol p on p.workid = w.autoid where autoid = ' . $id)->row_array();

        $this->load->view('protocol', array('result' => $result));
    }

    public function reply($workid) {
        //set_cookie(array('name' => 'person_autoid', 'value' => 203395, 'expire' => time() + 3600, 'path' => '/', 'domain' => ''));

        if(!get_cookie('person_autoid'))
            $this->xutils->message('error', '请您登陆后在操作');
        $isexist = $this->db->query('select count(id) as t from t_pq_reply where personid = '. get_cookie('person_autoid') . ' and workid = ' . $workid)->row_array();
        if($isexist['t'] > 0)
            $this->xutils->message('error', '此岗位您已应聘过，请选择其他的岗位');

        $companyinfo = $this->db->query('select c.companyid,c.companyname,w.workname,w.protocol from t_pq_company c left join t_pq_company_work w on c.companyid = w.companyid where w.autoid = ' . $workid)->row_array();
        $resumeinfo = $this->db->query('select * from t_resume_info_new where personid = ' . get_cookie('person_autoid'))->row_array();

        $edu = $this->config->item('education');
        $jobmanagemen = $this->config->item('jobmanagemen');
        if(isset($companyinfo['companyid']) && $companyinfo['companyid']) {
            $data = array(
                'workid' => $workid,
                'personid' => get_cookie('person_autoid'),
                'companyid' => $companyinfo['companyid'],
                'workname' => $companyinfo['workname'],
                'companyname' => $companyinfo['companyname'],
                'name' => $resumeinfo['personname'],
                'sex' => $resumeinfo['sex'],
                'school' => $resumeinfo['school'],
                'isp' => $companyinfo['protocol'],
                'replytime' => time(),
                //'age' => (time() - strtotime($resumeinfo['birth'])) / (60 * 60 * 24),
                'edu' => $edu[$resumeinfo['educer']],
                'major' => $jobmanagemen[$resumeinfo['specialtykey']],
                'mobile' => $resumeinfo['mobile'],
                'icard' => $resumeinfo['bianhao'],
                'marry' => $resumeinfo['marry'],
                'areanow' => $resumeinfo['areanowkey'],

            );
            $this->db->insert('pq_reply', $data);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '应聘成功');
            }
        } else {
            $this->xutils->message("error", '应聘失败');
        }
    }

    public function message() {
        if($this->xutils->method() == 'POST') {
            $_POST['Message']['comment'] = strip_tags($_POST['Message']['comment']);

            $_POST['Message']['ip'] = $this->input->ip_address();
            $_POST['Message']['createtime'] = time();
            $this->db->insert('pq_message', $_POST['Message']);
            if($this->db->affected_rows()) {
                $this->xutils->message("success", '提交成功');
            }
        }

        $this->load->view('message');
    }

    public function jumpkw() {
        redirect('home/keyword.html?kw=' . $this->input->get('kw') . '&per_page=' . $this->input->get('per_page'));
    }

    public function workskeywords() {
        $page = $this->input->get('p') ? $this->input->get('p') : 1;
        $keyword = $this->input->get('kw') ? $this->input->get('kw') : 1;
        $where = ' w.workname like "%' . $keyword . '%"';
        if($keyword)
            $query_string = 'kw=' . $keyword;

        $this->load->library('pagination');
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['query_string_segment'] = 'p';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $totel = $this->db->query('select count(*) as t from t_pq_company_work w left join t_pq_company c on w.companyid = c.companyid where '. $where)->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select w.*, c.companyname from t_pq_company_work w left join t_pq_company c on w.companyid = c.companyid where '. $where . ' order by w.autoid desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('workskeywords', array('result' => $result, 'page' => $this->pagination->create_links()));
    }

    public function newskeywords() {
        $page = $this->input->get('p') ? $this->input->get('p') : 1;
        $keyword = $this->input->get('kw') ? $this->input->get('kw') : 1;
        $where = ' p.title like "%' . $keyword . '%"';
        if($keyword)
            $query_string = 'kw=' . $this->security->xss_clean($keyword);

        $this->load->library('pagination');
        $config['base_url'] = $this->input->server('PHP_SELF') . '?' . $query_string;
        $config['query_string_segment'] = 'p';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $totel = $this->db->query('select count(*) as t from t_pq_post p left join t_pq_category c on p.catalog_id = c.id where '. $where)->row_array();
        $config['total_rows'] = $totel['t'];
        $start = ($page - 1) * $config['per_page'];

        $query = $this->db->query('select p.*, c.catalog_name as t from t_pq_post p left join t_pq_category c on p.catalog_id = c.id where '. $where . ' order by p.id desc limit ' . $start . ',' . $config['per_page']);
        $result = $query->result_array();

        $this->pagination->initialize($config);

        $this->load->view('newskeywords', array('result' => $result, 'page' => $this->pagination->create_links(), 'wiki' => $this->wk()));
    }

    public function getads($ids) {
        $ids = is_array($ids) ? implode(',', $ids) : $ids;

        $adv = $this->db->query('select * from t_pq_ads where status = 1 and pos in (' . $ids . ')')->result_array();
        $arr = array();
        foreach($adv as $val) {
            $arr[$val['pos']][] = $val;
        }

        return $arr;
    }

//    public function showlist() {
//        $where = 1;
//        if($this->input->get_post('title'))
//            $where .= ' and title like "%' . $this->input->get_post('title') . '%"';
//
//        $page = max(1, $this->input->get_post('page'));
//        $perpage = 2;
//        $totel = $this->db->query('select count(*) as t from t_pq_post where '. $where)->row_array();
//        $total_rows = $totel['t'];
//        $start = ($page - 1) * $perpage;
//
//        $query = $this->db->query('select * from t_pq_post where '. $where . ' order by id desc limit ' . $start . ',' . $perpage);
//        $result = $query->result_array();
//
//        $p = $this->multi($total_rows, $perpage, $page);
//
//        if($this->input->get_post('inajax')) {
//            echo json_encode(array('data' => $result, 'p' => $p));
//        } else {
//            $this->load->view('showlist', array('data' => $result, 'p' => $p, 'title' => $this->input->get_post('title')));
//        }
//    }

    //分页函数
    public function multi($num, $perpage, $curpage, $mpurl = '', $maxpages = 0, $page = 10, $autogoto = true, $simple = false) {
        $multipage = '';
        //$mpurl .= strpos($mpurl, '?') ? '&' : '?';
        $realpages = 1;
        if ($num > $perpage) {
            $offset = 2;

            $realpages = @ceil($num / $perpage);
            $pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;

            if ($page > $pages) {
                $from = 1;
                $to = $pages;
            } else {
                $from = $curpage - $offset;
                $to = $from + $page - 1;
                if ($from < 1) {
                    $to = $curpage + 1 - $from;
                    $from = 1;
                    if ($to - $from < $page) {
                        $to = $page;
                    }
                } elseif ($to > $pages) {
                    $from = $pages - $page + 1;
                    $to = $pages;
                }
            }
//注意下面href后面我增加了一个#号,让链接失效,在后面增加onclick函数
            $multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="javascript:void(0);"  onclick="gotoPage(1);" class="first"' . $ajaxtarget . '>1 ...</a>' : '') .
                ($curpage > 1 && !$simple ? '<a href="javascript:void(0);"  onclick="gotoPage(' . ($curpage - 1) . ');" class="prev">‹‹</a>' : '');
            for($i = $from; $i <= $to; $i++) {
                $multipage .= $i == $curpage ? '<strong>' . $i . '</strong>' :
                    '<a href="javascript:void(0);" onclick="gotoPage(' . $i .');" target="_blank" target="_blank">' . $i . '</a>';
            }

            $multipage .= ($curpage < $pages && !$simple ? '<a href="javascript:void(0);"  onclick="gotoPage(' . ($curpage + 1) . ');" class="next">››</a>' : '') .
                ($to < $pages ? '<a href="javascript:void(0);"  onclick="gotoPage(${pages});" class="last">... ' . $realpages . '</a>' : '') .
//下面这一行注释掉,改了一下超过10页,可以手动输入页码跳转到指定页面函数
//		(!$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\'' . $mpurl . 'page=\'+this.value; return false;}" /></kbd>' : '');
                (!$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {gotoPage(this.value);}" /></kbd>' : '');

            $multipage = $multipage ? '</div><DIV id="quicklinks">' . (!$simple ? '<em> ' . $num . ' </em>' : '') . $multipage . '</div>' : '';
        }
        $maxpage = $realpages;
        return $multipage;
    }


}