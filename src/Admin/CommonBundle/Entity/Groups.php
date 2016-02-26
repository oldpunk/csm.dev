<?php

namespace Admin\CommonBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 * @ORM\HasLifecycleCallbacks()
 */
class Groups
{
    /**
     * @ORM\ManyToMany(targetEntity="Admin\CommonBundle\Entity\Users", inversedBy="groups")
     * @ORM\JoinTable(name="groups_members")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $title;
    /**
     * @ORM\Column(type="string")
     */
    private $content;
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_blocked;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;



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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param mixed $createAt
     * @ORM\PrePersist()
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param mixed $updateAt
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }


    public function setUsers(Users $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsBlocked()
    {
        return $this->is_blocked;
    }

    /**
     * @param mixed $is_blocked
     */
    public function setIsBlocked($is_blocked)
    {
        $this->is_blocked = $is_blocked;
    }

}