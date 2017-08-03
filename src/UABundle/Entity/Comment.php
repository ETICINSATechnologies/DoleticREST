<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Model\SignedCommentInterface;
use KernelBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Comment extends BaseComment implements SignedCommentInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return string
     */
    public function getAncestors()
    {
        return $this->ancestors;
    }

    /**
     * Project of this comment
     *
     * @var Project
     * @ORM\ManyToOne(targetEntity="UABundle\Entity\Project")
     */
    protected $project;

    /**
     * Author of the comment
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     * @var User
     */
    protected $author;

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Sets the author of the Comment
     *
     * @param UserInterface $author
     */
    public function setAuthor(UserInterface $author)
    {
        $this->author=$author;
    }


}