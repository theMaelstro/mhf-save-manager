<?php


namespace MHFSaveManager\Model;

use MHFSaveManager\Service\ItemsService;

class DistributionItem
{
    /**
     * @var int
     */
    protected $type;
    
    
    /**
     * @var string
     */
    protected $itemId = "0000";
    
    
    /**
     * @var int
     */
    protected $amount;
    
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
    
    public function __construct($type, $itemId, $amount)
    {
        if ($itemString == "") {
            return;
        }
        $this->setType($type);
        $this->setItemId($itemId);
        $this->setAmount($amount);
    }
    
    public function __toString()
    {
        //return strtoupper(sprintf("%02X%04X%s%04X%04X%08X", $this->type, $this->unk1, $this->itemId, $this->unk2, $this->amount, $this->unk3));
		return strtoupper(sprintf("%s", $this->itemId));
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
     * @return DistributionItem
     */
    public function setType(int $type): DistributionItem
    {
        $this->type = $type;
        
        return $this;
    }
    
    
    /**
     * @return string
     */
    public function getItemId(bool $littleEndian = true): string
    {
        if ($littleEndian) {
            return substr($this->itemId,2, 2) . substr($this->itemId,0, 2);
        }
        
        return $this->itemId;
    }
    
    /**
     * @param string $itemId
     * @param bool $littleEndian
     * @return DistributionItem
     */
    public function setItemId(string $itemId, bool $littleEndian = true): DistributionItem
    {
        if (strlen($itemId) < 4) {
            $itemId = "0000";
        }
        if ($littleEndian) {
            $itemId = substr($itemId,2, 2) . substr($itemId,0, 2);
        }
        
        $this->itemId = strtoupper($itemId);
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
    
    /**
     * @param int $amount
     * @return DistributionItem
     */
    public function setAmount(int $amount): DistributionItem
    {
        $this->amount = $amount;
        
        return $this;
    }
}
