<?php

namespace AutoSerwisBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    const DEFAULT_AVATAR = 'default.png';
    const UPLOAD_DIR = 'uploads/avatars/';
    
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $firstName;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $lastName;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $updateDate;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $avatar;
    
    /**
     * @var UploadedFile
     * 
     * @Assert\Image(
     *      minWidth = 50,
     *      maxWidth = 800,
     *      minHeight = 50,
     *      maxHeight = 800,
     *      maxSize = "1M",
     * )
     */
    private $avatarFile;

    private $avatarTemp; 
    
    public function getAvatarFile() {
        return $this->avatarFile;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setAvatarFile(UploadedFile $avatarFile) {
        $this->avatarFile = $avatarFile;
        $this->updateDate = new \DateTime();
        return $this;
    }
    
    public function __construct()
    {
        parent::__construct();
        $this->updateDate = new \DateTime();
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {        
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        if($this->avatar == null){
            return User::UPLOAD_DIR.USER::DEFAULT_AVATAR; // konkatenacja zwróci uploads/avatars/default-avatar.jpg
        }
        return User::UPLOAD_DIR.$this->avatar;
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
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preSave() {
        if(null !== $this->getAvatarFile()){
            
            if(null !== $this->avatar){
                $this->avatarTemp = $this->avatar;
            }
            $avatarName = sha1(uniqid(null, true));
            $this->avatar = $avatarName.'.'.$this->getAvatarFile()->guessExtension();
        }       
    }
    
    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function postSave(){
        if(null !== $this->getAvatarFile()){
            
            $this->getAvatarFile()->move($this->getUploadedRootDir(), $this->avatar);
            unset($this->avatarFile);
            
            if(null !== $this->avatarTemp){
                unlink($this->getUploadedRootDir().$this->avatarTemp);
                unset($this->avatarTemp);
            }
        }
    }
    
    public function getUploadedRootDir(){
        return __DIR__.'/../../../web/'.User::UPLOAD_DIR;
    }
}
