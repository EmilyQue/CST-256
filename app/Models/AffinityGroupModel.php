<?php
//Milestone 3
//Emily Quevedo
//February 28, 2019
//This is my own work

/* Group Object Model */
namespace App\Models;

class AffinityGroupModel {
    private $id;
    private $groupName;
    private $groupDescription;
    
    public function __construct($id, $groupName, $groupDescription) {
        $this->id = $id;
        $this->groupName = $groupName;
        $this->groupDescription = $groupDescription;
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
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @return mixed
     */
    public function getGroupDescription()
    {
        return $this->groupDescription;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @param mixed $groupDescription
     */
    public function setGroupDescription($groupDescription)
    {
        $this->groupDescription = $groupDescription;
    }
}