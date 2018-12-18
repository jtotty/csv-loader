<?php declare(strict_types=1);

namespace Jtotty\CsvLoader;

use Doctrine\ORM\Mapping as ORM;

class Entity
{
    /**
     * @ORM\Column()
     */
    protected $forename;

    /**
     * @ORM\Column()
     */
    protected $surname;

    /**
     * @ORM\Column()
     */
    protected $gender;

    /**
     * @ORM\Column()
     */
    protected $dob;

    /**
     * @ORM\Column()
     */
    protected $year;

    /**
     * @ORM\Column()
     */
    protected $reg;

    /**
     * @ORM\Column()
     */
    protected $eal;

    /**
     * @ORM\Column()
     */
    protected $premium;

    /**
     * @ORM\Column()
     */
    protected $meals;

    /**
     * @ORM\Column()
     */
    protected $care;

    public function setForename()
    {
        $this->forename = $forename;
    }

    public function setSurname()
    {
        $this->surname = $surname;
    }

    public function setGender()
    {
        $this->gender = $gender;
    }

    public function setDob()
    {
        $this->dob = $dob;
    }

    public function setYear()
    {
        $this->year = $year;
    }

    public function setReg()
    {
        $this->reg = $reg;
    }

    public function setEal()
    {
        $this->eal = $eal;
    }

    public function setPremium()
    {
        $this->premium = $premium;
    }

    public function setMeals()
    {
        $this->meals = $meals;
    }
}