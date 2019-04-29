<?php
//Milestone 3
//Emily Quevedo
//February 28, 2019
//This is my own work

/* Group Object Model */
namespace App\Models;

class UserGroupModel {
    private $id;
    private $group_id;
    private $user_id;
    
    public function __construct($id, $group_id, $user_id) {
        $this->id = $id;
        $this->group_id = $group_id;
        $this->user_id = $user_id;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getGroup_id()
    {
        return $this->group_id;
    }

    /**
     * @return mixed
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $group_id
     */
    public function setGroup_id($group_id)
    {
        $this->group_id = $group_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    
}