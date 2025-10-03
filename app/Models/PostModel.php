<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'content', 'author_id'];
    protected $useTimestamps = true;
    
    public function getPosts()
    {
        return $this->findAll();
    }

    public function getPost($id)
    {
        return $this->find($id);
    }

    public function createPost($data)
    {
        return $this->insert($data);
    }

    public function updatePost($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deletePost($id)
    {
        return $this->delete($id);
    }
    public function getSlug($slug)
    {
        $db = db_connect();
        return $db->query("SELECT * FROM posts WHERE slug='".$db->escapeString($slug)."'");
    }
}
