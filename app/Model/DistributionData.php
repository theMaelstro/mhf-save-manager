<?php

namespace MHFSaveManager\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="distribution_items")
 */
class DistributionData
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
    protected $distribution_id;
    
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $item_type;
	
	/**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $item_id;
	
	/**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $quantity;
	
	public static array $types = [
        0 => 'Legs',
        1 => 'Head',
        2 => 'Chest',
        3 => 'Arms',
        4 => 'Waist',
        5 => 'Melee',
        6 => 'Ranged',
        7 => 'Item',
        8 => 'Furniture',
        //9 => '9',
        10 => 'Zenny',
        //11 => '11',
        12 => 'Festi Points',
        //13 => '13',
        14 => 'TorePoint',
        15 => 'Poogie Outfits',
        16 => 'Restyle Points',
        17 => 'N Points',
        18 => 'GoocooOutfit',
        19 => 'Gacha Coins',
        20 => 'Trial Gacha Coins',
        21 => 'Frontier Points',
        //22 => '22',
        23 => 'Ryoudan Points (RP)',
        //24 => '24',
        25 => 'Bond Points',
        //26 => '26',
        //27 => '27',
        28 => 'Special Hall',
        29 => 'Song Note',
        30 => 'Item Box Pages',
        31 => 'Equipment Box Pages',
    ];
    
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    
    /**
     * @param int $id
     * @return DistributionData
     */
    public function setId($id): DistributionData
    {
        $this->id = $id;
        
        return $this;
    }
	
	/**
     * @return int
     */
    public function getDistributionId(): int
    {
        return $this->distribution_id;
    }
    
    /**
     * @param int $distribution_id
     * @return DistributionData
     */
    public function setDistributionId(int $distribution_id): DistributionData
    {
        $this->distribution_id = $distribution_id;
        
        return $this;
    }
	
	
	/**
     * @return int
     */
    public function getType(): int
    {
        return $this->item_type;
    }
    
    /**
     * @param int $item_type
     * @return DistributionData
     */
    public function setType(int $item_type): DistributionData
    {
        $this->item_type = $item_type;
        
        return $this;
    }
	
	/**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->item_id;
    }
    
    /**
     * @param int $item_id
     * @return DistributionData
     */
    public function setItemId(int $item_id): DistributionData
    {		
        $this->item_id = $item_id;
        
        return $this;
    }
	
	/**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    
    /**
     * @param int $quantity
     * @return DistributionData
     */
    public function setQuantity(int $quantity): DistributionData
    {
        $this->quantity = $quantity;
        
        return $this;
    }
}
