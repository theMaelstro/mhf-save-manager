<?php

namespace MHFSaveManager\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\Distribution;
use MHFSaveManager\Model\DistributionItem;
use MHFSaveManager\Model\DistributionData;
use MHFSaveManager\Service\ItemsService;
use MHFSaveManager\Service\ResponseService;
use MHFSaveManager\Model\Character;

/**
 *
 */
class DistributionsController extends AbstractController
{
    protected static string $itemName = 'distribution';
    protected static string $itemClass = Distribution::class;
    
    public static function Index()
    {
        $distributions = EM::getInstance()->getRepository(self::$itemClass)->findAll();
        $characters = \MHFSaveManager\Database\EM::getInstance()->getRepository(Character::class)->findAll();
        
        
        include_once ROOT_DIR . '/app/Views/distributions.php';
    }
    
    public static function IndexTest()
    {
        $distributions = EM::getInstance()->getRepository(self::$itemClass)->findAll();
    
        /** @var Distribution $distribution */
        foreach ($distributions as $distribution) {
            echo '<hr>';
            printf('Name: %s <br>', $distribution->getEventName());
            printf('Desc: %s <br>', $distribution->getDescription());
            printf('Type: %s <br>', Distribution::$types[$distribution->getType()]);
            echo '<br><b>Items:</b><br>';
            $data = $distribution->getData();
            $numberOfItems = hexdec(bin2hex(fread($data, 2)));
            
            for ($i = 0; $i < $numberOfItems; $i++) {
                $item = new DistributionItem(bin2hex(fread($data, 13)));
                printf('Reencoded hex value: %s<br>', $item);
                printf('ItemNr: %s <br>Type: %s <br>Item: %s <br>Amount: %s<br><br>', $i+1, DistributionItem::$types[$item->getType()], ItemsService::getForLocale()[$item->getItemId()]['name'], $item->getAmount());
                
            }
            
        }
        echo "<hr>";
    }
    
    public static function EditDistribution()
    {
        $distribution = new Distribution();
    
        if (isset($_POST['id']) && $_POST['id'] > 0) {
            $distribution = EM::getInstance()->getRepository(self::$itemClass)->find($_POST['id']);
        } else {
            EM::getInstance()->persist($distribution);
        }
        
        $distribution->setType($_POST['type']);
        $distribution->setCharacterId((int)$_POST['characterId']);
        $distribution->setTimesAcceptable((int)$_POST['timesacceptable']);
        $distribution->setEventName($_POST['name']);
        $distribution->setDescription($_POST['desc']);
        $distribution->setDeadline($_POST['deadline'] ? new \DateTime($_POST['deadline']) : null);
        $distribution->setMinHr((int)$_POST['minhr']);
        $distribution->setMaxHr((int)$_POST['maxhr']);
        $distribution->setMinSr((int)$_POST['minsr']);
        $distribution->setMaxSr((int)$_POST['maxsr']);
        $distribution->setMinGr((int)$_POST['mingr']);
        $distribution->setMaxGr((int)$_POST['maxgr']);	
		
        foreach ($_POST['items'] as $item) {
			$distribution_data = new DistributionData();
				
			if (isset($_POST['id']) && $_POST['id'] > 0) {
				$distribution_data = EM::getInstance()->getRepository(self::$itemClass)->find($_POST['id']);
			} 
			else {
				EM::getInstance()->persist($distribution_data);
			}
			
			$distribution_data->setDistributionId($distribution->getId());
			$distribution_data->setItemId((int)hexdec(substr($item['itemId'],2, 2) . substr($item['itemId'],0, 2)));
			$distribution_data->setType((int)$item['type']);
			$distribution_data->setQuantity((int)$item['amount']);			

			EM::getInstance()->flush();
			ResponseService::SendOk();
        }
		
		
        $distribution->setData($_POST['items'][0]['amount']);
        
        EM::getInstance()->flush();
    
        ResponseService::SendOk();
        
    }
    
    /**
     * @return void
     */
    public static function ExportDistributions(): void
    {
        $records = EM::getInstance()->getRepository(self::$itemClass)->findAll();
        self::arrayOfModelsToCSVDownload($records);
    }
    
    /**
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public static function ImportDistributions(): void
    {
        self::importFromCSV();
    }
}
