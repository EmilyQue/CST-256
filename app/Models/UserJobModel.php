<?php
//Milestone 5
//Emily Quevedo
//March 10, 2019
//This is my own work

/* User Job Object Model */
namespace App\Models;

class UserJobModel {
    private $id;
    private $job_id;
    private $user_id;
    
    public function __construct($id, $job_id, $user_id) {
        $this->id = $id;
        $this->job_id = $job_id;
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
    public function getJob_id()
    {
        return $this->job_id;
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
     * @param mixed $job_id
     */
    public function setJob_id($job_id)
    {
        $this->job_id = $job_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    
}