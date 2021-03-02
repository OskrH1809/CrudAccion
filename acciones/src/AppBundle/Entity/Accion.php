<?php
namespace ExpedientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GeneralBundle\Utils\Util;
use Doctrine\Common\Persistence\ObjectManagerAware;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Symfony\Component\Intl\Locale;

/**
 * @ORM\Entity
 * @ORM\Table(name="acciones")
 */
class Accion implements ObjectManagerAware{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue 
     */
    protected $id;
    /** @ORM\Column(type="string") */
    protected $slug;
    /** @ORM\Column(type="string") */
    protected $texto;
    /** @ORM\OneToMany(targetEntity="TraduccionAccion", mappedBy="accion") */
    private $idiomas;
    /** @ORM\ManyToMany(targetEntity="GeneralBundle\Entity\Nivel", mappedBy="acciones") */
    private $niveles;
    /** @ORM\Column(type="boolean", options={"default":0}) */
    protected $activo; 
    /** @ORM\Column(type="boolean", options={"default":0}) */
    protected $or;
    /** @ORM\Column(type="string") */
    protected $siglas;
    /** @ORM\Column(type="boolean", options={"default":0}) */
    protected $verPresupuestar;

    public function __toString()
    {
        return $this->getTexto();
    }
    
    public function __construct() {
        $this->niveles = new ArrayCollection();
        $this->idiomas = new ArrayCollection();
    }
    
    public function injectObjectManager(ObjectManager $objectManager, ClassMetadata $classMetadata) {
        $this->em = $objectManager;
    }
    
    function getLocale() {

        $locale = Locale::getDefault();
        $translate = $this->em->getRepository('ExpedientesBundle:TraduccionAccion')->findOneBy(array('accion' => $this->getId(), 'idioma' => $locale));

        if($translate){            
            return $translate->getNombre();
        }

        return $this->getTexto();
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Accion
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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
     * Set texto
     *
     * @param string $texto
     *
     * @return Accion
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
        $this->slug = Util::getSlug($texto);

        return $this;
    }

    /**
     * Get texto
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Add idioma
     *
     * @param \ExpedientesBundle\Entity\TraduccionAccion $idioma
     *
     * @return Accion
     */
    public function addIdioma(\ExpedientesBundle\Entity\TraduccionAccion $idioma)
    {
        $this->idiomas[] = $idioma;

        return $this;
    }

    /**
     * Remove idioma
     *
     * @param \ExpedientesBundle\Entity\TraduccionAccion $idioma
     */
    public function removeIdioma(\ExpedientesBundle\Entity\TraduccionAccion $idioma)
    {
        $this->idiomas->removeElement($idioma);
    }

    /**
     * Get idiomas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdiomas()
    {
        return $this->idiomas;
    }

    /**
     * Add nivele
     *
     * @param \GeneralBundle\Entity\Nivel $nivele
     *
     * @return Accion
     */
    public function addNivele(\GeneralBundle\Entity\Nivel $nivele)
    {
        $this->niveles[] = $nivele;

        return $this;
    }

    /**
     * Remove nivele
     *
     * @param \GeneralBundle\Entity\Nivel $nivele
     */
    public function removeNivele(\GeneralBundle\Entity\Nivel $nivele)
    {
        $this->niveles->removeElement($nivele);
    }

    /**
     * Get niveles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNiveles()
    {
        return $this->niveles;
    }
    
    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Accion
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }    

    /**
     * Set or
     *
     * @param boolean $or
     *
     * @return Accion
     */
    public function setOr($or)
    {
        $this->or = $or;

        return $this;
    }

    /**
     * Get or
     *
     * @return boolean
     */
    public function getOr()
    {
        return $this->or;
    }

    /**
     * Set siglas
     *
     * @param string $siglas
     *
     * @return Accion
     */
    public function setSiglas($siglas)
    {
        $this->siglas = $siglas;

        return $this;
    }

    /**
     * Get siglas
     *
     * @return string
     */
    public function getSiglas()
    {
        return $this->siglas;
    }

    /**
     * Set verPresupuestar
     *
     * @param boolean $verPresupuestar
     *
     * @return Accion
     */
    public function setVerPresupuestar($verPresupuestar)
    {
        $this->verPresupuestar = $verPresupuestar;

        return $this;
    }

    /**
     * Get verPresupuestar
     *
     * @return boolean
     */
    public function getVerPresupuestar()
    {
        return $this->verPresupuestar;
    }
}
