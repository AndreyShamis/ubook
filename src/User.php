<?php
/**
 * Created by PhpStorm.
 * User: ashamis
 * Date: 14.10.18
 * Time: 13:00
 */

//use Doctrine\ORM\Annotation as ORM;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 **/
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     **/
    private $firstName;

    /**
     * @ORM\Column(type="string")
     **/
    private $lastName;

    /**
     * @ORM\Column(type="integer")
     **/
    private $specialId;

    /**
     * @ORM\Column(type="string")
     **/
    private $address;

    /**
     * @ORM\Column(type="string")
     **/
    private $phone;

    /**
     * @ORM\Column(type="string")
     **/
    private $support;

    /**
     * @ORM\Column(type="integer")
     **/
    private $siteId;

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
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getSpecialId()
    {
        return $this->specialId;
    }

    /**
     * @param mixed $specialId
     */
    public function setSpecialId($specialId): void
    {
        $this->specialId = $specialId;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * @param mixed $support
     */
    public function setSupport($support): void
    {
        $this->support = $support;
    }

    /**
     * @return mixed
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @param mixed $siteId
     */
    public function setSiteId($siteId): void
    {
        $this->siteId = $siteId;
    }

}