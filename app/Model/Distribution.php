<?php


/**
	COMMENT
	Modified the getters and setter functions for HR, SR, GR to include escape for NULL data type.
	
	Here is example of change:
	
	From original
	public function getMinHr(): int
    {
		return $this->min_hr;
    }
	
	To this
    public function getMinHr(): int
    {
		if (is_null($this->min_hr)) {
			return 65535;
		}
		else {
			return $this->min_hr;
		}
    }
	
	And for setter
	
	From original:
	public function setMinHr($min_hr): Distribution
    {
		$this->min_hr = $min_hr;      
        return $this;
    }
	
	To this
    public function setMinHr($min_hr): Distribution
    {
		if($min_hr == 65535) {
			$this->min_hr = null;
		}
		else {
			$this->min_hr = $min_hr;
		}        
        return $this;
    }
	
	These fixes are dirty, it will pass 0 as an int in getter when value is null in table so these values will be displayed as that in editor.
	For setter it will check if 65535 int was used (no limit) and change it to null before inserting into table.
	*/


namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="distribution")
 */
class Distribution
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $character_id;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $type;
    
    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $deadline;
    
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $event_name;
    
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $description;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $times_acceptable;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_hr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $max_hr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_sr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $max_sr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $min_gr;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $max_gr;
    
    /**
     * @ORM\Column(type="integer")
     * @var resource
     */
    protected $data;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    public static array $types = [
        0 => 'Bought',
        1 => 'Event',
        2 => 'Compensation',
        4 => 'Promo',
        6 => 'Subscription',
        7 => 'Event Item',
        8 => 'Promo Item',
        9 => 'Subscription Item',
    ];
    
    /**
     * @param int $id
     * @return Distribution
     */
    public function setId($id): Distribution
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCharacterId(): ?int
    {
        return $this->character_id;
    }
    
    /**
     * @param int $character_id
     * @return Distribution
     */
    public function setCharacterId($character_id): Distribution
    {
        $this->character_id = $character_id > 0 ? $character_id : null;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
    
    /**
     * @param int $type
     * @return Distribution
     */
    public function setType($type): Distribution
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getDeadline(): ?\DateTime
    {
        return $this->deadline;
    }
    
    /**
     * @param \DateTime|null $deadline
     * @return Distribution
     */
    public function setDeadline($deadline): Distribution
    {
        if (!$deadline instanceof \DateTime && !empty($deadline)) {
            $deadline = new \DateTime($deadline);
        } else if (empty($deadline)) {
            $deadline = null;
        }
        $this->deadline = $deadline;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEventName(): string
    {
        if (!preg_match('/^~C(\d\d)/', $this->event_name)) {
            return $this->event_name;
        }
    
        return substr($this->event_name, 4);
    }
    
    public function getEventNameColor(): string
    {
        $matches = [];
        preg_match('/^~C(\d\d)/', $this->event_name, $matches);
        
        return count($matches) > 1 ? $matches[1] : "";
    }
    
    /**
     * @param string $event_name
     * @return Distribution
     */
    public function setEventName(string $event_name): Distribution
    {
        if (!preg_match('/^~C(\d\d)/', $event_name)) {
            $event_name = '~C01' . $event_name;
        }
        $this->event_name = $event_name;
    
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDescription(): string
    {
        if (!preg_match('/^~C(\d\d)/', $this->description)) {
            return $this->description;
        }
    
        return substr($this->description, 4);
    }
    
    public function getDescriptionColor(): string
    {
        $matches = [];
        preg_match('/^~C(\d\d)/', $this->description, $matches);
    
        return count($matches) > 1 ? $matches[1] : "";
    }
    
    /**
     * @param string $description
     * @return Distribution
     */
    public function setDescription(string $description): Distribution
    {
        if (!preg_match('/^~C(\d\d)/', $description)) {
            $description = '~C01' . $description;
        }
        $this->description = $description;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getTimesAcceptable(): int
    {
        return $this->times_acceptable;
    }
    
    /**
     * @param int $times_acceptable
     * @return Distribution
     */
    public function setTimesAcceptable($times_acceptable): Distribution
    {
        $this->times_acceptable = $times_acceptable;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMinHr(): int
    {
		if (is_null($this->min_hr)) {
			return 65535;
		}
		else {
			return $this->min_hr;
		}
    }
    
    /**
     * @param int $min_hr
     * @return Distribution
     */
    public function setMinHr($min_hr): Distribution
    {
		if($min_hr == 65535) {
			$this->min_hr = null;
		}
		else {
			$this->min_hr = $min_hr;
		}        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMaxHr(): int
    {
		if (is_null($this->max_hr)) {
			return 65535;
		}
		else {
			return $this->max_hr;
		}
    }
    
    /**
     * @param int $max_hr
     * @return Distribution
     */
    public function setMaxHr($max_hr): Distribution
    {
		if($max_hr == 65535) {
			$this->max_hr = null;
		}
		else {
			$this->max_hr = $max_hr;
		}
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMinSr(): int
    {
		if (is_null($this->min_sr)) {
			return 65535;
		}
		else {
			return $this->min_sr;
		}
    }
    
    /**
     * @param int $min_sr
     * @return Distribution
     */
    public function setMinSr($min_sr): Distribution
    {
		if($min_sr == 65535) {
			$this->min_sr = null;
		}
		else {
			$this->min_sr = $min_sr;
		}        
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMaxSr(): int
    {
		if (is_null($this->max_sr)) {
			return 65535;
		}
		else {
			return $this->max_sr;
		}
    }
    
    /**
     * @param int $max_sr
     * @return Distribution
     */
    public function setMaxSr($max_sr): Distribution
    {
		if($max_sr == 65535) {
			$this->max_sr = null;
		}
		else {
			$this->max_sr = $max_sr;
		}
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMinGr(): int
    {
		if (is_null($this->min_gr)) {
			return 65535;
		}
		else {
			return $this->min_gr;
		}

    }
    
    /**
     * @param int $min_gr
     * @return Distribution
     */
    public function setMinGr($min_gr): Distribution
    {
		if($min_gr == 65535) {
			$this->min_gr = null;
		}
		else {
			$this->min_gr = $min_gr;
		}
        return $this;
    }
    
    /**
     * @return int
     */
    public function getMaxGr(): int
    {
		if (is_null($this->max_gr)) {
			return 65535;
		}
		else {
			return $this->max_gr;
		}
    }
    
    /**
     * @param int $max_gr
     * @return Distribution
     */
    public function setMaxGr($max_gr): Distribution
    {
		if($max_gr == 65535) {
			$this->max_gr = null;
		}
		else {
			$this->max_gr = $max_gr;
		}
        
        return $this;
    }
    
    /**
     * @return resource
     */
    public function getData(): int
    {
		if (is_null($this->data)) {
			return 0;
		}
		else {
			return $this->data;
		}
		
    }
    
    /**
     * @param resource $data
     * @return Distribution
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
