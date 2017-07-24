<?php

namespace AutoSerwisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Comment {
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(
     *      targetEntity = "Post",
     *      inversedBy = "comments"
     * )
     * @ORM\JoinColumn(
     *      name = "post_id",
     *      referencedColumnName = "id",
     *      nullable = false
     * )
     */
    private $post;
    
    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 1000
     * )
     */
    private $content;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * @ORM\ManyToOne(
     *      targetEntity = "User"
     * )
     * @ORM\JoinColumn(
     *      name = "author_id",
     *      referencedColumnName = "id",
     *      nullable = false
     * )
     */
    private $author;
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set post
     *
     * @param \AutoSerwisBundle\Entity\Post $post
     *
     * @return Comment
     */
    public function setPost(\AutoSerwisBundle\Entity\Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \AutoSerwisBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
    function __construct() {
        $this->createdAt = new \DateTime();
    }

    /**
     * Set author
     *
     * @param \AutoSerwisBundle\Entity\User $author
     *
     * @return Comment
     */
    public function setAuthor(\AutoSerwisBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AutoSerwisBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
