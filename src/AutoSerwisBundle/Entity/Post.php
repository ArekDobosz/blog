<?php

namespace AutoSerwisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AutoSerwisBundle\Repository\PostRepository")
 * @ORM\Table(name="post")
 * @ORM\HasLifecycleCallbacks
 */
class Post {
    
    const DEFAULT_THUMBNAIL = 'default-thumbnail.jpg';
    const UPLOAD_DIR = 'uploads/thumbnails/';
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=120, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $title;
    
    /**
     * @ORM\Column(type="string", length=40, unique=true)
     */
    private $slug;
    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 1500
     * )
     */
    private $content;
    
    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $thumbnail = null;
    
    /**
     * @var UploadedFile
     * 
     * @Assert\Image(
     *      minWidth = 300,
     *      minHeight = 300,
     *      maxWidth = 1920,
     *      maxHeight = 1080,
     *      maxSize = "7M"
     * )
     */
    private $thumbnailFile;
    
    private $thumbnailTemp;
    
    /**
     * @ORM\ManyToOne(
     *      targetEntity = "Category",
     *      inversedBy = "posts"
     * )
     * @ORM\JoinColumn(
     *      name = "category_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL",
     *      nullable = true
     * )
     */
    private $category;
    
    /**
     * @ORM\ManyToMany(
     *      targetEntity = "Tag",
     *      inversedBy = "posts"
     * )
     * @ORM\JoinTable(
     *      name = "post_tags"
     * )
     */
    private $tags;
    
    /**
     * @ORM\ManyToOne(
     *      targetEntity = "User"
     * )
     * @ORM\JoinColumn(
     *      name = "author_id",
     *      referencedColumnName = "id",
     * )
     */
    private $author;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $createDate;  
    
    /**
     * @ORM\OneToMany(
     *      targetEntity = "Comment",
     *      mappedBy = "post"
     * )
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $comments;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateDate;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getThumbnailFile() {
        return $this->thumbnailFile;
    }
    
    public function setThumbnailFile(UploadedFile $thumbnailFile) {
        $this->thumbnailFile = $thumbnailFile;
        $this->updateDate = new \DateTime();
        return $this;
    }
    
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
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = \AutoSerwisBundle\Libs\Utils::sluggify($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
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
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Post
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        if($this->thumbnail == null) {
            return POST::UPLOAD_DIR.POST::DEFAULT_THUMBNAIL;
        }
        return POST::UPLOAD_DIR.$this->thumbnail;
    }

    /**
     * Set author
     *
     * @param \AutoSerwisBundle\Entity\User $author
     *
     * @return Post
     */
    public function setAuthor(\AutoSerwisBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return AutoSerwisBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Post
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set category
     *
     * @param \AutoSerwisBundle\Entity\Category $category
     *
     * @return Post
     */
    public function setCategory(\AutoSerwisBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AutoSerwisBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tag
     *
     * @param \AutoSerwisBundle\Entity\Tag $tag
     *
     * @return Post
     */
    public function addTag(\AutoSerwisBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AutoSerwisBundle\Entity\Tag $tag
     */
    public function removeTag(\AutoSerwisBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preSave() {
        if(null === $this->slug){
            $this->setSlug($this->getTitle());
        }
        
        if(null !== $this->getThumbnailFile()) {
            if(null !== $this->thumbnail){
                $this->thumbnailTemp = $this->thumbnail;
            }
            $thumbnailName = sha1(uniqid(null, true));
            $this->thumbnail = $thumbnailName.'.'.$this->getThumbnailFile()->guessExtension();
        }
    }
    
    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function postSave() {
        if(null !== $this->getThumbnailFile()) {
            $this->getThumbnailFile()->move($this->getUploadedRootDir(), $this->thumbnail);
            unset($this->thumbnailFile);
            
            if(null !== $this->thumbnailTemp){
                unlink($this->getUploadedRootDir().$this->thumbnailTemp);
                unset($this->thumbnailTemp);
            }
        }
    }

    /**
     * Add comment
     *
     * @param \AutoSerwisBundle\Entity\Comment $comment
     *
     * @return Post
     */
    public function addComment(\AutoSerwisBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AutoSerwisBundle\Entity\Comment $comment
     */
    public function removeComment(\AutoSerwisBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return User
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }
    
    public function getUploadedRootDir(){
        return __DIR__.'/../../../web/'.POST::UPLOAD_DIR;
    }
}
