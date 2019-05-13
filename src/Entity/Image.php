<?php
/**
 * Created by IntelliJ IDEA.
 * User: iaw49532078
 * Date: 5/13/19
 * Time: 5:46 PM
 */
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string $file
     *
     * @Assert\NotBlank(message="Please, upload an image first.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg", "image/jpg" })
     */
    private $file;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $alt;
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
    public function setId($id): void
    {
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
    /**
     * @param string $file
     */
    public function setFile($file)
    {
        if ($file) {
            $this->file = $file;
        }
    }
    /**
     * @return mixed
     */
    public function getAlt()
    {
        return $this->alt;
    }
    /**
     * @param mixed $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return 'imagen';
    }

}