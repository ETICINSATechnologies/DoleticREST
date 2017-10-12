<?php

namespace KernelBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UsersMailingList
 *
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\UsersMailingListRepository")
 */
class CustomMailingList extends MailingList
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(
     *     name="kernel_custom_mailing_users",
     *     joinColumns={@ORM\JoinColumn(name="mailing_list_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $users;

    /**
     * @var boolean
     * @ORM\Column(name="default", type="boolean")
     */
    private $default;

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     * @return UsersMailingList
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * @param boolean $default
     * @return UsersMailingList
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

}

