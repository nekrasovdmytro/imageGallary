<?php

namespace GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GalleryBundle\SimpleImage\SimpleImage;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="GalleryBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="images")
     * @ORM\JoinTable(
     *  name="image_category",
     *  joinColumns={
     *      @ORM\JoinColumn(name="imageId", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="categoryId", referencedColumnName="id")
     *  }
     * )
     */
    private $categories;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="isMain", type="boolean")
     */
    private $isMain;

    /**
     * @var string
     *
     * @ORM\Column(name="photoshootHash", type="string", length=32)
     */
    private $photoshootHash;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (is_file($this->getAbsolutePath())) {
            // store the old name to delete after the update
            $this->temp = $this->getAbsolutePath();
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {

            $this->path = md5(time() . $this->getFile()->getClientOriginalName()) . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        $simpleImage = new SimpleImage();
        $simpleImage->load($this->getAbsolutePath());
        $simpleImage->resizeToHeight(350);
        $simpleImage->save(str_replace('images', 'small_images', $this->getAbsolutePath()), \IMAGETYPE_JPEG, 99, 777);

        $this->setFile(null);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/images';
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set categoryId
     *
     * @param string $categoryId
     *
     * @return Image
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return string
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return Image
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Image
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categoryId = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categoryId
     *
     * @param \GalleryBundle\Entity\Category $categoryId
     *
     * @return Image
     */
    public function addCategoryId(\GalleryBundle\Entity\Category $categoryId)
    {
        $this->categoryId[] = $categoryId;

        return $this;
    }

    /**
     * Remove categoryId
     *
     * @param \GalleryBundle\Entity\Category $categoryId
     */
    public function removeCategoryId(\GalleryBundle\Entity\Category $categoryId)
    {
        $this->categoryId->removeElement($categoryId);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'path' => $this->path,
            'hash' => $this->photoshootHash
        ];
    }

    /**
     * Add category
     *
     * @param \GalleryBundle\Entity\Category $category
     *
     * @return Image
     */
    public function addCategory(\GalleryBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \GalleryBundle\Entity\Category $category
     */
    public function removeCategory(\GalleryBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set isMain
     *
     * @param boolean $isMain
     *
     * @return Image
     */
    public function setIsMain($isMain)
    {
        $this->isMain = $isMain;

        return $this;
    }

    /**
     * Get isMain
     *
     * @return boolean
     */
    public function getIsMain()
    {
        return $this->isMain;
    }

    /**
     * Set photoshootHash
     *
     * @param string $photoshootHash
     *
     * @return Image
     */
    public function setPhotoshootHash($photoshootHash)
    {
        $this->photoshootHash = $photoshootHash;

        return $this;
    }

    /**
     * Get photoshootHash
     *
     * @return string
     */
    public function getPhotoshootHash()
    {
        return $this->photoshootHash;
    }
}
