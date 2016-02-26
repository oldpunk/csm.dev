<?php

namespace Admin\CommonBundle\Entity;

use Admin\CommonBundle\Entity\Interfaces\HasFiles;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Admin\CommonBundle\Repository\UsersRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("login", message="Данный пользователь уже существует!")
 */
class Users implements HasFiles, UserInterface, \Serializable
{
    /**
     * @ORM\ManyToMany(targetEntity="Admin\CommonBundle\Entity\Groups", mappedBy="users" )
     */
    private $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(message="Поле не может быть пустым")
     */
    private $login;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;
    /**
     * @ORM\Column(type="string")
     */
    private $fio;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string", nullable=true)
     *
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBlocked;
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
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        if(!is_null($password)){
            $this->password = $password;
        }
    }

    /**
     * @return mixed
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * @param mixed $fio
     */
    public function setFio($fio)
    {
        $this->fio = $fio;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * @param mixed $isBlocked
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;
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

    public function getUploadDir()
    {
        return 'uploads/admin/users/';
    }

    public function getWebPath($file)
    {
        return $this->getUploadDir().$file;
    }

    public function getFileValues()
    {
        return array(
          $this->getAvatar()
        );
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->login,
            $this->password
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->login,
            $this->password
        ) = unserialize($serialized);
    }

    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }


    public function setGroups(Groups $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }
}