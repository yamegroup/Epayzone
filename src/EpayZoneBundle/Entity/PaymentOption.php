<?php

namespace EpayZoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentOption
 *
 * @ORM\Table(name="payment_option")
 * @ORM\Entity(repositoryClass="EpayZoneBundle\Repository\PaymentOptionRepository")
 */
class PaymentOption
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
     * @ORM\OneToMany(targetEntity="EpayZoneBundle\Entity\PaymentOptionType", mappedBy="paymentOption")
     */
    private $paymentOptionType;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;


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
     * @return PaymentOption
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PaymentOption
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
     * Constructor
     */
    public function __construct()
    {
        $this->paymentOptionType = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add paymentOptionType
     *
     * @param \EpayZoneBundle\Entity\PaymentOptionType $paymentOptionType
     *
     * @return PaymentOption
     */
    public function addPaymentOptionType(\EpayZoneBundle\Entity\PaymentOptionType $paymentOptionType)
    {
        $this->paymentOptionType[] = $paymentOptionType;

        return $this;
    }

    /**
     * Remove paymentOptionType
     *
     * @param \EpayZoneBundle\Entity\PaymentOptionType $paymentOptionType
     */
    public function removePaymentOptionType(\EpayZoneBundle\Entity\PaymentOptionType $paymentOptionType)
    {
        $this->paymentOptionType->removeElement($paymentOptionType);
    }

    /**
     * Get paymentOptionType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentOptionType()
    {
        return $this->paymentOptionType;
    }
}
