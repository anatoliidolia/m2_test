<?php
namespace Interactivated\Integration\Controller\Test;

use Magento\Framework\App\Action\Action;

class Index extends Action
{
    public function execute()
    {
        $contact = $this->_objectManager->create('Interactivated\Integration\Model\Integration');
        $contact->setName('Paul Dupond');
        $contact->save();

        $contact = $this->_objectManager->create('Interactivated\Integration\Model\Integration');
        $contact->setName('Paul Ricard');
        $contact->save();

        $contact = $this->_objectManager->create('Interactivated\Integration\Model\Integration');
        $contact->setName('Jack Daniels');
        $contact->save();
    }
}