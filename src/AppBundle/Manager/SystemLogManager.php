<?php
namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\SystemLog;
use AppBundle\Entity\User;

class SystemLogManager
{
    private $om;

    function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function update(SystemLog $systemLog, $flush = false)
    {
        $this->om->persist($systemLog);
        if ($flush) {
            $this->om->flush();
        }
    }

    public function delete(SystemLog $systemLog)
    {
        $this->om->remove($systemLog);
        $this->om->flush();
    }

    public function disable(SystemLog $systemLog)
    {
        $systemLog->setEnabled(false);
        $this->update($systemLog, true);
    }
}