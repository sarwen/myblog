<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/9/29
 * Time: 9:56
 */
class BlogsModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //获取所有标签
    public function getAllTags()
    {
        $query = $this->db->query("SELECT * FROM tags");
        $res = $query->result_array();
        return $res;
    }

    //获取文章列表
    public function getArticle($offset = 0, $limit = 0)
    {
        if ($limit) {
            $query = $this->db->query("SELECT * FROM article where status=1 and id!=1 limit $offset,$limit");
        } else {
            $query = $this->db->query("SELECT * FROM article where  id!=1 and status=1");
        }
        $res = $query->result_array();
        return $res;
    }

    //获取标签文章列表
    public function getArticlesByTag($id, $offset = 0, $limit = 0)
    {
        if ($limit) {
            $query = $this->db->query("SELECT * FROM article where status=1 and category={$id} and id!=1 limit $offset,$limit");
        } else {
            $query = $this->db->query("SELECT * FROM article where status=1 and category={$id} and id!=1");
        }
        $res = $query->result_array();
        return $res;
    }

    //获取文章列表
    public function getAdminArticle($offset = 0, $limit = 0)
    {
        if ($limit) {
            $query = $this->db->query("SELECT * FROM article where  limit $offset,$limit");
        } else {
            $query = $this->db->query("SELECT * FROM article");
        }
        $res = $query->result_array();
        return $res;
    }

    //点击排行
    public function getSort($offset = 0, $limit = 0)
    {
        if ($limit) {
            $query = $this->db->query("SELECT * FROM article order by click DESC limit $offset,$limit");
        } else {
            $query = $this->db->query("SELECT * FROM article order by click DESC");
        }
        $res = $query->result_array();
        return $res;
    }

    //最新文章
    public function getNew($offset = 0, $limit = 0)
    {
        if ($limit) {
            $query = $this->db->query("SELECT * FROM article order by ctime desc limit $offset,$limit");
        } else {
            $query = $this->db->query("SELECT * FROM article order by click DESC");
        }
        $res = $query->result_array();
        return $res;
    }

    //站长推荐
    public function getRecommend($offset = 0, $limit = 0)
    {
        if ($limit) {
            $query = $this->db->query("SELECT * FROM article order by click DESC limit $offset,$limit");
        } else {
            $query = $this->db->query("SELECT * FROM article order by click DESC");
        }
        $res = $query->result_array();
        return $res;
    }

    //获取文章内容
    public function getArticleContent($id)
    {
        $query = $this->db->query("SELECT * FROM article WHERE id=$id");
        $res = $query->row_array();
        return $res;
    }

    //获取标签名
    public function getTagname($id)
    {
        $query = $this->db->query("SELECT * FROM tags WHERE id=$id");
        $res = $query->row_array();
        return $res;
    }

    //更新浏览量
    public function addScan($id)
    {
        $this->db->set('click', 'click+1', false);
        $this->db->where('id', $id);
        $res = $this->db->update('article');
        return $res;
    }

    //添加文章
    public function add($data)
    {
        $res = $this->db->insert('article', $data);
        return $res;
    }

    //更新文章
    public function upd($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('article', $data);
        return $res;
    }

    //添加标签
    public function addtag($data)
    {
        $res = $this->db->insert('tags', $data);
        return $res;
    }

    //获取标签
    public function getTag($id)
    {
        $query = $this->db->query("SELECT * FROM tags WHERE id=$id");
        $res = $query->row_array();
        return $res;
    }

    //更新标签
    public function updtag($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('tags', $data);
        return $res;
    }

    //获取banner配置列表
    public function getBannerList($type=0)
    {
        $sql = "SELECT * FROM banner";
        if($type!=0){
            $sql .= " where type={$type}";
        }
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }
    //添加banner
    public function addbaner($data)
    {
        $res = $this->db->insert('banner', $data);
        return $res;
    }

    //获取标签
    public function getBanner($id)
    {
        $query = $this->db->query("SELECT * FROM banner WHERE id=$id");
        $res = $query->row_array();
        return $res;
    }
    //更新banner
    public function updBanner($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('banner', $data);
        return $res;
    }
    //删除banner
    public function delBanner($id)
    {
        $this->db->where('id', $id);
        $res = $this->db->delete('banner');
        return $res;
    }


}